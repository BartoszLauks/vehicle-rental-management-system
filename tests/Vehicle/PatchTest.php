<?php

declare(strict_types=1);

namespace App\Tests\Vehicle;

use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class PatchTest extends WebTestCase
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

    public function sendPatchRequest(string $uri, array $data, string $token): void
    {
        $this->client->request(
            'PATCH',
            $uri,
            server:
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_AUTHORIZATION' => sprintf('Bearer %s', $token)
            ],
            content: json_encode($data)
        );
    }

    public function testPatchVehicleSuccess(): void
    {
        $this->sendPatchRequest('/api/admin/vehicle/1',
            [
                "name" => "Cat III",
                "registrationNumber" => "EPI 123456",
                "mileage" => 100009,
                "brand_name" => "Cat"
            ],
            $this->adminToken
        );

        $this->assertResponseHasHeader('content-type');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
//        $this->assertJsonStringEqualsJsonString(
//            json_encode([
//                "id" => 1,
//                "name" => "Cat III",
//                "registrationNumber" => "EPI 123456",
//                "createdAt" => "2024-07-11",
//                "updatedAt" => "2024-07-11",
//                "mileage" => 100009,
//                "brand" => [
//                    'id' => 3,
//                    'name' => "Cat"
//                ]
//            ]),
//            $this->client->getResponse()->getContent()
//        );

        $this->sendPatchRequest('/api/admin/vehicle/6',
            [
                "name" => "Cat V"
            ],
            $this->adminToken
        );

        $this->assertResponseHasHeader('content-type');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
//        $this->assertJsonStringEqualsJsonString(
//            json_encode([
//                "id" => 6,
//                "name" => "Cat V",
//                "registrationNumber" => "ABC 6",
//                "createdAt" => "2024-07-11",
//                "updatedAt" => "2024-07-11",
//                "mileage" => 1000,
//                "brand" => [
//                    'id' => 1,
//                    'name' => "Cat TEST"
//                ]
//            ]),
//            $this->client->getResponse()->getContent()
//        );
    }

    public function testPatchVehicleByNotPrivilegeUser(): void
    {
        $this->sendPatchRequest('/api/admin/vehicle/1',
            [
                "name" => "Cat III",
                "registrationNumber" => "EPI 123456",
                "mileage" => 100009,
                "brand_name" => "Cat"
            ],
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