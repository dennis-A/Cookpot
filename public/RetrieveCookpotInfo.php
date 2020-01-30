<?php

    include_once("recipe.class.php");

    $ingredientsData = $_GET['ingredientsData'];

    //foreach($ingredientsData as $ingredients) {
    //    echo "item in ingredientsData: " . $ingredients;
    //}

    //echo "item: " . $_GET['ingredientsData'];

    $recipeObj = new Recipe();
    
    $recipe_results = $recipeObj->checkContainsRecipeIngredients($ingredientsData);
    //$recipe_results = $recipeObj->checkContainsRecipeIngredients($ingredientsData);

    $myResults = [];

    foreach($recipe_results as $recipe) {
        //Build the JSON
        $jsonItem = array(
            "recipe_id" => $recipe['recipe_id'],
            "name" => $recipe['recipe_name'],
            "ingredient_name" => $recipe['ingredient_name'],
            "recipe_image" => $recipe['recipe_image']
        );

        array_push($myResults, $jsonItem);
    }

    echo json_encode($myResults);

?>