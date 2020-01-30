$(document).ready(function() {

    $("#submit_recipe").click(function(e) {
        var errorChecking = "";
        var listOfErrors = "<ul>";

        var recipe_name = $("input[id='recipe_name'").val();
        var recipe_ingredients = $("select[id='recipe_ingredients'").val();

        if(recipe_name.length == 0) {
            e.preventDefault();
            errorChecking = "Please enter a recipe name";
            listOfErrors = listOfErrors + "<li>" + errorChecking + "</li>";
        }

        if(recipe_ingredients.length == 0) {
            errorChecking = "Please select a recipe ingredient";
            listOfErrors = listOfErrors + "<li>" + errorChecking + "</li>";
        }

        //Prevent form submission if form contains error
        if(errorChecking.length > 0) {
            listOfErrors = listOfErrors + "<ul>";

            $("#error-checking").html(listOfErrors);
            $("#error-checking").css("color","#e0472f");
            e.preventDefault();
        }
    })
});