<?php

namespace App\Service;

use App\Entity\Fruit;
use App\Repository\FruitRepository;

class FruitService
{
    public function __construct(
        public FruitRepository $fruitRepository
    )
    {
    }

    public function save(Fruit $entity, bool $flush = false): void
    {
        $this->fruitRepository->save($entity, $flush);
    }

    public function find(int $id): ?Fruit
    {
        return $this->fruitRepository->find($id);
    }

    public function findByIds(array $ids): array
    {
        return $this->fruitRepository->findBy(['id' => $ids]);
    }

    public function findFruits($limit = null, $offset = null): array
    {
        return $this->fruitRepository->findBy([], ['name' => 'ASC'], $limit, $offset);
    }

    public function countFruits($name = null, $family = null): int
    {
        return $this->fruitRepository->countFruits($name, $family);
    }

    public function filterFruit($name, $family, $limit = null, $offset = null): array
    {
        return $this->fruitRepository->filterFruits($name, $family, $limit, $offset);
    }
}
