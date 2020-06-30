<?php

namespace App\Controller;

use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/api", name="api_")
 */
class APIController extends AbstractController
{
    /**
    * @Route("/recettes/liste", name="liste", methods={"GET"})
    */
    public function liste(RecipeRepository $recipeRepository)
    {
        // On récupère la liste des recettes
        $recipes = $recipeRepository->findAll();
        // On spécifie qu'on utilise un encodeur en json
        $encoders = [new JsonEncoder()];
        // On intstancie les "normaliseur" pour convertir la collection en tableau
        $normalizers = [new ObjectNormalizer()];
        // On fait la conversion en json
        // On instancie le convertisseur
        $serializer = new Serializer($normalizers, $encoders);
        // On convertit en json (l'option permet de ne pas faire de CircularError - quand le pointeur se pointe lui même)
        $jsonContent = $serializer->serialize($recipes, 'json', [
            'circular_reference_handler'=>function($object) {
                return $object->getId();
            }
        ]);
        // On instancie la réponse de Symfony
        $response = new Response($jsonContent);
        // On ajoute à la réponse une entête HTTP
        $response->headers->set('Content-Type', 'aplication/json');
        // Enfin, on envoie la réponse
        return $response;
        //dd($jsonContent);
    }
}
