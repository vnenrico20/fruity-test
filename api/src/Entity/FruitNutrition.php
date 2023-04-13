<?php

namespace App\Entity;

use App\Repository\FruitNutritionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FruitNutritionRepository::class)]
class FruitNutrition implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $calories = null;

    #[ORM\Column]
    private ?float $fat = null;

    #[ORM\Column]
    private ?float $sugar = null;

    #[ORM\Column]
    private ?float $carbohydrates = null;

    #[ORM\Column]
    private ?float $protein = null;

    #[ORM\OneToOne(inversedBy: 'fruitNutrition', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Fruit $fruit = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCalories(): ?int
    {
        return $this->calories;
    }

    public function setCalories(int $calories): self
    {
        $this->calories = $calories;

        return $this;
    }

    public function getFat(): ?float
    {
        return $this->fat;
    }

    public function setFat(float $fat): self
    {
        $this->fat = $fat;

        return $this;
    }

    public function getSugar(): ?float
    {
        return $this->sugar;
    }

    public function setSugar(float $sugar): self
    {
        $this->sugar = $sugar;

        return $this;
    }

    public function getCarbohydrates(): ?float
    {
        return $this->carbohydrates;
    }

    public function setCarbohydrates(float $carbohydrates): self
    {
        $this->carbohydrates = $carbohydrates;

        return $this;
    }

    public function getProtein(): ?float
    {
        return $this->protein;
    }

    public function setProtein(float $protein): self
    {
        $this->protein = $protein;

        return $this;
    }

    public function getFruit(): ?Fruit
    {
        return $this->fruit;
    }

    public function setFruit(Fruit $fruit): self
    {
        $this->fruit = $fruit;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            "calories" => $this->getCalories(),
            "fat" => $this->getFat(),
            "sugar" => $this->getSugar(),
            "carbohydrates" => $this->getCarbohydrates(),
            "protein" => $this->getProtein()
        ];
    }
}
