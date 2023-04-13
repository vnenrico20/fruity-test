<?php

namespace App\Service;

use App\Entity\FruitNutrition;
use App\Repository\FruitNutritionRepository;

class FruitNutritionService
{
    public function __construct(
        public FruitNutritionRepository $fruitNutritionRepository
    )
    {
    }

    public function save(FruitNutrition $entity, bool $flush = false): void
    {
        $this->fruitNutritionRepository->save($entity, $flush);
    }

}
