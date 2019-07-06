<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Exception\Action\ActionNotFoundException;
use App\Exception\Action\InvalidActionReturnTypeException;
use App\Exception\Action\InvalidActionTypeException;
use App\Responder\Responder;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * The action handler try to execute an action based on the request and return the response from it.
 * That's why this middleware has to be the last of the stack.
 */
final class ActionHandler implements MiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var Responder
     */
    private $responder;

    public function __construct(ContainerInterface $container, Responder $responder)
    {
        $this->container = $container;
        $this->responder = $responder;
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface
     *
     * @throws \ReflectionException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $action = $request->getAttribute('action');
        if (!$this->container->has($action)) {
            throw new ActionNotFoundException(
                $action ?? 'NULL',
                $request->getAttribute('route') ?? 'NULL'
            );
        }

        $action = $this->container->get($action);
        if (false === \is_callable($action)) {
            throw new InvalidActionTypeException($action);
        }

        $actionClosure = \Closure::fromCallable($action);
        $arguments = $this->extractActionArgumentsFromRequest($actionClosure, $request);

        $response = $actionClosure(...$arguments);
        if (!$response instanceof ResponseInterface) {
            throw new InvalidActionReturnTypeException($action);
        }

        return $response;
    }

    /**
     * Extract the action arguments from the current request
     *
     * @param \Closure $action                The action as a closure
     * @param ServerRequestInterface $request The current request can be injected as parameters of the action if one of
     *                                        its arguments is type-hinted with the ServerRequestInterface
     *
     * @return array
     *
     * @throws \ReflectionException
     */
    private function extractActionArgumentsFromRequest(\Closure $action, ServerRequestInterface $request): array
    {
        $parameters = $request->getAttribute('route_parameters') ?? [];

        $reflection = new \ReflectionFunction($action);
        foreach ($reflection->getParameters() as $actionArgument) {
            if (array_key_exists($actionArgument->getName(), $parameters)) {
                $arguments[] = $parameters[$actionArgument->getName()];
                continue;
            }

            if ($type = $actionArgument->getType()) {
                $typeName = $type->getName();
                if (ServerRequestInterface::class === $typeName) {
                    $arguments[] = $request;
                } elseif (Responder::class === $typeName) {
                    $arguments[] = $this->responder;
                }
            }
        }

        return $arguments ?? [];
    }
}
