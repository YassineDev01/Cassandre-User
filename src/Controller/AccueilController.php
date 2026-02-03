<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }

    #[Route('/service', name: 'app_service')]
    public function service(): Response
    {
        return $this->render('pages/Contact.html.twig');
    }

    #[Route('/a-propos', name: 'app_apropos')]
    public function apropos(): Response
    {
        return $this->render('pages/Apropos.html.twig');
    }

    #[Route('/audits', name: 'app_audits')]
    public function audits(): Response
    {
        return $this->render('pages/AuditsDeSecurite.html.twig');
    }

    #[Route('/certifications', name: 'app_certifications')]
    public function certifications(): Response
    {
        return $this->render('pages/CertificationsProfessionnelles.html.twig');
    }

    #[Route('/documentation', name: 'app_documentation')]
    public function documentation(): Response
    {
        return $this->render('pages/Documentation.html.twig');
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(): Response
    {
        return $this->render('pages/Contact.html.twig');
    }
}
