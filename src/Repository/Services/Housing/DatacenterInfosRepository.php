<?php
namespace App\Repository\Services\Housing;

use App\Entity\Services\Housing\DatacenterInfos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DatacenterLocation>
 *
 * @method DatacenterLocation|null find($id, $lockMode = null, $lockVersion = null)
 * @method DatacenterLocation|null findOneBy(array $criteria, array $orderBy = null)
 * @method DatacenterLocation[]    findAll()
 * @method DatacenterLocation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DatacenterInfosRepository extends ServiceEntityRepository {

	public function __construct(ManagerRegistry $registry) {
		parent::__construct($registry, DatacenterInfos::class);
	}

}
