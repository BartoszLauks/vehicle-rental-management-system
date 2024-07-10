<?php

declare(strict_types=1);

namespace App\Tests\Brand;

use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CreateTest extends WebTestCase
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

    public function testCreateBrandSuccess(): void
    {
        $user = $this->userRepository->findOneBy(['email' => 'admin@test.com']);
        $token = $this->JWTTokenManager->create($user);

        $this->client->request(
            method: 'POST',
            uri: '/api/admin/brand',
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
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $this->assertJsonStringEqualsJsonString(
            '{
                "message": "Brand was created"
            }',
            $this->client->getResponse()->getContent()
        );
    }

    public function testCreateBrandUsageName()
    {
        $user = $this->userRepository->findOneBy(['email' => 'admin@test.com']);
        $token = $this->JWTTokenManager->create($user);

        $this->client->request(
            method: 'POST',
            uri: '/api/admin/brand',
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
        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
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
            method: 'POST',
            uri: '/api/admin/brand',
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
                "message": "Access Denied."
            }',
            $this->client->getResponse()->getContent()
        );

    }
}