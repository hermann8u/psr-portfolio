<?php

declare(strict_types=1);

namespace App\Action;

use App\Domain\Model\Technology;
use App\Domain\Repository;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class HomeAction
{
    /**
     * @var Repository
     */
    private $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(ServerRequestInterface $request, Responder $responder): ResponseInterface
    {
        return $responder->respond($request, 'home.html.twig', [
            'technologies' => $this->repository->getAll(Technology::class)
        ]);
    }
}
