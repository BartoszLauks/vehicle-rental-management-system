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
    private string $adminToken;
    private string $userToken;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
        $container = static::getContainer();
        $this->userRepository = $container->get(UserRepository::class);
        $this->JWTTokenManager = $container->get(JWTTokenManagerInterface::class);

        $admin = $this->userRepository->findOneBy(['email' => 'admin@test.com']);
        $this->adminToken = $this->JWTTokenManager->create($admin);

        $user = $this->userRepository->findOneBy(['email' => 'user1@test.com']);
        $this->userToken = $this->JWTTokenManager->create($user);
    }

    private function sendPutRequest(string $uri, array $data, string $token): void
    {
        $this->client->request(
            'PUT',
            $uri,
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_AUTHORIZATION' => sprintf('Bearer %s', $token),
            ],
            json_encode($data)
        );
    }

    public function testPutBrandSuccess(): void
    {
        $this->sendPutRequest('/api/admin/brand/1', ['name' => 'Cat TEST'], $this->adminToken);

        $this->assertResponseHasHeader('content-type');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertJsonStringEqualsJsonString(
            json_encode(['name' => 'Cat TEST']),
            $this->client->getResponse()->getContent()
        );
    }

    public function testPutBrandNotFound(): void
    {
        $this->sendPutRequest('/api/admin/brand/100', ['name' => 'Cat TEST'], $this->adminToken);

        $this->assertResponseHasHeader('content-type');
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
        $this->assertJsonStringEqualsJsonString(
            json_encode(['message' => 'Not found']),
            $this->client->getResponse()->getContent()
        );
    }

    public function testPutBrandFailure(): void
    {
        $this->sendPutRequest('/api/admin/brand/1', ['name' => ''], $this->adminToken);

        $this->assertResponseHasHeader('content-type');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertJsonStringEqualsJsonString(
            json_encode(['message' => 'This value should not be blank.']),
            $this->client->getResponse()->getContent()
        );

        $this->sendPutRequest('/api/admin/brand/1', ['name' => 'Cat'], $this->adminToken);

        $this->assertResponseHasHeader('content-type');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertJsonStringEqualsJsonString(
            json_encode(['message' => 'The brand with name Cat exist.']),
            $this->client->getResponse()->getContent()
        );
    }

    public function testCreateBrandByNotPrivilegeUser(): void
    {
        $this->sendPutRequest('/api/admin/brand/1', ['name' => 'Cat TEST'], $this->userToken);

        $this->assertResponseHasHeader('content-type');
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
        $this->assertJsonStringEqualsJsonString(
            json_encode(['message' => 'Access Denied.']),
            $this->client->getResponse()->getContent()
        );
    }
}
