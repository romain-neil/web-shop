<?php
namespace App\Controller\Admin;

use App\Entity\Services\Housing\HousingOption;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class HousingOptionCrudController extends AbstractCrudController {

	public static function getEntityFqcn(): string {
		return HousingOption::class;
	}

	public function configureFields(string $pageName): iterable {
		return [
			TextField::new('name', 'Nom commercial'),
			TextField::new('type', 'Type'),
			NumberField::new('quantity', 'Quantité'),

			NumberField::new('base_speed', 'Vitesse de base (Mbps)')->setRequired(false),
			NumberField::new('max_speed', 'Vitesse maximale (Mbps)')->setRequired(false),

			NumberField::new('code', "Code de l'option")
		];
	}

}
