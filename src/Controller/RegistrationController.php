<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Role;
use App\Enum\RoleCode;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Hash du mot de passe
            $hashedPassword = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);

            // Activer l'utilisateur
            $user->setActif(true);

            // Attribuer le rôle par défaut (USER)
            $roleUser = $entityManager->getRepository(Role::class)
                ->findOneBy(['code' => RoleCode::USER]);

            if ($roleUser) {
                $user->setRole($roleUser);
            } else {
                // Sécurité : lancer une exception si le rôle n'existe pas
                throw new \LogicException('Le rôle USER doit exister en base.');
            }

            // Enregistrer en base
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Votre compte a été créé avec succès !');

            // Redirection vers la page de login
            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/index.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
