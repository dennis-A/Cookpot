<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RecipeInfoRepository")
 */
class RecipeInfo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $recipe_id;

    /**
     * @ORM\Column(type="text", length=100)
     */
    private $recipeName;

    /**
     * @ORM\Column(type="text")
     */
    private $recipeDescription;

    /**
     * @ORM\Column(type="text")
     */
    private $recipeImage;

    /**
     * @ORM\Column(type="text")
     */
    //private $ingredientName;
    
    /**
     * One product has many features. This is the inverse side.
     
     */
    //private $recipeIngredients;
    //@ORM\OneToMany(targetEntity="RecipeIngredients", mappedBy="recipeInfo")

    public function __construct()
    {
        //$this->recipeIngredients = new ArrayCollection();
    }

    public function getRecipeId(): ?int
    {
        return $this->recipe_id;
    }


    public function setRecipeName($recipeName) {
        $this->recipeName = $recipeName;
    }

    public function getRecipeName() {
        return $this->recipeName;
    }

    public function setRecipeDescription($recipeDescription) {
        $this->recipeDescription = $recipeDescription;
    }

    public function getRecipeDescription() {
        return $this->recipeDescription;
    }

    public function getRecipeImage() {
        return $this->recipeImage;
    }

    /*
    public function getRecipeIngredients() {
        return $this->recipeIngredients;
    }
    */

    /*
    public function getIngredientName() {
        return $this->ingredientName;
    }
    */
}
