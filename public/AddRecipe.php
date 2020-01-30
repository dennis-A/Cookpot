<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="js/AddRecipe.js?v=1.0"></script>
    <link rel="stylesheet" type="text/css" href="Bootstrap/css/bootstrap.css" >
    <link rel="stylesheet" type="text/css" href="css/Layout.css">
    <link rel="stylesheet" type="text/css" href="css/AddRecipe.css">
    <script src="Bootstrap/js/bootstrap.js" > </script>
</head>

<?php
    include_once("Header.php");
    include_once("Footer.php");
?>

<body>
    <div id="main">
        <div id="center-screen">
            <form action="SubmitRecipe.php" method="POST">
                <table id="recipe-form">
                    <tr>
                        <td><label id="recipe_name">*Recipe Name: </label></td>
                        <td><input id="recipe_name" name="recipe_name" type="text" class="form-control"></td>
                    </tr>
                    <tr>
                        <td><label for ="cheese" id="ingredients">*Ingredients: </label></td>
                        <td>
                            <select multiple class="form-control" id="recipe_ingredients" name="recipe_ingredients[]">
                                <option>tomatoes</option>
                                <option>garlic</option>
                                <option>lemon</option>
                                <option>olive oil</option>
                                <option>onion</option>
                                <option>pepper</option>
                                <option>salt</option>
                                <option>shrimp</option>
                                <option>potatoes</option>
                                <option>broccoli</option>
                                <option>chicken</option>
                                <option>milk</option>
                                <option>cheese</option>
                                <option>tuna</option>
                                <option>eggs</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label id="recipe_description">Recipe Description: </label></td>
                        <td><textarea id="recipe_description" name="recipe_description" class="form-control"></textarea></td>
                    </tr>
                    <tr>
                        <td><label id="recipe_image">Recipe Name: </label></td>
                        <td><input id="recipe_image" name="recipe_image" type="text" class="form-control"></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" id="submit_recipe" class="form-control success" style="background-color:#2cbf53;color:white;"></td>
                    </tr>
                </table>
            </form>

            <div id="error-checking"></div>
        </div>
    </div>
</body>

