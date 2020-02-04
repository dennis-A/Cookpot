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
        return $this->render('index.html.twig');
    }

    /**
     * @Route("/login", name="login")
     */
    public function login()
    {
        return $this->render('login.html.twig');
    }

    /**
     * @Route("/recipe")
     */
    public function getRecipe(Request $request) {
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
            $query = implode(",", $queryStr);
            $url = 'https://api.edamam.com/search?q=' . $query . '&app_id=91fb41c0&app_key=f4714ea59c5315a0a39801c8b26c86ff';
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
        }

        $jsonItem = [];
        $recipeInfo = json_decode($content);

        foreach($recipeInfo->hits as $items) {
            
            //var_dump($items);
            if($items) {
                foreach($items as $recipeInfo) {
                    if($recipeInfo) {
                        $currRecipe = array(
                            "recipe_id" => 1,
                            "name" => $recipeInfo->label,
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
        }

        return $this->json($jsonItem);
    }

    /**
     * @Route("/hello", name="recipe")
     */
    public function hello() {
        return new Response("hello there");
    }
}
