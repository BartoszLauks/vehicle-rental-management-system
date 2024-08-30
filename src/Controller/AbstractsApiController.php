<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

abstract class AbstractsApiController extends AbstractController
{
    private const DEFAULT_SERIALIZATION_GROUP = 'Default';
    private const PAGINATION_COLLECTION_GROUP = 'PaginatedCollection';

    protected function __construct(
        private readonly SerializerInterface $serializer
    ) {
    }

    protected function respond(
        mixed $data,
        array $groups = [],
        int $statusCode = Response::HTTP_OK,
    ): Response {
        array_push($groups, self::DEFAULT_SERIALIZATION_GROUP, self::PAGINATION_COLLECTION_GROUP);
        $context = [
            AbstractNormalizer::GROUPS => $groups,
        ];
        $serializedData = $this->serializer->serialize($data, 'json', $context);

        return new Response($serializedData, $statusCode, [
            'Content-type' => 'application/json',
        ]);
    }
}