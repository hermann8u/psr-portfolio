<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Responder\ExceptionResponder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

/**
 * This middleware should be the first of the stack.
 *
 * @see https://www.php-fig.org/psr/psr-15/#14-handling-exceptions
 */
final class ExceptionHandler implements MiddlewareInterface
{
    private ExceptionResponder $responder;

    public function __construct(ExceptionResponder $responder)
    {
        $this->responder = $responder;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $response = $handler->handle($request);
        } catch (Throwable $exception) {
            $response = $this->responder->respond($request, $exception);
        }

        return $response;
    }
}
