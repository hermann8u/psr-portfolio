<?php

declare(strict_types=1);

namespace App\Twig;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    /** @var UrlGeneratorInterface */
    private $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('url', [$this->urlGenerator, 'generate']),
            new TwigFunction('debug_microtime', [$this, 'debugMicrotime']),
        ];
    }

    public function debugMicrotime()
    {
        return round((microtime(true) - APP_START) * 1000);
    }
}
