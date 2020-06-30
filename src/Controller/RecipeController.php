<?php

namespace App\Controller;

use DateTime;
use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Repository\StepRepository;
use App\Repository\UnitRepository;
use App\Repository\RecipeRepository;
use App\Repository\PictureRepository;
use App\Repository\CategoryRepository;
use App\Repository\QuantityRepository;
use App\Repository\IngredientRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecipeController extends AbstractController
{
    /**
     * @Route("/recipe", name="recipe")
     */
    public function index(RecipeRepository $repository)
    {
        $recipes = $repository->findAll();

        return $this->render('recipe/index.html.twig', [
            'controller_name' => 'RecipeController',
            'recipes' => $recipes,
        ]);
    }

    /**
     * @Route("/recipe/new", name="recipeAdd")
     */
    public function addRecipe(Request $request, Recipe $recipe = null)
    {
        $new = false;
        if (!$recipe) {
            $recipe = new Recipe();
            $recipe->setUser($this->getUser());
            $recipe->setRecipeIsValid(False);
            $recipe->setRecipeCreatedAt(new \DateTime());
            $new = true;
        }

        $formRecipe = $this->createForm(RecipeType::class, $recipe);
        $formRecipe->handleRequest($request);
        if ($formRecipe->isSubmitted() && $formRecipe->isValid()) {

            $recipe = $formRecipe->getData();
            dump($recipe);
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($recipe);
            $entityManager->flush();
            $this->addFlash('success', "Décrivez vos étapes maintenants.");

            if ($new) {
                return $this->redirectToRoute('stepAdd', ['id' => $recipe->getId()]);
            } else {
                return $this->redirectToRoute('stepEdit', [
                    'id' => $recipe->getId()
                ]);
            }
        }
        return $this->render('recipe/crudRecipe.html.twig', [
            'controller_name' => 'RecipeController',
            'form' => $formRecipe->createView(),
            'id' => $recipe->getId()
        ]);
    }

    /**
     * @Route("/recipe/delete/{id}", name="recipeDelete")
     */
    public function delete(Recipe $recipe)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($recipe);
        $entityManager->flush();

        return $this->redirectToRoute('recipe');
    }

    /**
     * @Route("/recipe/read/{id}", name="recipeRead")
     */
    public function readRecipe(Recipe $recipe, QuantityRepository $quantityRepo, PictureRepository $pictureRepo, IngredientRepository $ingredientRepo, UnitRepository $unitRepo, StepRepository $stepRepo)
    {

        $listeIngredient = $quantityRepo->findBy(['recipe' => $recipe]);

        $listStep = $stepRepo->findBy(['recipe' => $recipe]);

        $ingredientArray = array();
        $unitArray = array();
        $globalArray = array();
        $quantityArray = array();
        foreach ($listeIngredient as $key => $item) {
            $ingredient = $ingredientRepo->findBy(['id' => $item->getIngredient()]);
            array_push($ingredientArray, $ingredient);
            $unit = $unitRepo->findBy(['id' => $item->getUnit()]);
            array_push($unitArray, $unit);
            array_push($quantityArray, $item);
        }
        //Création de la chaine de caractère pour les ingrédients
        for ($i = 0; $i < count($ingredientArray); $i++) {
            $chaine = $ingredientArray[$i];
            $test = $chaine[0]->getIngredientName();
            $chaine4 = $quantityArray[$i];
            $test4 = $chaine4->getQuantity();
            $chaine2 = $unitArray[$i];
            $test2 = $chaine2[0]->getUnit();
            $chaine3 = $test . ": " . $test4 . $test2;
            array_push($globalArray, $chaine3);
        }

        $picture = $pictureRepo->findBy(['recipe' => $recipe]);
        dump($picture);
        return $this->render('recipe/readRecipe.html.twig', [
            'controller_name' => 'RecipeController',
            'recipe' => $recipe,
            'listeIngredient' => $globalArray,
            'listeEtapes' => $listStep,
            'picture' => $picture
        ]);
    }

    /**    
     * @Route("/recipe/js", name="recipeJS")
     */
    public function recipeEdit(CategoryRepository $repositoryCategory,UserInterface $user, UserRepository $userRepo)
    {
        $username_user= $user->getUsername();
        $utilisateur = $userRepo->findBy(['username' => $username_user]);
        $id_user = $utilisateur[0]->getId();
        
        $categories = $repositoryCategory->findAll();
        return $this->render('recipe/editRecipe.html.twig', [
            'controller_name' => 'RecipeController',
            'categories' => $categories,
            'idUser' => $id_user
        ]);
    }
}
