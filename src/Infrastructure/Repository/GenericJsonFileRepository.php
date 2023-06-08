<?php

namespace App\Infrastructure\Repository;

use JsonSerializable;

class GenericJsonFileRepository
{
    const FILE_PATH_PATTERN = __DIR__ . '/../../../var/repository/%s.json';

    private string $filePath;

    public function __construct(
        private readonly string $entityClass,
        private readonly string $idFieldName
    ) {
        $this->filePath = sprintf(self::FILE_PATH_PATTERN, str_replace('\\', '', $this->entityClass));
        $dirName = dirname($this->filePath);
        if (!file_exists($dirName)) {
            mkdir($dirName);
        }

        if (!file_exists($this->filePath)) {
            file_put_contents($this->filePath, '[]');
        }
    }
    private function flush(array $entries): void
    {
        $json = json_encode($entries);
        $savingResult = file_put_contents($this->filePath, $json);
        if ($savingResult === false) {
            throw new JsonFileRepositoryException('Cannot save: ' . $this->filePath);
        }
    }

    public function save(JsonSerializable $entity): void
    {
        $entityUpdated = false;
        $entries = $this->all();
        foreach ($entries as $i => $entry) {
            if ($this->getEntityIdentifier($entry) == $this->getEntityIdentifier($entity)) {
                $entries[$i] = $entity;
                $entityUpdated = true;
            }
        }
        if (!$entityUpdated) {
            $entries[] = $entity;
        }
        $this->flush($entries);
    }

    public function all(): array
    {
        $result = [];
        $json = file_get_contents($this->filePath);
        foreach (json_decode($json, true) as $entry) {
            $result[] = call_user_func_array($this->entityClass.'::fromArray', [$entry]);
        }
        return $result;
    }

    public function delete(JsonSerializable $entity): void
    {
        $serializedEntity = $entity->jsonSerialize();
        $entries = $this->all();
        foreach ($entries as $index => $entry) {
            if($this->getEntityIdentifier($entry) == $serializedEntity[$this->idFieldName]) {
                unset($entries[$index]);
            }
        }
        $entries = array_values($entries);
        $this->flush($entries);
    }

    public function find(mixed $identifier): ?JsonSerializable
    {
        $entries = $this->all();
        foreach ($entries as $entry) {
            if($this->getEntityIdentifier($entry) == $identifier) {
                return $entry;
            }
        }

        return null;
    }

    private function getEntityIdentifier(JsonSerializable $entity): mixed
    {
        return call_user_func([$entity, 'get' . ucfirst($this->idFieldName)]);
    }
}