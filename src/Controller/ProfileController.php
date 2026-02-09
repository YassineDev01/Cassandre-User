<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\UserProfileType; 
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;



class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'profile_view')]
    public function view(): Response
    {
        return $this->render('profile/index.html.twig', [
            'content_template' => 'profile/vu.html.twig'
        ]);
    }

   #[Route('/profile/edit', name: 'profile_edit')]
public function edit(Request $request, EntityManagerInterface $em): Response
{
    $user = $this->getUser();

    $form = $this->createForm(UserProfileType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->flush();
        $this->addFlash('success', 'Profil mis à jour avec succès.');

        return $this->redirectToRoute('profile_view');
    }

   return $this->render('profile/index.html.twig', [
        'content_template' => 'profile/edit.html.twig',
        'form' => $form->createView()
    ]);
}

    #[Route('/profile/password', name: 'profile_change_password')]
    public function changePassword(): Response
    {
        return $this->render('profile/index.html.twig', [
            'content_template' => 'profile/change_password.html.twig'
        ]);
    }

    #[Route('/profile/email', name: 'profile_change_email')]
    public function changeEmail(): Response
    {
        return $this->render('profile/index.html.twig', [
            'content_template' => 'profile/change_email.html.twig'
        ]);
    }
}



