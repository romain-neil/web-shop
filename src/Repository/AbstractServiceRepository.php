<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\AbstractService;

/**
 * @extends ServiceEntityRepository<AbstractService>
 *
 * @method AbstractService|null find($id, $lockMode = null, $lockVersion = null)
 * @method AbstractService|null findOneBy(array $criteria, array $orderBy = null)
 * @method AbstractService[]    findAll()
 * @method AbstractService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AbstractServiceRepository extends ServiceEntityRepository {

	public function __construct(ManagerRegistry $registry) {
		parent::__construct($registry, AbstractService::class);
	}

	/**
	 * @param int $serverId
	 * @return AbstractService[]
	 */
	public function findByServer(int $serverId): array {
		return $this->createQueryBuilder('s')
			->andWhere('s.server = :sId')
			->setParameter('sId', $serverId)
			->getQuery()
			->getResult();
	}

}
