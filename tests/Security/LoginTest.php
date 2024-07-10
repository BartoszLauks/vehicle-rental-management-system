<?php

namespace App\Tests\Security;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class LoginTest extends WebTestCase
{
    private KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
    }

    private function sendLoginRequest(string $username, string $password): void
    {
        $this->client->request(
            'POST',
            '/api/login_check',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['username' => $username, 'password' => $password])
        );
    }

    public function testLoginSuccess(): void
    {
        $this->sendLoginRequest('admin@test.com', 'zaq1@WSXasdw');
        $this->assertResponseHasHeader('content-type');
        $this->assertResponseIsSuccessful();
    }

    public function testLoginFailure(): void
    {
        $this->sendLoginRequest('admin@test.com', 'zaq1@WSX');
        $this->assertResponseHasHeader('content-type');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
        $this->assertJsonStringEqualsJsonString(
            json_encode(['code' => 401, 'message' => 'Invalid credentials.']),
            $this->client->getResponse()->getContent()
        );
    }
}
