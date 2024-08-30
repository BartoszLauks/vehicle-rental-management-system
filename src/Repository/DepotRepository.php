<?php

namespace App\Repository;

use App\Entity\Depot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Depot>
 */
class DepotRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Depot::class);
    }

    public function save(Depot $depot): void
    {
        $this->getEntityManager()->persist($depot);
        $this->flush();
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }

    public function findWithFilters(array $params = []): QueryBuilder
    {
        $order = 'ASC';

        if (key_exists('order', $params)) {
            $order = $params['order'] === 'DESC' ? 'DESC' : 'ASC';
        }

        $qb = $this->createQueryBuilder('d');

        $qb->orderBy('d.createdAt', $order);

        return $qb;
    }
}
