$(document).ready(function() {

    $("#div1").change(function() {
        console.log("element updated");
    }); 

    $("input#hiddenIngredients").change(function() {

        if($("#results-panel").hasClass("hidden")) {

            var ingredientsListForAjax = [];

            $('#results-panel').animate({left: "0"});
            $("#results-panel").removeClass("hidden");

            var ingredientsList = $("#div1").children("img");

            $(".ingredients-list").empty();

            jQuery.each(ingredientsList, function(i,item) {
                ingredientsListForAjax.push($(item).attr("id"));
            });

            //console.log("item was added");
            //$("#hiddenIngredients").val("");
            //Perform the ajax call and get the recipe data here
            $.ajax({
                method: "GET",
                dataType: "json",
                //url: "retrieveCookpotInfo.php",
                url: "http://localhost/skeleton/public/recipe",
                data: {
                    ingredientsData: ingredientsListForAjax
                    //"recipeIngredients": 1
                },
                success: function(results) {
                    if(results.length > 0) {
                        //var resultsList = JSON.parse(results);
                        var resultsList = results;
                        console.log("results");
                        console.log(results);
                        /*
                        for (var key in resultsList) {
                            
                            var recipe_id = resultsList[key].recipe_id;
                            var recipe_name = resultsList[key].name;
                            var ingredient_name = resultsList[key].ingredient_name;
                            var recipe_image = resultsList[key].recipe_image;

                            var recipeData ="<tr>" +
                                                "<td style='text-align:center;background-color:#194769;'>" +
                                                    //"<a href='https://www.google.com' target='_blank' class='recipe-link' style='font-family:fantasy;'><h1>" + recipe_name + "</h1></a>" +
                                                    "<a href='RecipeDisplay.php?RecipeID=" + recipe_id + "'  target='_blank' class='recipe-link' style='font-family:fantasy;'><h1>" + recipe_name + "</h1></a>" +
                                                "</td>" +
                                            "</tr>" +
                                            "<tr>" +
                                                "<td style='text-align:center;background-color:#ded5d3;'>" +
                                                    "<div style='border-radius:50px;padding:10px;align:center;margin:auto;background-color:#d14343;'>" +
                                                        "<img src='images/" + recipe_image + "' style='width: 50%;border-radius:30px;'>" +
                                                    "</div>" +
                                                "</td>" +
                                                //"<td>" + 
                                                    //[Ingredient images here]
                                                //"</td>" +
                                            "</tr>"

                                            //#d14343
                                            //#db4335

                                            //name #194769

                                            //background table #ded5d3

                            $(".ingredients-list").append(recipeData);
                        }
                        */
                        $(".ingredients-list").append(populateTableWithRecipeData(results));
                        $('[data-toggle="tooltip"]').tooltip();
                    }
                }
            });
        }
        //This means panel is open
        else {
            //$('#results-panel').animate({left: "-600px"});
            //$("#results-panel").addClass("hidden");

            var ingredientsListForAjax = [];

            //$('#results-panel').animate({left: "0"});
            //$("#results-panel").removeClass("hidden");

            var ingredientsList = $("#div1").children("img");

            $(".ingredients-list").empty();

            jQuery.each(ingredientsList, function(i,item) {
                ingredientsListForAjax.push($(item).attr("id"));
            });

            //Perform the ajax call and get the recipe data here
            $.ajax({
                method: "GET",
                dataType: "json",
                //url: "retrieveCookpotInfo.php",
                url: "http://localhost/skeleton/public/recipe",
                beforeSend: function() {
                    //alert("loading");
                },
                data: {
                    ingredientsData: ingredientsListForAjax
                },
                success: function(results) {
                    if(results.length > 0) {
                        //var resultsList = JSON.parse(results);
                        var resultsList = results;
                        //console.log("results");
                        //console.log(results);
                        /*
                        for (var key in resultsList) {
                            
                            var recipe_id = resultsList[key].recipe_id;
                            var recipe_name = resultsList[key].name;
                            var ingredient_name = resultsList[key].ingredient_name;
                            var recipe_image = resultsList[key].recipe_image;

                            var recipeData ="<tr>" +
                                                "<td style='text-align:center;background-color:#194769;'>" +
                                                    //"<a href='https://www.google.com' target='_blank' class='recipe-link' style='font-family:fantasy;'><h1>" + recipe_name + "</h1></a>" +
                                                    "<a href='RecipeDisplay.php?RecipeID=" + recipe_id + "'  target='_blank' class='recipe-link' style='font-family:fantasy;'><h1>" + recipe_name + "</h1></a>" +
                                                "</td>" +
                                            "</tr>" +
                                            "<tr>" +
                                                "<td style='text-align:center;background-color:#ded5d3;'>" +
                                                    "<div style='border-radius:50px;padding:10px;align:center;margin:auto;background-color:#d14343;'>" +
                                                        "<img src='images/" + recipe_image + "' style='width: 50%;border-radius:30px;'>" +
                                                    "</div>" +
                                                "</td>" +
                                                //"<td>" + 
                                                    //[Ingredient images here]
                                                //"</td>" +
                                            "</tr>"

                                            //#d14343
                                            //#db4335

                                            //name #194769

                                            //background table #ded5d3

                            $(".ingredients-list").append(recipeData);
                        }
                        */
                        $(".ingredients-list").append(populateTableWithRecipeData(results));
                        $('[data-toggle="tooltip"]').tooltip();
                    }
                }
            });
        }
        
    });

    $(".close-panel").click(function() {
        $('#results-panel').animate({left: "-600px"});
        $("#results-panel").addClass("hidden");
    });

    $(".toggle-ingredients-panel").click(function() {
        if($(".ingredients-panel").hasClass("isHidden")) {
            $(".ingredients-panel").removeClass("isHidden");
        } else {
            $(".ingredients-panel").addClass("isHidden");
        }

        if($(".ingredients-panel-2").hasClass("isHidden")) {
            $(".ingredients-panel-2").removeClass("isHidden");
        } else {
            $(".ingredients-panel-2").addClass("isHidden");
        }
    });


    function populateTableWithRecipeData(resultsList) {
        var builtRecipeDataList = "";
        for (var key in resultsList) {
                            
            var recipe_id = resultsList[key].recipe_id;
            var recipe_name = resultsList[key].name;
            var ingredient_name = resultsList[key].ingredient_name;
            var recipe_calories = resultsList[key].recipe_calories;
            var recipe_totalTime = resultsList[key].recipe_totalTime;
            var recipe_url = resultsList[key].recipe_url;
            var recipe_image = resultsList[key].recipe_image;

            if(recipe_totalTime > 0) {
                recipe_totalTime = recipe_totalTime + " mins."
            } else {
                recipe_totalTime = "Less than 1 min."
            }

            var recipeTooltip = "Cal: " + Math.round(recipe_calories) + "<br>Prep: " + recipe_totalTime;

            var recipeData ="<tr>" +
                                "<td style='text-align:center;background-color:#194769;'>" +
                                    //"<a href='https://www.google.com' target='_blank' class='recipe-link' style='font-family:fantasy;'><h1>" + recipe_name + "</h1></a>" +
                                    //"<a href='RecipeDisplay.php?RecipeID=" + recipe_id + "'  target='_blank' class='recipe-link' style='font-family:fantasy;'><h1>" + recipe_name + "</h1></a>" +
                                    "<a href='" + recipe_url + "' target='_blank' class='recipe-link' style='font-family:fantasy;text-decoration:none;'><h1>" + recipe_name + "</h1></a>" +
                                "</td>" +
                            "</tr>" +
                            "<tr>" +
                                "<td style='text-align:center;background-color:#ded5d3;'>" +
                                    "<div style='border-radius:50px;padding:10px;align:center;margin:auto;background-color:#d14343;'>" +
                                        "<img src='" + recipe_image + "' style='width: 50%;border-radius:30px;'>" +
                                        //"<div style='float:right;'>" +
                                            "<i class='fa fa-info-circle' style='float:right;font-size:24px;' data-toggle='tooltip' data-html='true' title='" + recipeTooltip + "'></i>" +
                                        //"</div>" +
                                    "</div>" +
                                "</td>" +
                            "</tr>"

            builtRecipeDataList = builtRecipeDataList + recipeData;
        }
        //$('[data-toggle="tooltip"]').tooltip();
        return builtRecipeDataList;
    }
}) 
