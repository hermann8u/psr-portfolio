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
use Twig\Error\LoaderError;

class ExceptionResponder
{
    private ResponseFactoryInterface $responseFactory;
    private StreamFactoryInterface $streamFactory;
    private Environment $twig;
    private bool $debug;

    public function __construct(
        ResponseFactoryInterface $responseFactory,
        StreamFactoryInterface $streamFactory,
        Environment $twig,
        bool $debug
    ) {
        $this->responseFactory = $responseFactory;
        $this->streamFactory = $streamFactory;
        $this->twig = $twig;
        $this->debug = $debug;
    }

    public function respond(ServerRequestInterface $request, \Throwable $throwable): ResponseInterface
    {
        if (true === $this->debug) {
            throw $throwable;
        }

        $this->twig->addGlobal('request', $request->getAttributes());

        $statusCode = 500;
        if ($throwable instanceof ResourceNotFoundException) {
            $statusCode = 404;
        } elseif ($throwable instanceof MethodNotAllowedException) {
            $statusCode = 405;
        }

        $template = sprintf('errors/%d.html.twig', $statusCode);
        try {
            $content = $this->twig->render($template);
        } catch (LoaderError $error) {
            $content = $this->twig->render('errors/default.html.twig');
        }

        $stream = $this->streamFactory->createStream($content);

        return $this
            ->responseFactory
            ->createResponse($statusCode)
            ->withBody($stream)
            ->withProtocolVersion($request->getProtocolVersion())
            ->withHeader('Content-Type', 'text/html; charset=UTF-8');
    }
}
