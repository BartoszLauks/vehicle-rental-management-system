<?php

declare(strict_types=1);

namespace App\Tests\Brand;

use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class PutTest extends WebTestCase
{
    private UserRepository $userRepository;
    private JWTTokenManagerInterface $JWTTokenManager;
    private KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
        $this->userRepository = static::getContainer()->get(UserRepository::class);
        $this->JWTTokenManager = static::getContainer()->get('lexik_jwt_authentication.jwt_manager');
    }

    public function testPutBrandSuccess(): void
    {
        $user = $this->userRepository->findOneBy(['email' => 'admin@test.com']);
        $token = $this->JWTTokenManager->create($user);

        $this->client->request(
            method: 'PUT',
            uri: '/api/admin/brand/1',
            server:
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_AUTHORIZATION' => sprintf('Bearer %s', $token),
            ],
            content:
            '{
                "name": "Cat TEST"
            }'
        );
        $this->assertResponseHasHeader('content-type');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertJsonStringEqualsJsonString(
            '{
                "name": "Cat TEST"
                }',
            $this->client->getResponse()->getContent()
        );
    }

    public function techPutBrandNotFound(): void
    {
        $user = $this->userRepository->findOneBy(['email' => 'admin@test.com']);
        $token = $this->JWTTokenManager->create($user);

        $this->client->request(
            method: 'PUT',
            uri: '/api/admin/brand/100',
            server:
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_AUTHORIZATION' => sprintf('Bearer %s', $token)
            ],
            content:
            '{
                "name": "Cat TEST"
            }'
        );

        $this->assertResponseHasHeader('content-type');
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
        $this->assertJsonStringEqualsJsonString(
            '{
                "message": "Not found"
            }',
            $this->client->getResponse()->getContent()
        );
    }

    public function techPutBrandFailure(): void
    {
        $user = $this->userRepository->findOneBy(['email' => 'admin@test.com']);
        $token = $this->JWTTokenManager->create($user);

        $this->client->request(
            method: 'PUT',
            uri: '/api/admin/brand/1',
            server:
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_AUTHORIZATION' => sprintf('Bearer %s', $token),
            ],
            content:
            '{
                "name": ""
            }'
        );

        $this->assertResponseHasHeader('content-type');
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
        $this->assertJsonStringEqualsJsonString(
            '{
                "message": "This value should not be blank."
                }',
            $this->client->getResponse()->getContent()
        );

        $this->client->request(
            method: 'PUT',
            uri: '/api/admin/brand/1',
            server:
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_AUTHORIZATION' => sprintf('Bearer %s', $token),
            ],
            content:
            '{
                "name": "Cat"
            }'
        );

        $this->assertResponseHasHeader('content-type');
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
        $this->assertJsonStringEqualsJsonString(
            '{
                "message": "The brand with name Cat exist."
                }',
            $this->client->getResponse()->getContent()
        );
    }

    public function testCreateBrandByNotPrivilegeUser(): void
    {
        $user = $this->userRepository->findOneBy(['email' => 'user1@test.com']);
        $token = $this->JWTTokenManager->create($user);

        $this->client->request(
            method: 'PUT',
            uri: '/api/admin/brand/1',
            server:
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_AUTHORIZATION' => sprintf('Bearer %s', $token),
            ],
            content:
            '{
                "name": "Cat TEST"
            }'
        );

        $this->assertResponseHasHeader('content-type');
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
        $this->assertJsonStringEqualsJsonString(
            '{
                "message": "Access Denied."
                }',
            $this->client->getResponse()->getContent()
        );
    }
}