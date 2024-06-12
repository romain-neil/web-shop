<?php
namespace App\Controller\Admin;

use App\Entity\Services\VirtualMachine\VmService;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class VmServiceCrudController extends AbstractCrudController {

	public static function getEntityFqcn(): string {
		return VmService::class;
	}

	public function configureFields(string $pageName): iterable {
		return [
			IdField::new('id'),
		];
	}

}
