<?php

namespace App\Entity;

use App\Repository\FruitRepository;
use Doctrine\ORM\Mapping as ORM;
#[ORM\Entity(repositoryClass: FruitRepository::class)]
class Fruit implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "NONE")]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $family = null;

    #[ORM\Column(name: "`order`", length: 255, nullable: true)]
    private ?string $order = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $genus = null;

    #[ORM\OneToOne(mappedBy: 'fruit', cascade: ['persist', 'remove'])]
    private ?FruitNutrition $fruitNutrition = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFamily(): ?string
    {
        return $this->family;
    }

    public function setFamily(?string $family): self
    {
        $this->family = $family;

        return $this;
    }

    public function getOrder(): ?string
    {
        return $this->order;
    }

    public function setOrder(?string $order): self
    {
        $this->order = $order;

        return $this;
    }

    public function getGenus(): ?string
    {
        return $this->genus;
    }

    public function setGenus(?string $genus): self
    {
        $this->genus = $genus;

        return $this;
    }

    public function getFruitNutrition(): ?FruitNutrition
    {
        return $this->fruitNutrition;
    }

    public function setFruitNutrition(FruitNutrition $fruitNutrition): self
    {
        // set the owning side of the relation if necessary
        if ($fruitNutrition->getFruit() !== $this) {
            $fruitNutrition->setFruit($this);
        }

        $this->fruitNutrition = $fruitNutrition;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id'         => $this->getId(),
            'name'       => $this->getName(),
            'family'     => $this->getFamily(),
            'order'      => $this->getOrder(),
            'genus'      => $this->getGenus(),
            'nutritions' => $this->getFruitNutrition()->jsonSerialize()
        ];
    }
}
