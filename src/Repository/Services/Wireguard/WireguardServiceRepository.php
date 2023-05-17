<?php
namespace App\Repository\Services\Wireguard;

use App\Entity\Services\Wireguard\WireguardService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WireguardService>
 *
 * @method WireguardService|null find($id, $lockMode = null, $lockVersion = null)
 * @method WireguardService|null findOneBy(array $criteria, array $orderBy = null)
 * @method WireguardService[]    findAll()
 * @method WireguardService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WireguardServiceRepository extends ServiceEntityRepository {

	public function __construct(ManagerRegistry $registry) {
		parent::__construct($registry, WireguardService::class);
	}

	public function add(WireguardService $entity, bool $flush = false): void {
		$this->getEntityManager()->persist($entity);

		if ($flush) {
			$this->getEntityManager()->flush();
		}
	}

	public function remove(WireguardService $entity, bool $flush = false): void {
		$this->getEntityManager()->remove($entity);

		if ($flush) {
			$this->getEntityManager()->flush();
		}
	}

}
