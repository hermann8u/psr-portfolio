<?php

declare(strict_types=1);

namespace App\Domain\Model;

interface SavableModel
{
    public function getArrayData(): array;
}
