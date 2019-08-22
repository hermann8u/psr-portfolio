<?php

declare(strict_types=1);

namespace App\Action;

use App\Domain\Model\Counter;
use App\Domain\Repository;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class GetStatsAction implements RequestHandlerInterface
{
    /** @var Repository */
    private $repository;

    /** @var Responder */
    private $responder;

    public function __construct(Repository $repository, Responder $responder)
    {
        $this->repository = $repository;
        $this->responder = $responder;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->responder->respond($request, 'stats.html.twig', [
            'counter' => $this->repository->getAll(Counter::class)[0] ?? null
        ]);
    }
}
