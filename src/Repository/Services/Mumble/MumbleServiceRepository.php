<?php

namespace App\Repository\Services\Mumble;

use App\Entity\Services\Mumble\MumbleService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MumbleService>
 *
 * @method MumbleService|null find($id, $lockMode = null, $lockVersion = null)
 * @method MumbleService|null findOneBy(array $criteria, array $orderBy = null)
 * @method MumbleService[]    findAll()
 * @method MumbleService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MumbleServiceRepository extends ServiceEntityRepository {

	public function __construct(ManagerRegistry $registry) {
		parent::__construct($registry, MumbleService::class);
	}

	public function add(MumbleService $entity, bool $flush = false): void {
		$this->getEntityManager()->persist($entity);

		if ($flush) {
			$this->getEntityManager()->flush();
		}
	}

	public function remove(MumbleService $entity, bool $flush = false): void {
		$this->getEntityManager()->remove($entity);

		if ($flush) {
			$this->getEntityManager()->flush();
		}
	}

}
