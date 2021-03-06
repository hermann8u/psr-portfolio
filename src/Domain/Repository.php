<?php

declare(strict_types=1);

namespace App\Domain;

use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

class Repository
{
    private PropertyAccessorInterface $propertyAccessor;
    private string $projectDir;

    public function __construct(PropertyAccessorInterface $propertyAccessor, string $projectDir)
    {
        $this->propertyAccessor = $propertyAccessor;
        $this->projectDir = $projectDir;
    }

    public function getAll(string $modelName): array
    {
        $entities = [];

        foreach ($this->getFileData($modelName) as $entityArray) {
            $entity = new $modelName();
            foreach ($entityArray as $property => $value) {
                try {
                    $this->propertyAccessor->setValue($entity, $property, $value);
                } catch (\Exception $exception) {
                }
            }

            $entities[] = $entity;
        }

        return $entities;
    }

    private function getFileData(string $modelName): array
    {
        if (!$fileName = $this->getFileNameByModel($modelName)) {
            return [];
        }

        if (!file_exists($fileName)) {
            return [];
        }

        return json_decode(file_get_contents($fileName), true);
    }

    private function getFileNameByModel(string $modelName): ?string
    {
        if (!$fileName = constant($modelName.'::DATA_FILE_NAME')) {
            return null;
        }

        return sprintf(
            "%s/data/%s",
            $this->projectDir,
            $fileName
        );
    }
}
