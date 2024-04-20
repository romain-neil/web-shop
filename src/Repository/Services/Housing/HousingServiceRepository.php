<?php
namespace App\Repository\Services\Housing;

use App\Entity\Services\Housing\HousingService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HousingService>
 *
 * @method HousingService|null find($id, $lockMode = null, $lockVersion = null)
 * @method HousingService|null findOneBy(array $criteria, array $orderBy = null)
 * @method HousingService[]    findAll()
 * @method HousingService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HousingServiceRepository extends ServiceEntityRepository {

	public function __construct(ManagerRegistry $registry) {
		parent::__construct($registry, HousingService::class);
	}

}
