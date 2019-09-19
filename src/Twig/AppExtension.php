<?php

declare(strict_types=1);

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('debug_microtime', [$this, 'debugMicrotime']),
        ];
    }

    public function debugMicrotime()
    {
        return round((microtime(true) - APP_START) * 1000);
    }
}
