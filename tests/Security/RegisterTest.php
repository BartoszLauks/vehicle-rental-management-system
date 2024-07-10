<?php

declare(strict_types=1);

namespace App\Tests\Security;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class RegisterTest extends WebTestCase
{
    private KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
    }

    private function sendRegisterRequest(array $data): void
    {
        $this->client->request(
            'POST',
            '/api/register',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data)
        );
    }

    public function testRegisterSuccess(): void
    {
        $this->sendRegisterRequest(['email' => 'test@test.pl', 'password' => 'testtesttest1']);
        $this->assertResponseHasHeader('content-type');
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $this->assertJsonStringEqualsJsonString(
            json_encode(['message' => 'User was created.']),
            $this->client->getResponse()->getContent()
        );
    }

    public function testRegisterUsageEmail(): void
    {
        $this->sendRegisterRequest(['email' => 'test@test.pl', 'password' => 'testtest']);
        $this->assertResponseHasHeader('content-type');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'message' => "The email test@test.pl is already use.\nThe password must have 10 char. Is 8\nPassword must include at least one number!"
            ]),
            $this->client->getResponse()->getContent()
        );
    }

    public function testRegisterStrengthPassword(): void
    {
        $this->sendRegisterRequest(['email' => 'testt@test.pl', 'password' => 'testtest']);
        $this->assertResponseHasHeader('content-type');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'message' => "The password must have 10 char. Is 8\nPassword must include at least one number!"
            ]),
            $this->client->getResponse()->getContent()
        );

        $this->sendRegisterRequest(['email' => 'testt@test.pl', 'password' => 'testtesttest']);
        $this->assertResponseHasHeader('content-type');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertJsonStringEqualsJsonString(
            json_encode(['message' => 'Password must include at least one number!']),
            $this->client->getResponse()->getContent()
        );
    }

    public function testRegisterValidate(): void
    {
        $this->sendRegisterRequest(['email' => '', 'password' => '']);
        $this->assertResponseHasHeader('content-type');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'message' => "This value should not be blank.\nThis value should not be blank."
            ]),
            $this->client->getResponse()->getContent()
        );

        $this->sendRegisterRequest(['email' => 'testtest@test.pl', 'password' => '']);
        $this->assertResponseHasHeader('content-type');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertJsonStringEqualsJsonString(
            json_encode(['message' => 'This value should not be blank.']),
            $this->client->getResponse()->getContent()
        );
    }
}
