<?php

declare(strict_types=1);

namespace App\Exception\Action;

use App\Exception\ExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Throwable;

class ActionNotFoundException extends \InvalidArgumentException implements ExceptionInterface, NotFoundExceptionInterface
{
    private string $action;
    private ?string $route;

    public function __construct(string $action, ?string $route, $code = 0, Throwable $previous = null)
    {
        $message = sprintf(
            'Action "%s" not found for route "%s"',
            $action ?? 'NULL',
            $route ?? 'NULL'
        );

        parent::__construct($message, $code, $previous);

        $this->action = $action;
        $this->route = $route;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getRoute(): ?string
    {
        return $this->route;
    }
}
