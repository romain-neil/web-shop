<?php

namespace App\Repository\Services\VirtualMachine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Services\VirtualMachine\VmService;

/**
 * @extends ServiceEntityRepository<VmService>
 *
 * @method VmService|null find($id, $lockMode = null, $lockVersion = null)
 * @method VmService|null findOneBy(array $criteria, array $orderBy = null)
 * @method VmService[]    findAll()
 * @method VmService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VmServiceRepository extends ServiceEntityRepository {

	public function __construct(ManagerRegistry $registry) {
		parent::__construct($registry, VmService::class);
	}

	public function save(VmService $entity, bool $flush = false): void {
		$this->getEntityManager()->persist($entity);

		if ($flush) {
			$this->getEntityManager()->flush();
		}
	}

	public function remove(VmService $entity, bool $flush = false): void {
		$this->getEntityManager()->remove($entity);

		if ($flush) {
			$this->getEntityManager()->flush();
		}
	}

}
