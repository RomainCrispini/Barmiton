<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Entity\Quantity;
use App\Form\QuantityIngredientType;
use App\Repository\QuantityRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IngredientController extends AbstractController
{
    /**
     * @Route("/ingredient", name="ingredient")
     */
    public function index()
    {
        return $this->render('ingredient/ingredientEdit.html.twig', [
            'controller_name' => 'IngredientController',
        ]);
    }

    /**
     * @Route("/ingredient/{id}/new", name="ingredientAdd")
     */
    public function addStep(QuantityRepository $quantityRepository, Request $request, Recipe $recipe)
    {

        $quantity= new Quantity();
        $formQuantity = $this->createForm(QuantityIngredientType::class, $quantity);

        $formQuantity->handleRequest($request);
        if ($formQuantity->isSubmitted() && $formQuantity->isValid()) {

            if (!$quantity->getId()) {
                $quantity->setRecipe($recipe);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($quantity);
            $entityManager->flush();

            return $this->redirectToRoute('ingredientAdd', [
                'id' =>$recipe->getId(),
                'recipe' => $recipe,
                'controller_name' => 'RecipeController',
                'form' => $formQuantity->createView(),
                'quantities' => $quantityRepository->findBy(['recipe' => $recipe ])
            ]);
        }

        return $this->render('ingredient/ingredientEdit.html.twig', [
            'controller_name' => 'RecipeController',
            'form' => $formQuantity->createView(),
            'recipe' => $recipe,
            'quantities' => $quantityRepository->findBy(['recipe' => $recipe ])
            ]);
    }
}
