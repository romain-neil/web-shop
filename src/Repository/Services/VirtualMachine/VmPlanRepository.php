<?php

namespace App\Repository\Services\VirtualMachine;

use App\Entity\Services\VirtualMachine\VmPlan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VmPlan>
 *
 * @method VmPlan|null find($id, $lockMode = null, $lockVersion = null)
 * @method VmPlan|null findOneBy(array $criteria, array $orderBy = null)
 * @method VmPlan[]    findAll()
 * @method VmPlan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VmPlanRepository extends ServiceEntityRepository {

	public function __construct(ManagerRegistry $registry) {
		parent::__construct($registry, VmPlan::class);
	}

	public function save(VmPlan $entity, bool $flush = false): void {
		$this->getEntityManager()->persist($entity);

		if ($flush) {
			$this->getEntityManager()->flush();
		}
	}

	public function remove(VmPlan $entity, bool $flush = false): void {
		$this->getEntityManager()->remove($entity);

		if ($flush) {
			$this->getEntityManager()->flush();
		}
	}

}
