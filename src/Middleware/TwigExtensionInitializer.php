<?php

declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Twig\Environment;
use Twig\Extension\ExtensionInterface;

/**
 * Init Twig extensions
 */
final class TwigExtensionInitializer implements MiddlewareInterface
{
    /** @var Environment */
    private Environment $environment;

    /** @var iterable|ExtensionInterface[] */
    private iterable $twigExtensions;

    public function __construct(Environment $environment, iterable $twigExtensions)
    {
        $this->environment = $environment;
        $this->twigExtensions = $twigExtensions;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        foreach ($this->twigExtensions as $extension) {
            $this->environment->addExtension($extension);
        }

        return $handler->handle($request);
    }
}
