<?php

namespace App\Form;

use App\Entity\Server;
use App\Entity\ServiceRegion;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServerType extends AbstractType {

	public function buildForm(FormBuilderInterface $builder, array $options): void {
		$builder
			->add('name', TextType::class, [
				'label' => 'Nom :'
			])
			->add('region', EntityType::class, [
				'label' => 'Région',
				'class'=> ServiceRegion::class
			]);
	}

	public function configureOptions(OptionsResolver $resolver): void {
		$resolver->setDefaults([
			'data_class' => Server::class,
		]);
	}

}
