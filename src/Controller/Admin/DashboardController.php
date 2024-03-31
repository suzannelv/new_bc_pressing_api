<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Client;
use App\Entity\Employee;
use App\Entity\Material;
use App\Entity\OrderDetail;
use App\Entity\OrderStatus;
use App\Entity\Payment;
use App\Entity\Product;
use App\Entity\ServiceOption;
use App\Entity\User;
use App\Entity\ZipCode;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DashboardController extends AbstractDashboardController
{

    public function __construct(private AuthorizationCheckerInterface $authorizationChecker){

    }

    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        return $this->render('bundles/EasyAdminBundle/admin/admin.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<img src="assets/img/logo.svg" style="margin-right: 20px;">Mr.U-Smiley BO <a href="http://localhost:4200/" target=_blank><i class="fa-solid fa-arrow-up-right-from-square"></i> Aller sur le site Front</a>')
            ->setFaviconPath('favicon.ico')
            ->renderContentMaximized();
        
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        if($this->authorizationChecker->isGranted('ROLE_ADMIN')){
            yield MenuItem::linkToCrud('Employées', 'fa-solid fa-user-gear', Employee::class);
        }
        yield MenuItem::linkToCrud('Clients', 'fa-solid fa-users', Client::class);
        yield MenuItem::linkToCrud('Catégories', 'fa-solid fa-list', Category::class);
        yield MenuItem::linkToCrud('Produits', 'fa-solid fa-shirt', Product::class);
        yield MenuItem::linkToCrud('Commandes', 'fa-solid fa-truck', OrderDetail::class);
        yield MenuItem::linkToCrud('Paiements', 'fa-solid fa-credit-card', Payment::class);
        yield MenuItem::linkToCrud('Matières', 'fa-solid fa-recycle', Material::class);
        yield MenuItem::linkToCrud('Services', 'fa-solid fa-jug-detergent', ServiceOption::class);
        yield MenuItem::linkToCrud('Code postale', 'fa-solid fa-map-location-dot', ZipCode::class);
        yield MenuItem::linkToCrud('Status de commande', 'fa-solid fa-hourglass-half', OrderStatus::class);
    }
}
