<?php

namespace App\Repository\Services\Mumble;

use App\Entity\Services\Mumble\MumblePlan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MumblePlan>
 *
 * @method MumblePlan|null find($id, $lockMode = null, $lockVersion = null)
 * @method MumblePlan|null findOneBy(array $criteria, array $orderBy = null)
 * @method MumblePlan[]    findAll()
 * @method MumblePlan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MumblePlanRepository extends ServiceEntityRepository {

	public function __construct(ManagerRegistry $registry) {
		parent::__construct($registry, MumblePlan::class);
	}

}
