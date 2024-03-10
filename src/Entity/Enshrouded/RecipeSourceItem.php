<?php

namespace App\Entity\Enshrouded;

use App\Repository\RecipeSourceItemRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: RecipeSourceItemRepository::class)]
#[ORM\Table(name: 'enshrouded_recipe_source_item')]
class RecipeSourceItem extends RecipeSource
{

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['recipe', 'recipes_sources'])]
    private ?Item $item = null;

    public function getItem(): ?Item
    {
        return $this->item;
    }

    public function setItem(Item $item): static
    {
        $this->item = $item;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getItem()->getName();
    }
}
