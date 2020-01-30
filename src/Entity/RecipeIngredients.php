<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RecipeIngredientsRepository")
 */
class RecipeIngredients
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $recipe_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $ingredient_id;

    /**
     * @ORM\Column(type="text", length=100)
     */
    public $ingredient_name;

    /**
     * Many features have one product. This is the owning side.
     
     */
    //private $recipeInfo;
    //@ORM\ManyToOne(targetEntity="RecipeInfo", inversedBy="recipeIngredients")
    //@ORM\JoinColumn(name="recipe_id", referencedColumnName="recipe_id")

    public function getId(): ?int
    {
        return $this->recipe_id;
    }
    /*
    public function getIngredientName() {
        return $this->ingredient_name;
    }
    */
}
