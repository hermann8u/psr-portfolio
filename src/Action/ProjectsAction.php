<?php

declare(strict_types=1);

namespace App\Action;

use App\Domain\Model\Project;
use App\Domain\Repository;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ProjectsAction
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
        return $responder->respond($request, 'projects.html.twig', [
            'projects' => $this->repository->getAll(Project::class)
        ]);
    }
}
