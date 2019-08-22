<?php

declare(strict_types=1);

namespace App\Responder;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Twig\Environment;

class ExceptionResponder
{
    /** @var ResponseFactoryInterface */
    private $responseFactory;

    /** @var StreamFactoryInterface */
    private $streamFactory;

    /** @var Environment */
    private $twig;

    /** @var string */
    private $projectDir;

    /** @var string */
    private $environment;

    public function __construct(
        ResponseFactoryInterface $responseFactory,
        StreamFactoryInterface $streamFactory,
        Environment $twig,
        string $projectDir,
        string $environment
    ) {
        $this->responseFactory = $responseFactory;
        $this->streamFactory = $streamFactory;
        $this->twig = $twig;
        $this->projectDir = $projectDir;
        $this->environment = $environment;
    }

    public function respond(ServerRequestInterface $request, \Throwable $throwable): ResponseInterface
    {
        $this->twig->addGlobal('request', $request->getAttributes());

        $statusCode = 500;
        if ($throwable instanceof ResourceNotFoundException) {
            $statusCode = 404;
        } elseif ($throwable instanceof MethodNotAllowedException) {
            $statusCode = 405;
        }

        $template = sprintf("errors/%d.html.twig", $statusCode);
        if (!file_exists($this->projectDir.'/templates/'.$template)) {
            $template = 'errors/default.html.twig';
        }

        $data = $this->environment !== 'prod' ? ['exception' => $throwable] : [];

        return $this
            ->responseFactory
            ->createResponse($statusCode)
            ->withBody($this
                ->streamFactory
                ->createStream($this
                    ->twig
                    ->render($template, $data)))
            ->withProtocolVersion($request->getProtocolVersion())
            ->withHeader('Content-Type', 'text/html; charset=UTF-8');
    }
}
