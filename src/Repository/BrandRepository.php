<?php

namespace App\Repository;

use App\Entity\Brand;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;

/**
 * @extends ServiceEntityRepository<Brand>
 */
final class BrandRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private readonly LoggerInterface $logger
    )
    {
        parent::__construct($registry, Brand::class);
    }

    public function save(Brand $brand): void
    {
        try {
            $this->getEntityManager()->persist($brand);
            $this->flush();
        } finally {
            $this->logger->info('Created brand', ['id' => $brand->getId()]);
        }

    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }
}
