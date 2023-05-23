<?php

namespace App\Repository\Services\VirtualMachine;

use App\Entity\Services\VirtualMachine\VmBackup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VmBackup>
 *
 * @method VmBackup|null find($id, $lockMode = null, $lockVersion = null)
 * @method VmBackup|null findOneBy(array $criteria, array $orderBy = null)
 * @method VmBackup[]    findAll()
 * @method VmBackup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VmBackupRepository extends ServiceEntityRepository {

	public function __construct(ManagerRegistry $registry) {
		parent::__construct($registry, VmBackup::class);
	}

	public function save(VmBackup $entity, bool $flush = false): void {
		$this->getEntityManager()->persist($entity);

		if ($flush) {
			$this->getEntityManager()->flush();
		}
	}

	public function remove(VmBackup $entity, bool $flush = false): void {
		$this->getEntityManager()->remove($entity);

		if ($flush) {
			$this->getEntityManager()->flush();
		}
	}

}
