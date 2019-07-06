<?php

declare(strict_types=1);

namespace App\Responder;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Twig\Environment;

class Responder
{
    /**
     * @var ResponseFactoryInterface
     */
    private $responseFactory;

    /**
     * @var StreamFactoryInterface
     */
    private $streamFactory;

    /**
     * @var Environment
     */
    private $twig;

    public function __construct(ResponseFactoryInterface $responseFactory, StreamFactoryInterface $streamFactory, Environment $twig)
    {
        $this->responseFactory = $responseFactory;
        $this->streamFactory = $streamFactory;
        $this->twig = $twig;
    }

    public function respond(ServerRequestInterface $request, string $template, array $data = []): ResponseInterface
    {
        $this->twig->addGlobal('request', $request->getAttributes());

        return $this
            ->responseFactory
            ->createResponse()
            ->withBody($this
                ->streamFactory
                ->createStream($this
                    ->twig
                    ->render($template, $data)))
            ->withProtocolVersion($request->getProtocolVersion())
            ->withHeader('Content-Type', 'text/html; charset=UTF-8');
    }
}
