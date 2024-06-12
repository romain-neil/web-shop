<?php
namespace App\Controller\Admin;

use App\Entity\Services\Housing\DatacenterInfos;
use App\Entity\Services\Housing\HousingOption;
use App\Entity\Services\Housing\HousingService;
use App\Entity\Services\VirtualMachine\VmPlan;
use App\Entity\Services\VirtualMachine\VmService;
use App\Entity\Services\Wireguard\WireguardService;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractDashboardController {

	public function __construct() {}

	public function configureDashboard(): Dashboard {
		return Dashboard::new()
			->setTitle("Panneau d'administration")

			;
	}

	public function configureMenuItems(): iterable {
		return [
			MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),

			MenuItem::section('Services'),

			MenuItem::subMenu('DC', 'fa-solid fa-warehouse')->setSubItems([
				MenuItem::linkToCrud('Datacenter', '', DatacenterInfos::class),
				MenuItem::linkToCrud('Options', 'fa-solid fa-file-lines', HousingOption::class),
				MenuItem::linkToCrud('Services', 'fa-solid fa-file-lines', HousingService::class),
			]),

			MenuItem::subMenu('VM', 'fa-solid fa-cloud')->setSubItems([
				MenuItem::linkToCrud('Plans', 'fa-solid fa-file-lines', VmPlan::class),
				MenuItem::linkToCrud('Machines virtuelles', '', VmService::class),
			]),

			MenuItem::subMenu('WG')->setSubItems([
				MenuItem::linkToCrud('Tunnels wireguard', '', WireguardService::class),
			]),

//
//
//			MenuItem::section('')
		];
	}

	#[Route('/admin')]
	public function index(): Response {
		return $this->render('admin/dashboard.html.twig');
	}

	// ...
}
