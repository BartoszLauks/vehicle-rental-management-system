<?php

namespace App\Repository;

use App\Entity\Vehicle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vehicle>
 */
final class VehicleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vehicle::class);
    }

    public function save(Vehicle $vehicle): void
    {
        $this->getEntityManager()->persist($vehicle);
        $this->flush();
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }

    public function delete(Vehicle $vehicle): void
    {
        $this->getEntityManager()->remove($vehicle);
        $this->flush();
    }

    /**
     * @param array<string, string> $params
     */
    public function findWithFilters(array $params = []): QueryBuilder
    {
        $order = 'ASC';

        if (key_exists('order', $params)) {
            $order = $params['order'] === 'DESC' ? 'DESC' : 'ASC';
        }

        $qb = $this->createQueryBuilder('v');

        $qb->orderBy('v.created_at', $order);

        return $qb;
    }

    public function getCountVehicleByBrandGrouping(): array
    {
        return $this->createQueryBuilder('v')
            ->select('b.id', 'b.name', "COUNT(v.brand) AS COUNT")
            ->join('v.brand', 'b')
            ->groupBy('b.name')
            ->getQuery()
            ->getArrayResult();
    }
}
