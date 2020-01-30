<?php

    include_once("recipe.class.php");

    $recipe_id = $_GET["RecipeID"];


    $recipeObj = new Recipe();
    $recipe_info = $recipeObj->getRecipeInfo($recipe_id);



    foreach($recipe_info as $recipe) {
        /*
        //Build the JSON
        $jsonItem = array(
            "recipe_id" => $recipe['recipe_id'],
            "name" => $recipe['recipe_name'],
            "ingredient_name" => $recipe['ingredient_name'],
            "recipe_image" => $recipe['recipe_image']
        );
        */
        $recipe_id = $recipe['recipe_id'];
        $name = $recipe['recipe_name'];
        $recipe_description = $recipe['recipe_description'];
        $recipe_image = $recipe['recipe_image'];
    }
    /*
    $recipe_id = $recipe_info['recipe_id'];
    $name = $recipe_info['recipe_name'];
    $recipe_description = $recipe_info['recipe_description'];
    $recipe_image = $recipe_info['recipe_image'];
    */
    //echo "hello " . $recipe_id . " and " . $name . " and " . $recipe_description . " and " . $recipe_image . "<br>";

?>

<html>

    <head>
    </head>

    <body>

        <div style="text-align:center;">
            <h1><?php echo $name ?></h1>
            <img src="images/<?php echo $recipe_image ?>" style='width: 50%;border-radius:30px;height:600px;'>

            <h2>How To Prepare</h2>
            <hr>
            <div style="margin:0px auto; width:50%; height:50%;">
                <?php echo $recipe_description ?>
            </div>

        </div>
    
    </body>

</html>