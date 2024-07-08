<?php

namespace App\Tests\Security;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginTest extends WebTestCase
{
    public function testLoginSuccess(): void
    {
        $client = static::createClient();
        $client->request(
            method: 'POST',
            uri: '/api/login_check',
            server: ['CONTENT_TYPE' => 'application/json'],
            content:
            '{
                "username": "admin@test.com",
                "password": "zaq1@WSXasdw"
            }'
        );

        $this->assertResponseIsSuccessful();
//        $this->assertSelectorTextContains('h1', 'Hello World');
    }
}
