<?php

namespace App\Repository\Infra;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Infra\ServiceIp;

/**
 * @extends ServiceEntityRepository<ServiceIp>
 *
 * @method ServiceIp|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServiceIp|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServiceIp[]    findAll()
 * @method ServiceIp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceIpRepository extends ServiceEntityRepository {

	public function __construct(ManagerRegistry $registry) {
		parent::__construct($registry, ServiceIp::class);
	}

	public function save(ServiceIp $entity, bool $flush = false): void {
		$this->getEntityManager()->persist($entity);

		if ($flush) {
			$this->getEntityManager()->flush();
		}
	}

	public function remove(ServiceIp $entity, bool $flush = false): void {
		$this->getEntityManager()->remove($entity);

		if ($flush) {
			$this->getEntityManager()->flush();
		}
	}

}
