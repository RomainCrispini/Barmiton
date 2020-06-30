<?php

namespace App\Controller;

use App\Entity\Step;
use App\Entity\Recipe;
use App\Form\StepType;
use App\Repository\StepRepository;
use App\Repository\RecipeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StepController extends AbstractController
{
    /**
     * @Route("/step", name="step")
     */
    public function index(StepRepository $repository)
    {

        // $steps = $repository->findBy($step);
        return $this->render('step/index.html.twig', [
            'controller_name' => 'StepController',
        ]);
    }

    /**
     * @Route("/step/{id}/new", name="stepAdd")
     */
    public function addStep(StepRepository $stepRepository, Request $request, Recipe $recipe)
    {

        $step = new Step();
        $numEtape = 1;
       
        $formStep = $this->createForm(StepType::class, $step);

        $formStep->handleRequest($request);
        if ($formStep->isSubmitted() && $formStep->isValid()) {
            if (!$step->getId()) {
               $step->setRecipe($recipe);
            }

            $entityManager = $this->getDoctrine()->getManager();
            // $step->setRecipe($recipe);
            $entityManager->persist($step);
            $entityManager->flush();

            return $this->redirectToRoute('stepAdd', [
                'id' =>$recipe->getId(),
                'recipe' => $recipe,
                'controller_name' => 'StepController',
                'form' => $formStep->createView(),
                'steps' => $stepRepository->findBy(['recipe' => $recipe ]),
                'numEtape' => sizeof($stepRepository->findBy(['recipe' => $recipe ])) + 1
            ]);
        }

        return $this->render('step/stepEdit.html.twig', [
            'controller_name' => 'StepController',
            'form' => $formStep->createView(),
            'recipe' => $recipe,
            'steps' => $stepRepository->findBy(['recipe' => $recipe ]),
            'numEtape' => sizeof($stepRepository->findBy(['recipe' => $recipe ])) + 1
            ]);
    }
}
