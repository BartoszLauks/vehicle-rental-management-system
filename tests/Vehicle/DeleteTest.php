<?php

declare(strict_types=1);

namespace App\Tests\Vehicle;

use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class DeleteTest extends WebTestCase
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

    public function sendDeleteRequest(string $uri, string $token): void
    {
        $this->client->request(
            'DELETE',
            $uri,
            server:
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_AUTHORIZATION' => sprintf('Bearer %s', $token)
            ]
        );
    }

    public function testDeleteVehicleSuccess(): void
    {
        $this->sendDeleteRequest('/api/admin/vehicle/2',
            $this->adminToken
        );
        $this->assertResponseHasHeader('content-type');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertJsonStringEqualsJsonString(json_encode([
            "message" => "Vehicle was deleted"
            ]),
            $this->client->getResponse()->getContent()
        );
    }

    public function testDeleteVehicleByNotPrivilegeUser(): void
    {
        $this->sendDeleteRequest('/api/admin/vehicle/3',
            $this->userToken
        );
        $this->assertResponseHasHeader('content-type');
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
        $this->assertJsonStringEqualsJsonString(json_encode([
            "message" => "Access Denied."
        ]),
            $this->client->getResponse()->getContent()
        );
    }
}