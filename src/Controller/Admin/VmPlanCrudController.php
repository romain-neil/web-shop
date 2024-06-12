<?php
namespace App\Controller\Admin;

use App\Entity\Services\VirtualMachine\VmPlan;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class VmPlanCrudController extends AbstractCrudController {

	public static function getEntityFqcn(): string {
		return VmPlan::class;
	}

	public function configureFields(string $pageName): iterable
	{
		return [
			IdField::new('id'),
			TextField::new('commercial_name', 'Nom commercial'),
			NumberField::new('storage', 'Stockage (Go)'),
			NumberField::new('proc', 'vCPU'),
			NumberField::new('network', 'Bande passante (Mbps)'),
			MoneyField::new('price', 'prix')->setCurrency('EUR'),
		];
	}

}
