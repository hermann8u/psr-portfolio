<?php

declare(strict_types=1);

namespace App\Action;

use App\Domain\Model\Counter;
use App\Domain\Repository;
use App\Responder\Responder;
use Psr\Http\Message\ServerRequestInterface;

class GetStatsAction
{
    /**
     * @var Repository
     */
    private $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(ServerRequestInterface $request, Responder $responder)
    {
        return $responder->respond($request, 'stats.html.twig', [
            'counter' => $this->repository->getAll(Counter::class)[0] ?? null
        ]);
    }
}
