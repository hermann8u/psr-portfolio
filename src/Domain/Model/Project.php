<?php

declare(strict_types=1);

namespace App\Domain\Model;

class Project
{
    const DATA_FILE_NAME = 'projects.json';

    /**
     * @var string
     */
    private $name;

    /**
     * @var string[]
     */
    private $tags;

    /**
     * @var string[]
     */
    private $technologies;

    /**
     * @var string
     */
    private $image;

    /**
     * @var string|null
     */
    private $onlineLink;

    /**
     * @var string|null
     */
    private $githubLink;

    public function __construct()
    {
        $this->tags = [];
        $this->technologies = [];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getTags(): array
    {
        return $this->tags;
    }

    public function setTags(array $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    public function getTechnologies(): array
    {
        return $this->technologies;
    }

    public function setTechnologies(array $technologies): self
    {
        $this->technologies = $technologies;

        return $this;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;
        return $this;
    }

    public function getOnlineLink(): ?string
    {
        return $this->onlineLink;
    }

    public function setOnlineLink(?string $onlineLink): self
    {
        $this->onlineLink = $onlineLink;
        return $this;
    }

    public function getGithubLink(): ?string
    {
        return $this->githubLink;
    }

    public function setGithubLink(?string $githubLink): self
    {
        $this->githubLink = $githubLink;
        return $this;
    }
}
