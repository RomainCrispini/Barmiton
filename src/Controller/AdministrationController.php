<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditUserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Require ROLE_ADMIN for *every* controller method in this class.
 * @IsGranted("ROLE_ADMIN")
 */
class AdministrationController extends AbstractController
{
    /**
     * @Route("/administration", name="administration")
     */
    public function index()
    {
        return $this->render('administration/index.html.twig',[
            'controller_name' =>"administration"
        ]);
    }

    /**
     * @Route("/administration/users", name="administration_users")
     * 
     */
    public function Users(UserRepository $users)
    {
        return $this->render("administration/users.html.twig", [
            'users' => $users->findAll(),
            'controller_name' =>"administration"
        ]);
    }

    /**
     * Modifier un utilisateur
     * @Route("/administration/edituser/{id}", name="administration_edituser")
     */
    public function editUser(User $user, Request $request)
    {
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->persist($user);
            $entitymanager->flush();

            $this->addFlash('message', 'utilisateur modifié avec succés');
            return $this->redirectToRoute('administration_users');
        }
        return $this->render('administration/edituser.html.twig', [
            'userForm' => $form->createView(),
            'controller_name' =>"administration"
        ]);
    }
}
