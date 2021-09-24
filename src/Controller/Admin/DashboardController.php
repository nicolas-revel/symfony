<?php

namespace App\Controller\Admin;

use App\Controller\Admin\CrudController\UserCrudController;
use App\Entity\User;
use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\Tag;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;


class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(UserCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Blog')
;
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::section('Utilisateurs'),
            MenuItem::linkToCrud('Utilisateurs', 'fa fa-user', User::class),
            
            MenuItem::section('Blog'),
            MenuItem::linkToCrud('Posts', 'fa fa-newspaper', Post::class),
            MenuItem::linkToCrud('Commentaires', 'fa fa-comment', Comment::class),
        ];
    }
}
