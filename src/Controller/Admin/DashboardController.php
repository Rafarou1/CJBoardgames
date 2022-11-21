<?php

namespace App\Controller\Admin;

use App\Entity\Boardgame;
use App\Entity\Player;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Reserve;
use App\Entity\Armoire;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        // return parent::index();
        // redirect to some CRUD controller
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(ReserveCrudController::class)->generateUrl();
        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('CJBoardgames admin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Reserves', 'fas fa-list', Reserve::class);
        yield MenuItem::linkToCrud('Boardgames', 'fas fa-list', Boardgame::class);
        yield MenuItem::linkToCrud('Player', 'fas fa-list', Player::class);
        yield MenuItem::linkToCrud('Armoire', 'fas fa-fa-list', Armoire::class);
    }
}
