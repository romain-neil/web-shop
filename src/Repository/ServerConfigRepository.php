<?php
namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\ServerConfig;

/**
 * @extends ServiceEntityRepository<ServerConfig>
 *
 * @method ServerConfig|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServerConfig|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServerConfig[]    findAll()
 * @method ServerConfig[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServerConfigRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, ServerConfig::class);
    }

    public function save(ServerConfig $entity, bool $flush = false): void {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ServerConfig $entity, bool $flush = false): void {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

}
