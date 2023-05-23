<?php

namespace App\Form;

use App\Entity\AbstractService;
use App\Entity\Server;
use Auth\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceType extends AbstractType {

	public function buildForm(FormBuilderInterface $builder, array $options): void {
		$builder
			->add('channelCounts', NumberType::class, [
				'label' => 'Nombre de personnes :'
			])
			->add('server', EntityType::class, [
				'class' => Server::class,
				'label' => 'Serveur'
			])
			->add('client', EntityType::class, [
				'class' => User::class
			]);
	}

	public function configureOptions(OptionsResolver $resolver): void {
		$resolver->setDefaults([
			'data_class' => AbstractService::class,
		]);
	}

}
