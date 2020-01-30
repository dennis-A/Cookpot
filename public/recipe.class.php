
<?php

include_once('Database.class.php');

class Recipe {
	
	private static $dbCon;
	
	function __construct() {
		$db = Database::getInstance();
		self::$dbCon = $db->getConnection();
	}
	
	function getAllRecipeID() {
		
		$result = array();
		$counter = 0;
		$query = "SELECT `recipeID` FROM `recipeinfo`";
		
		$stmt = self::$dbCon->prepare($query);
		$stmt->execute();
		$stmt->bind_result($recipe_id);
		
		while( $stmt->fetch() ) {		
			$result[$counter]['recipe_id'] = $recipe_id;
			//echo "id is: "  . $recipe_id . " ";
			$counter++;
		}
		
		$stmt->close();
				
		return $result;		
	}

       function getRecipeIDByName($recipe_name) {

               $result = array();
               $counter = 0;
               $query = "SELECT `recipeID` FROM `recipeinfo` WHERE `recipeName` = ?";

               $stmt = self::$dbCon->prepare($query);
               $stmt->bind_param('s', $recipe_name);
               $stmt->execute();
               $stmt->bind_result($recipe_id);

               while( $stmt->fetch() ) {
                       $result[$counter]['recipe_id'] = $recipe_id;
                       //echo "id is: "  . $recipe_id . " ";
                       $counter++;
               }

               $stmt->close();

               return $recipe_id;
       }

       function getIngredientIDByName($ingredient_name) {
               $result = array();
               $counter = 0;
               //$query = "SELECT `ingredientID` FROM `ingredients` WHERE `ingredientName` = ?";
               $query = "SELECT `ingredientID`,`ingredientName` FROM `ingredients` WHERE `ingredientName` IN (" . $ingredient_name . ")";

               $stmt = self::$dbCon->prepare($query);
               //$stmt->bind_param('s', $ingredient_name);
               $stmt->execute();
               $stmt->bind_result($ingredient_id,$ingredient_name);

               while( $stmt->fetch() ) {
                       $result[$counter]['ingredient_id'] = $ingredient_id;
                       $result[$counter]['ingredient_name'] = $ingredient_name;
                       //echo "id is: "  . $recipe_id . " ";
                       echo "id is: "  . $ingredient_id . " ";
                       $counter++;
               }

               $stmt->close();

               //return $ingredient_id;
               return $result;
    }
	
	
	function checkRecipeIngredients($recipes, $item) {
		
		$list_of_recipes = array();
		$tracker = 0;
		$query = "SELECT `recipeID`, `ingredientID`, `ingredientName` FROM `recipe_ingredients`
							WHERE `recipeID` = ?";
		foreach($recipes as $recipe) {
			$results = array();	
			$counter = 0;
			//$recipe_id = 1;
			$recipe_id = $recipe['recipe_id'];
			
			
			$stmt = self::$dbCon->prepare($query);
			$stmt->bind_param('i', $recipe_id);
			$stmt->execute();
			$stmt->bind_result($recipeID, $ingredientID, $ingredientName);
			
			while($stmt->fetch()) {
				
				$results[$counter]['recipe_id'] = $recipeID;
				$results[$counter]['ingredient_id'] = $ingredientID;
				$results[$counter]['ingredient_name'] = $ingredientName;
				$counter++;
			}
            
            //findRecipe is looking for exact case scenario. Recipes must match
            //exactly.
			$temp = $this->findRecipe($results, $item);
			
			if( $temp != -1 ) {
				$list_of_recipes[$tracker] = $temp;
				$tracker++;
			}
		}
		
		$stmt->close();
		
		
		return $list_of_recipes;
		
    }
    
    function checkContainsRecipeIngredients($item) {
		
		$list_of_recipes = array();
        $tracker = 0;
        /*
		$query = "SELECT `recipeID`, `ingredientID`, `ingredientName` FROM `recipe_ingredients`
                            WHERE `recipeID` = ?";
		*/ 

		$inStr = "";
		$savedItem = "";
		$qMarks = str_repeat('?,', count($item) - 1) . '?';
		$savedItem = implode(",",$item);
		/*
		foreach($item as $thisItem) {
			$savedItem = $savedItem . $thisItem
		}
		*/

		foreach($item as $thisItem) {
			//$savedItem = $savedItem . $thisItem;
			//echo "these items: " . $thisItem;
			
			if($inStr != "") {
				$inStr = $inStr . ",";
			}
			$inStr = $inStr . "'" . $thisItem . "'";
		}

		//echo "inStr: " . $inStr . " end";
		
        /*        
        $query = "SELECT `RS1`.`recipeName`, `RS1`.`ingredientName`, `RS1`.`recipeImage` from ( 
					SELECT `recipeInfo`.`recipeID`, `recipeInfo`.recipeName, 
						GROUP_CONCAT(ingredientName) AS ingredientName, `recipeImage` 
					FROM `recipeInfo` 
					INNER JOIN `recipe_ingredients` ON `recipeInfo`.`recipeID` = `recipe_ingredients`.`recipeID` 
					WHERE `ingredientName` IN (?) 
					GROUP BY `recipeInfo`.`recipeID`, `recipeInfo`.`recipeName`, `recipeImage` 
				  ) AS RS1 
				Where `RS1`.`ingredientName` LIKE ? ";
		*/
		
		/*
		$query = 	"SELECT `recipeInfo`.recipeName, 
						GROUP_CONCAT(ingredientName) AS ingredientName, `recipeImage` 
					FROM `recipeInfo` 
					INNER JOIN `recipe_ingredients` ON `recipeInfo`.`recipeID` = `recipe_ingredients`.`recipeID` 
					WHERE `ingredientName` IN (?) 
					GROUP BY `recipeInfo`.`recipeName`, `recipeImage` ";
		*/
		$query = 	"SELECT `recipeInfo`.recipeID, `recipeInfo`.recipeName, 
						GROUP_CONCAT(ingredientName) AS ingredientName, `recipeImage` 
					FROM `recipeInfo` 
					INNER JOIN `recipe_ingredients` ON `recipeInfo`.`recipeID` = `recipe_ingredients`.`recipeID` 
					WHERE `ingredientName` IN (" . $inStr . ") GROUP BY `recipeInfo`.`recipeName`, `recipeImage` ";


        $results = array();	
        $counter = 0;
        $recipe_id = 1;
        
        $stmt = self::$dbCon->prepare($query);
        //$stmt->bind_param('s', $savedItem);
        $stmt->execute();
        $stmt->bind_result($recipeID, $recipeName, /*$ingredientID,*/ $ingredientName, $recipeImage);
        
        while($stmt->fetch()) {

			//Need to iterate over each recipe record and determine if the ingredients
			//in list contained in ingredients list.
			
			$ingredientsListRS = explode(",",$ingredientName);

			//Matching ingredients in recipe case
			if(sizeof($ingredientsListRS) == sizeof($item)) {

				$recipeExists = true;
				$ingredientFoundCounter = 0;
				foreach($ingredientsListRS as $currItem) {
					$ingredientFound = false;

					foreach($item as $myIngredient) {

						//ingredients not contained in recipe
						if(strtoupper($myIngredient) == strtoupper($currItem)) {
							//$recipeExists = false;
							$ingredientFound = true;
							//$ingredientFoundCounter++;
							break;
						}

						//if(sizeof(item) == $ingredientFoundCounter) {
						//	$recipeExists = true;
						//}

					}

					if($ingredientFound) {
						$ingredientFoundCounter++;
					}
				}

				if(sizeof($item) == $ingredientFoundCounter) {
					$recipeExists = true;
				}

				if($recipeExists) {
				
					$results[$counter]['recipe_id'] = $recipeID;
					$results[$counter]['recipe_name'] = $recipeName;
					//$results[$counter]['ingredient_id'] = $ingredientID;
					$results[$counter]['ingredient_name'] = $ingredientName;
					$results[$counter]['recipe_image'] = $recipeImage;
					$counter++;
				}
			}
			

            /*
            $results[$counter]['recipe_name'] = $recipeName;
            //$results[$counter]['ingredient_id'] = $ingredientID;
            $results[$counter]['ingredient_name'] = $ingredientName;
            $results[$counter]['recipe_image'] = $recipeImage;
			$counter++;
			*/
        }
        
        //findRecipe is looking for exact case scenario. Recipes must match
        //exactly.
        //$temp = $this->findRecipe($results, $item);
        
        //if( $temp != -1 ) {
        //    $list_of_recipes[$tracker] = $temp;
        //    $tracker++;
        //}
		
		
		$stmt->close();
		
		return $results;
	}
	
	function findRecipe($recipes, $item) {
		
		$counter = 0;
		//$list_of_recipes = array();
		$list_of_recipes = -1;
		$ingredient_count = 0;
		$recipe_size = sizeof($recipes);
		$item_size = sizeof($item);
		//echo " size of recipe: " . $recipe_size . " ";
		foreach( $item as $items ) {
			
			foreach($recipes as $recipe) {
				
				if( $items == $recipe['ingredient_name'] ) {
					$ingredient_count++;
					$counter++;
				}
					
				
			}
						
			//echo "ID is [" . $recipe['recipe_id'] . "], ingredientID is: " . $recipe['ingredient_id'] . " ingredientName is: " . $recipe['ingredient_name'] . " ";
		}
		
		if($ingredient_count == $recipe_size && $ingredient_count != 0 && $item_size == $recipe_size) {
			//echo "Found a Recipe!";
			$list_of_recipes = $recipe['recipe_id']; 
			
		}
			
		//echo "Found a Recipe!";
		return $list_of_recipes;
    }
    
    function findRecipeContains($recipes, $item) {
		
		$counter = 0;
		//$list_of_recipes = array();
		$list_of_recipes = -1;
		$ingredient_count = 0;
		$recipe_size = sizeof($recipes);
		$item_size = sizeof($item);
		//echo " size of recipe: " . $recipe_size . " ";
		foreach( $item as $items ) {
			
			foreach($recipes as $recipe) {
				
				if( $items == $recipe['ingredient_name'] ) {
					$ingredient_count++;
					$counter++;
				}
					
				
			}
						
			//echo "ID is [" . $recipe['recipe_id'] . "], ingredientID is: " . $recipe['ingredient_id'] . " ingredientName is: " . $recipe['ingredient_name'] . " ";
		}
		
		if($ingredient_count == $recipe_size && $ingredient_count != 0 && $item_size == $recipe_size) {
			//echo "Found a Recipe!";
			$list_of_recipes = $recipe['recipe_id']; 
			
		}
			
		//echo "Found a Recipe!";
		return $list_of_recipes;
	}
	
	function getRecipeInfo($recipe_id) {
		
		$results = array();
		$counter = 0;
		$query = "SELECT `recipe_id`, `recipe_name`, `recipe_description`, `recipe_image` FROM `recipe_info`
					WHERE `recipe_id` = ?";
		
		$stmt = self::$dbCon->prepare($query);
		$stmt->bind_param('i', $recipe_id);
		$stmt->execute();
		$stmt->bind_result($recipe_id, $recipe_name, $recipe_description, $recipe_image);
		
		while( $stmt->fetch() ) {		
			$results[$counter]['recipe_id'] = $recipe_id;
			$results[$counter]['recipe_name'] = $recipe_name;
			$results[$counter]['recipe_description'] = $recipe_description;
			$results[$counter]['recipe_image'] = $recipe_image;
			$counter++;
		}
		
		$stmt->close();
				
		return $results;	
	}
	
}

?>