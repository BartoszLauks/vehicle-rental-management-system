<?php

namespace App\Repository;

use App\Entity\Promotions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Promotions>
 */
class PromotionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Promotions::class);
    }
    public function save(Promotions $promotions): void
    {
        $this->getEntityManager()->persist($promotions);
        $this->flush();
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }
}
