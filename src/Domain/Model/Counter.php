<?php

declare(strict_types=1);

namespace App\Domain\Model;

class Counter implements SavableModel
{
    const DATA_FILE_NAME = 'counter.json';

    /**
     * @var int
     */
    private $count;

    /**
     * @var string[]
     */
    private $dates;

    public function __construct()
    {
        $this->count = 0;
        $this->dates = [];
    }

    public function getArrayData(): array
    {
        return [
            'count' => $this->count,
            'dates' => $this->dates
        ];
    }

    public function increment(): self
    {
        $this->count++;
        array_unshift($this->dates, date('Y-m-d H:i:s'));

        return $this;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function setCount(int $count): self
    {
        $this->count = $count;
        return $this;
    }

    public function getDates(): array
    {
        return $this->dates;
    }

    public function setDates(array $dates): self
    {
        $this->dates = $dates;
        return $this;
    }
}
