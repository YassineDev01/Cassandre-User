<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;


use App\Entity\User;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;



#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    /**
     * Page d’accueil de l’admin
     */
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        return $this->redirect(
            $adminUrlGenerator
                // par défaut, affichage la class UserCrudController
                ->setController(UserCrudController::class)
                ->generateUrl()
        );
    }

    /**
     * Titre du dashboard
     */
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Cassandre test');
    }



    /**
     * Configuration globale des pages CRUD
     */
    public function configureCrud(): Crud
    {
        return Crud::new()
            ->renderContentMaximized();
    }



    /**
     * Menu de navigation
     */
    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('User', 'fas fa-user', User::class);

        yield MenuItem::linkToUrl('Voir le site', 'fas fa-globe', $this->generateUrl('app_accueil'))
            ->setLinkTarget('_blank'); // ouvre dans un nouvel onglet
    }
}
