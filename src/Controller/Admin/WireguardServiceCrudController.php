<?php
namespace App\Controller\Admin;

use App\Entity\Services\Wireguard\WireguardService;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class WireguardServiceCrudController extends AbstractCrudController {

	public static function getEntityFqcn(): string {
		return WireguardService::class;
	}

	public function configureFields(string $pageName): iterable {
		return [
			IdField::new('id'),
			TextField::new('ipv4')->setDisabled(),
			TextField::new('ipv6')->setDisabled(),
		];
	}

}
