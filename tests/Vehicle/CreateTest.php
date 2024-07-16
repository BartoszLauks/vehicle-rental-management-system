<?php

declare(strict_types=1);

namespace App\Tests\Vehicle;

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

    public function testPostVehicleSuccess(): void
    {
        $this->sendPostRequest('/api/admin/vehicle',
            [
                'name' => 'Cat I',
                'registrationNumber' => 'EPI 12345',
                'mileage' => 10000,
                'brand_name' => 'Cat'
            ],
            $this->adminToken
        );

        $this->assertResponseHasHeader('content-type');
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $this->assertJsonStringEqualsJsonString(
            json_encode(['message' => 'Vehicle create.']),
            $this->client->getResponse()->getContent()
        );
    }

    public function testPostVehicleFailure(): void
    {
        $this->sendPostRequest('/api/admin/vehicle',
            [
                "name" => "",
                "registrationNumber" => "",
                "mileage" => -1,
                "brand_name" => ""
            ],
            $this->adminToken
        );

        $this->assertResponseHasHeader('content-type');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertJsonStringEqualsJsonString(
            json_encode([
                "name" => [
                    "This value should not be blank."],
                "registrationNumber" => [
                    "This value should not be blank."],
                "mileage" => [
                    "This value should be either positive or zero."],
                "brand_name" => [
                    "This value should not be blank."]
                ]
            ),
            $this->client->getResponse()->getContent()
        );

        $this->sendPostRequest('/api/admin/vehicle',
            [
                "name" => "Cat TesT",
                "registrationNumber" => "abc 12345",
                "mileage" => 0,
                "brand_name" => "Cat not exist"
            ],
            $this->adminToken
        );

        $this->assertResponseHasHeader('content-type');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertJsonStringEqualsJsonString(
            json_encode([
                "brand_name" => [
                    "The brand with name Cat not exist exist."]
                ]
            ),
            $this->client->getResponse()->getContent()
        );
    }

    public function testPostVehicleByNotPrivilegeUser(): void
    {
        $this->sendPostRequest('/api/admin/vehicle',
            [
                'name' => 'Cat II',
                'registrationNumber' => 'EPI 12345',
                'mileage' => 10000,
                'brand_name' => 'Cat'
            ],
            $this->userToken
        );

        $this->assertResponseHasHeader('content-type');
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
        $this->assertJsonStringEqualsJsonString(
            json_encode(['message' => 'Access Denied.']),
            $this->client->getResponse()->getContent()
        );
    }
}