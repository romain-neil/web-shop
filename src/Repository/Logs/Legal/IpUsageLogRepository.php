<?php
namespace App\Repository\Logs\Legal;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Logs\Legal\IpUsageLog;

/**
 * @extends ServiceEntityRepository<IpUsageLog>
 *
 * @method IpUsageLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method IpUsageLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method IpUsageLog[]    findAll()
 * @method IpUsageLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IpUsageLogRepository extends ServiceEntityRepository {

	public function __construct(ManagerRegistry $registry) {
		parent::__construct($registry, IpUsageLog::class);
	}

	public function save(IpUsageLog $entity, bool $flush = false): void {
		$this->getEntityManager()->persist($entity);

		if ($flush) {
			$this->getEntityManager()->flush();
		}
	}

	public function remove(IpUsageLog $entity, bool $flush = false): void {
		$this->getEntityManager()->remove($entity);

		if ($flush) {
			$this->getEntityManager()->flush();
		}
	}

}
