<?php

    include_once('Database.class.php');

    $db = Database::getInstance();
	$dbCon = $db->getConnection();

    $username = $_POST["username"];
    $passwordEntered = $_POST["password"];


    $results = array();
    $counter = 0;
    $query = "SELECT `password` FROM `user_login`
                WHERE `username` = ?";
    
    $stmt = $dbCon->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->bind_result($password);
    
    while( $stmt->fetch() ) {		
        $results[$counter]['password'] = $password;
        $counter++;
    }
    
    $stmt->close();
            
    foreach($results as $users) {
        $pw = $users["password"];
    }

    //Check if password matches, if yes allow user through to /home
    if($pw == $passwordEntered) {
        header("Location: " . "/skeleton/public/home");
        echo "Correct password ";
        echo "<br>Password user entered: " . $passwordEntered;
        echo "<br>password in the DB: " . $pw;
    }
    else {
        header("Location: " . "/skeleton/public/login");
        echo "Wrong login info";
    }

    /*
    $recipe_id = $_GET["RecipeID"];

    $recipeObj = new Recipe();
    $recipe_info = $recipeObj->getRecipeInfo($recipe_id);

    foreach($recipe_info as $recipe) {
        $recipe_id = $recipe['recipe_id'];
        $name = $recipe['recipe_name'];
        $recipe_description = $recipe['recipe_description'];
        $recipe_image = $recipe['recipe_image'];
    }
    */

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