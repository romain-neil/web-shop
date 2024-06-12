<?php
namespace App\Controller\Admin;

use App\Entity\Services\Housing\DatacenterInfos;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DatacenterInfosCrudController extends AbstractCrudController {

	public static function getEntityFqcn(): string {
		return DatacenterInfos::class;
	}

	public function configureFields(string $pageName): iterable {
		return [
			TextField::new('name', 'Nom'),
			TextField::new('dc_address', 'Adresse'),
			TextField::new('dc_tier', 'Tier'),
			BooleanField::new('has_certificate', 'Certifié')
		];
	}

}
