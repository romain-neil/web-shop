<?php
namespace App\Repository\Services\Wireguard;

use App\Entity\Services\Wireguard\WgPlan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WgPlan>
 *
 * @method WgPlan|null find($id, $lockMode = null, $lockVersion = null)
 * @method WgPlan|null findOneBy(array $criteria, array $orderBy = null)
 * @method WgPlan[]    findAll()
 * @method WgPlan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WgPlanRepository extends ServiceEntityRepository {

	public function __construct(ManagerRegistry $registry) {
		parent::__construct($registry, WgPlan::class);
	}

}
