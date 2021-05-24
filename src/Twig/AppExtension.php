<?php

declare(strict_types=1);

namespace App\Twig;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class AppExtension extends AbstractExtension
{
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('url', [$this->urlGenerator, 'generate']),
            new TwigFunction('execution_time', [$this, 'executionTime']),
        ];
    }

    public function executionTime(): ?float
    {
        return round((microtime(true) - APP_START) * 1000) ?: null;
    }
}
