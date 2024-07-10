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

    public function testLoginSuccess(): void
    {
        $this->client->request(
            method: 'POST',
            uri: '/api/login_check',
            server: ['CONTENT_TYPE' => 'application/json'],
            content:
            '{
                "username": "admin@test.com",
                "password": "zaq1@WSXasdw"
            }'
        );
        $this->assertResponseHasHeader('content-type');
        $this->assertResponseIsSuccessful();
    }

    public function testLoginFailure(): void
    {
        $this->client->request(
            method: 'POST',
            uri: '/api/login_check',
            server: ['CONTENT_TYPE' => 'application/json'],
            content:
            '{
                "username": "admin@test.com",
                "password": "zaq1@WSX"
            }'
        );
        $this->assertResponseHasHeader('content-type');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
        $this->assertJsonStringEqualsJsonString(
            '{
                "code": 401,
                "message": "Invalid credentials."
            }',
            $this->client->getResponse()->getContent()
        );
    }
}
