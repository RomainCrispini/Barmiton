<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{

    /**
     * @var CategoryRepository
     * 
     */
    private $repository;

    public function __construct(CategoryRepository $repository) {
        $this->repository = $repository;
    }
        

    /**
     * @Route("/category", name="category")
     */
    public function index()
    {
        $categories = $this->repository->findAll();
        dump($categories);
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/category/new", name="categoryAdd")
     * @Route("/category/{id}", name="categoryEdit")
     */
    public function category(Category $categories=null, Request $request)
    {
        
        if ( !$categories){
            $categories = new Category;
        }

        $formCategories = $this->createForm(CategoryType::class, $categories);

        $formCategories->handleRequest($request);

        if ($formCategories->isSubmitted() && $formCategories->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categories);
            $entityManager->flush();
            $this->addFlash('success',"Catégori ajouté/modifié");

            return $this->render('category/index.html.twig', [
                'controller_name' => 'CategoryController',
                'categories' => $categories,
            ]);
        }

        return $this->render('category/categoryEdit.html.twig', [
            'controller_name' => 'CategoryController',
            'formCategories' => $formCategories->createView(),
        ]);
    }

    /**
     * @Route("/category/delete/{id}", name="categoryDelete")
     */
    public function delete( Category $categories)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($categories);
        $entityManager->flush();

        return $this->redirectToRoute('category');
    }

}
