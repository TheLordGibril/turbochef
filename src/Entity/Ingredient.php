<?php

namespace App\Entity;

use App\Repository\IngredientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IngredientRepository::class)]
class Ingredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    /**
     * @var Collection<int, IngredientInRecipe>
     */
    #[ORM\OneToMany(targetEntity: IngredientInRecipe::class, mappedBy: 'Ingredient')]
    private Collection $Recipes;

    public function __construct()
    {
        $this->Recipes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    /**
     * @return Collection<int, IngredientInRecipe>
     */
    public function getRecipes(): Collection
    {
        return $this->Recipes;
    }

    public function addRecipe(IngredientInRecipe $recipe): static
    {
        if (!$this->Recipes->contains($recipe)) {
            $this->Recipes->add($recipe);
            $recipe->setIngredient($this);
        }

        return $this;
    }

    public function removeRecipe(IngredientInRecipe $recipe): static
    {
        if ($this->Recipes->removeElement($recipe)) {
            // set the owning side to null (unless already changed)
            if ($recipe->getIngredient() === $this) {
                $recipe->setIngredient(null);
            }
        }

        return $this;
    }
}
