<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Domain\Model\Counter as Model;
use App\Domain\Repository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Counter implements MiddlewareInterface
{
    /**
     * @var Repository
     */
    private $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);
        if ($request->getAttribute('route') !== 'home') {
            return $response;
        }

        /**
         * @var Model|null $counter
         */
        $counter = $this->repository->getAll(Model::class)[0] ?? null;
        if ($counter) {
            $this->repository->save($counter->increment());
        }

        return $response;
    }
}
