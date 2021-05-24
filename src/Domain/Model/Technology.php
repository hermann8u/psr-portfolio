<?php

declare(strict_types=1);

namespace App\Domain\Model;

class Technology
{
    public const DATA_FILE_NAME = 'technologies.json';

    /** @var string */
    private $title;

    /** @var string */
    private $logo;

    /** @var string */
    private $link;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getLogo(): string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }
}
