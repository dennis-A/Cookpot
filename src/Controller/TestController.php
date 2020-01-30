<?php

namespace App\Controller;

use App\Entity\RecipeInfo;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
        //return new Response("hello");
        return $this->render('index.html.twig');
        /*
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/TestController.php',
        ]);
        */
    }

    /**
     * @Route("/recipe")
     */
    public function getRecipe(Request $request) {
        /*
        return $this->json([
            'message' => 'Hello World!',
            'path' => 'some/path'
        ]);
        */
        //var_dump($recipeId);
        //exit();


        /*
        return $this->json([
            "recipe_id" => 1,
            "name" => "Tuna Rotini Salad",
            "ingredient_name" => "Tomatoes",
            "recipe_image" => "TunaRotiniSalad.jpg"
        ]);
        */
        
        //Save
        /*
        $entityManager = $this->getDoctrine()->getManager();
        $recipeInfo = new RecipeInfo();
        */

        //$recipeInfo = $this->getDoctrine()->getRepository(RecipeInfo::class)->findAll();
        //$recipeInfo = $this->getDoctrine()->getRepository(RecipeInfo::class)->find($recipeId);
        //$recipeInfo = $this->getDoctrine()->getRepository(RecipeInfo::class)->findByExampleField($recipeId);
        //$queryStr = ['chicken'];

        /*
        $queryStr = $request->query->get('ingredientsData');
        $recipeInfo = [];
        if(isset($queryStr)) {
            $recipeInfo = $this->getDoctrine()->getRepository(RecipeInfo::class)->findByExampleField($queryStr);
        }
        */


        $queryStr = $request->query->get('ingredientsData');
        
        $recipeInfo = [];
        if(isset($queryStr)) {
            //$recipeInfo = $this->getDoctrine()->getRepository(RecipeInfo::class)->findByExampleField($queryStr);

            $ch = curl_init();
            //$ch = curl_init("https://www.google.com/");
            //$url = 'https://api.edamam.com/search?q=chicken,watermelon&app_id=91fb41c0&app_key=f4714ea59c5315a0a39801c8b26c86ff';
            $query = implode(",", $queryStr);
            $url = 'https://api.edamam.com/search?q=' . $query . '&app_id=91fb41c0&app_key=f4714ea59c5315a0a39801c8b26c86ff';
            //$url = 'https://www.google.com';
            //$requestBody = "?q=chicken,watermelon&app_id=91fb41c0&app_key=f4714ea59c5315a0a39801c8b26c86ff";
            //curl_setopt($ch, CURLOPT_URL, 'https://api.edamam.com/search'. $requestBody);
            curl_setopt($ch, CURLOPT_URL, $url);
            //curl_setopt($ch, CURLOPT_HEADER, TRUE); //
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            //curl_setopt($ch, CURLOPT_TIMEOUT, 3);
            curl_setopt($ch,CURLOPT_USERAGENT,'User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64)');
        
            //$output=curl_exec($ch);

            $content = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error: ' . curl_error($ch);
            }
            curl_close($ch);

            //var_dump($content);
            
            //exit();
            //array_values($queryStr)
        }


        $jsonItem = [];
        $recipeInfo = json_decode($content);
        //var_dump($recipeInfo);
        //var_dump($recipeInfo->hits);
        //exit();
        foreach($recipeInfo->hits as $items) {
            
            //var_dump($items);
            if($items) {
                foreach($items as $recipeInfo) {
                    if($recipeInfo) {
                        $currRecipe = array(
                            "recipe_id" => 1,
                            "name" => $recipeInfo->label,
                            //"ingredient_name" => "tomatoes",
                            "ingredient_name" => "ingredient",
                            "recipe_calories" => $recipeInfo->calories,
                            "recipe_totalTime" => $recipeInfo->totalTime,
                            "recipe_url" => $recipeInfo->url,
                            "recipe_image" => $recipeInfo->image
                        );
            
                        array_push($jsonItem, $currRecipe);
                    }
                }
            }
            
            /*
            foreach($info["hits"] as $hits) {
                var_dump($hits);
                exit();
            }

            $currRecipe = array(
                "recipe_id" => 1,
                "name" => $info.recipe.label,
                //"ingredient_name" => "tomatoes",
                "ingredient_name" => "ingredient",
                "recipe_image" => $info.recipe.image
            );

            array_push($jsonItem, $currRecipe);
            */

        }
        //exit();

        // foreach($recipeInfo as $info) {
        //     //echo $info->getRecipeId();
        //     //var_dump($info);
        //     $currRecipe = array(
        //         "recipe_id" => $info->getRecipeId(),
        //         "name" => $info->getRecipeName(),
        //         //"ingredient_name" => "tomatoes",
        //         "ingredient_name" => $queryStr,
        //         "recipe_image" => $info->getRecipeImage()
        //     );

        //     array_push($jsonItem, $currRecipe);
        // }

        /*
        $jsonItem = array(
            "recipe_id" => $recipeId,
            "name" => "Tuna Rotini Salad",
            "ingredient_name" => "Tomatoes",
            "recipe_image" => "TunaRotiniSalad.jpg"
        );
        */
        //$jsonItem = $recipeInfo;

        return $this->json($jsonItem);
    }

    /**
     * @Route("/hello", name="recipe")
     */
    public function hello() {
        return new Response("hello there");
    }
}
