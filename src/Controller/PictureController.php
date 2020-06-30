<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Entity\Picture;
use App\Form\PictureType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PictureController extends AbstractController
{
    /**
     * @Route("/picture/{id}/new", name="picture")
     */
    public function index(Request $request, CacheManager $cacheManager, UploaderHelper $helper, Recipe $recipe)
    {
        $picture = new Picture();
        $formPicture = $this->createForm(PictureType::class, $picture);
        $formPicture->handleRequest($request);
        if ($formPicture->isSubmitted() && $formPicture->isValid()) {
            $picture->setRecipe($recipe);
            if ($picture->getImageFile() instanceof UploadedFile) {
                $cacheManager->remove($helper->asset($picture, 'imageFile'));
            }

            if (!$picture->getId()) {
                $picture->setUpdatedAt(new \DateTime());
            }
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($picture);
            $entityManager->flush();

            return $this->redirectToRoute('home');

        }



        return $this->render('picture/pictureEdit.html.twig', [
            'controller_name' => 'PictureController',
            'form' => $formPicture->createView(),
        ]);
    }
}
