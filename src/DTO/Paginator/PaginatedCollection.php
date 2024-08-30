<?php

declare(strict_types=1);

namespace App\DTO\Paginator;

use Symfony\Component\Serializer\Attribute\Groups;

class PaginatedCollection
{
    /** @param mixed[] $items */
    public function __construct(
        #[Groups(groups: ['PaginatedCollection'])]
        public iterable $items,
        #[Groups(groups: ['PaginatedCollection'])]
        public int $total,
        #[Groups(groups: ['PaginatedCollection'])]
        public int $page,
        #[Groups(groups: ['PaginatedCollection'])]
        public int $pagesTotal,
    ) {
    }
}