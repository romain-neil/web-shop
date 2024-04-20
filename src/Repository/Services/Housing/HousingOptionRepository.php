<?php
namespace App\Repository\Services\Housing;

use App\Entity\Services\Housing\HousingOption;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HousingOption>
 *
 * @method HousingOption|null find($id, $lockMode = null, $lockVersion = null)
 * @method HousingOption|null findOneBy(array $criteria, array $orderBy = null)
 * @method HousingOption[]    findAll()
 * @method HousingOption[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HousingOptionRepository extends ServiceEntityRepository {
	public function __construct(ManagerRegistry $registry) {
		parent::__construct($registry, HousingOption::class);
	}

}
