<?php
namespace App\Repository\Services;

use App\Entity\Services\AbstractServicePlan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AbstractServicePlan>
 *
 * @method AbstractServicePlan|null find($id, $lockMode = null, $lockVersion = null)
 * @method AbstractServicePlan|null findOneBy(array $criteria, array $orderBy = null)
 * @method AbstractServicePlan[]    findAll()
 * @method AbstractServicePlan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AbstractServicePlanRepository extends ServiceEntityRepository {

	public function __construct(ManagerRegistry $registry) {
		parent::__construct($registry, AbstractServicePlan::class);
	}

}
