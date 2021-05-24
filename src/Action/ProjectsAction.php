<?php

declare(strict_types=1);

namespace App\Action;

use App\Domain\Model\Project;
use App\Domain\Repository;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class ProjectsAction implements RequestHandlerInterface
{
    private Repository $repository;
    private Responder $responder;

    public function __construct(Repository $repository, Responder $responder)
    {
        $this->repository = $repository;
        $this->responder = $responder;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->responder->respond($request, 'projects.html.twig', [
            'projects' => $this->repository->getAll(Project::class)
        ]);
    }
}
