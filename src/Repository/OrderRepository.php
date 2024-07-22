<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Order;

/**
 * @extends ServiceEntityRepository<Order>
 *
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository {

	public function __construct(ManagerRegistry $registry) {
		parent::__construct($registry, Order::class);
	}

	public function save(Order $entity, bool $flush = false): void {
		$this->getEntityManager()->persist($entity);

		if ($flush) {
			$this->getEntityManager()->flush();
		}
	}

	public function remove(Order $entity, bool $flush = false): void {
		$this->getEntityManager()->remove($entity);

		if ($flush) {
			$this->getEntityManager()->flush();
		}
	}

	/**
	 * Return the orders in cart for more than 24 hours
	 * @throws \Exception
	 * @return array
	 */
	public function findStaleOrders(): array {
		$qb = $this->createQueryBuilder('o');

		$now = new \DateTime('now', new \DateTimeZone('UTC'));
		$cutoff = $now->modify('-24 hours');

		$qb->select('o')
			->from('Order'/** @type Order */, 'o')
			->where('o.created <= :cutoff')
			->andWhere('o.in_cart = true')
			->setParameter('cutoff', $cutoff)
		;

		return $qb->getQuery()->getResult();
	}

}
