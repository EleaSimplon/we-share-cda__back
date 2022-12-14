<?php

namespace App\Controller\Admin;

use App\Entity\Activity;
use App\Entity\Features;
use App\Entity\FeaturesLabel;
use App\Entity\FeaturesValue;
use App\Entity\Review;
use App\Entity\User;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;


class DashboardController extends AbstractDashboardController
{

    public function __construct(private AdminUrlGenerator $adminUrlGenerator)
    {
    
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {

        $url = $this->adminUrlGenerator
            ->setController(ActivityCrudController::class)
            ->generateUrl();
        
        return $this->redirect($url);

    }


    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('WeShare Admin Dashboard');
    }

    public function configureMenuItems(): iterable
    {
        //yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);

        yield MenuItem::section('Users', 'fa-solid fa-user');
        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Create User', 'fas fa-plus', User::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show Users', 'fas fa-eye', User::class)
        ]);

        yield MenuItem::section('Activities', 'fa-solid fa-earth-europe');
        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Create Activity', 'fas fa-plus', Activity::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show Activities', 'fas fa-eye', Activity::class)
        ]);

        yield MenuItem::section('Reviews', 'fa-solid fa-pen');
        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Create Review', 'fas fa-plus', Review::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show Reviews', 'fas fa-eye', Review::class)
        ]);

        yield MenuItem::section('features Labels', 'fa-solid fa-question');
        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Create Label', 'fas fa-plus', FeaturesLabel::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show Label', 'fas fa-eye', FeaturesLabel::class)
        ]);

        yield MenuItem::section('Features Value', 'fa-solid fa-check');
        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Create Features value', 'fas fa-plus', FeaturesValue::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show Features value', 'fas fa-eye', FeaturesValue::class)
        ]);

        yield MenuItem::section('Features', 'fa-solid fa-check');
        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Create Features', 'fas fa-plus', Features::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show Features', 'fas fa-eye', Features::class)
        ]);

    }

}
