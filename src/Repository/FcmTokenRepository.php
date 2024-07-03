<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\RefreshToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;

class FcmTokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RefreshToken::class);
    }

    public function removeAllOldestToken(): void
    {
        try {
            $this->getEntityManager()->getConnection()->prepare(
                'DELETE FROM refresh_tokens
    WHERE (username, valid) IN (
        SELECT username, valid
        FROM refresh_tokens
        WHERE (username, valid) NOT IN (
            SELECT username, MAX(valid)
            FROM refresh_tokens
            GROUP BY usernames
        )
    )'
            )->executeQuery();
        } catch (Exception $e) {
            throw new \Exception('Error FcmToken remover', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}