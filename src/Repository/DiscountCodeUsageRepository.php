<?php
namespace App\Repository;

use App\Entity\DiscountCodeUsage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DiscountCodeUsage>
 *
 * @method DiscountCodeUsage|null find($id, $lockMode = null, $lockVersion = null)
 * @method DiscountCodeUsage|null findOneBy(array $criteria, array $orderBy = null)
 * @method DiscountCodeUsage[]    findAll()
 * @method DiscountCodeUsage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiscountCodeUsageRepository extends ServiceEntityRepository {

	public function __construct(ManagerRegistry $registry) {
		parent::__construct($registry, DiscountCodeUsage::class);
	}

}
