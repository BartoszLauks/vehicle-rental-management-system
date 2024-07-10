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

    private function sendPostRequest(string $uri, array $data, string $token): void
    {
        $this->client->request(
            'POST',
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

    public function testCreateBrandSuccess(): void
    {
        $this->sendPostRequest('/api/admin/brand', ['name' => 'Cat'], $this->adminToken);

        $this->assertResponseHasHeader('content-type');
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $this->assertJsonStringEqualsJsonString(
            json_encode(['message' => 'Brand was created']),
            $this->client->getResponse()->getContent()
        );
    }

    public function testCreateBrandUsageName(): void
    {
        $this->sendPostRequest('/api/admin/brand', ['name' => 'Cat'], $this->adminToken);

        $this->assertResponseHasHeader('content-type');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertJsonStringEqualsJsonString(
            json_encode(['message' => 'The brand with name Cat exist.']),
            $this->client->getResponse()->getContent()
        );
    }

    public function testCreateBrandByNotPrivilegeUser(): void
    {
        $this->sendPostRequest('/api/admin/brand', ['name' => 'Cat'], $this->userToken);

        $this->assertResponseHasHeader('content-type');
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
        $this->assertJsonStringEqualsJsonString(
            json_encode(['message' => 'Access Denied.']),
            $this->client->getResponse()->getContent()
        );
    }
}
