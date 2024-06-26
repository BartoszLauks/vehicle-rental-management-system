<?php

declare(strict_types=1);

namespace App\Paginator;

use App\DTO\PaginatedCollection;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Response;

class Paginator
{
    public const PAGINATION_DEFAULT_PAGE = 1;

    public const PAGINATION_DEFAULT_LIMIT = 20;

    public const PAGINATION_DEFAULT_PER_PAGE = 10;

    public function createPaginator(
      QueryBuilder $queryBuilder,
      int $page = self::PAGINATION_DEFAULT_PAGE,
      int $limit = self::PAGINATION_DEFAULT_LIMIT,
      int $perPage = self::PAGINATION_DEFAULT_PER_PAGE,
      bool $fetchJoinsCollection = false,
      bool $userOutputWalkers = false
    ): Pagerfanta {
        $paginator = new Pagerfanta(new QueryAdapter($queryBuilder, $fetchJoinsCollection, $userOutputWalkers));

        $paginator->setMaxNbPages($limit);


        if ($page > $paginator->getNbPages()) {
            throw new \Exception('Page not found', Response::HTTP_NOT_FOUND);
        }

        $paginator->setMaxPerPage($perPage);
        $paginator->setCurrentPage($page);

        return $paginator;
    }

    public function createPaginatedResponse(iterable $collection, Pagerfanta $paginator): PaginatedCollection
    {
        return new PaginatedCollection(
          $collection,
          $paginator->getNbResults(),
          $paginator->getCurrentPage(),
          $paginator->getNbPages()
        );
    }

    public function createdCustomPaginatedResponse(iterable $collection, array $metadata): PaginatedCollection
    {
        return new PaginatedCollection(
          $collection,
          $metadata['nbResults'],
          $metadata['currentPage'],
          $metadata['nbPages']
        );
    }
}
