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

    public function testRegisterSuccess(): void
    {
        $this->client->request(
            method: 'POST',
            uri: '/api/register',
            server: ['CONTENT_TYPE' => 'application/json'],
            content:
            '{
                "email": "test@test.pl",
                "password": "testtesttest1"
            }'
        );
        $this->assertResponseHasHeader('content-type');
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED,);
        $this->assertJsonStringEqualsJsonString(
            '{
                "message": "User was created."
            }',
            $this->client->getResponse()->getContent()
        );
    }

    public function testRegisterUsageEmail(): void
    {
        $this->client->request(
            method: 'POST',
            uri: '/api/register',
            server: ['CONTENT_TYPE' => 'application/json'],
            content:
            '{
                "email": "test@test.pl",
                "password": "testtest"
            }'
        );
        $this->assertResponseHasHeader('content-type');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertJsonStringEqualsJsonString(
            '{
                "message": "The email test@test.pl is already use.\nThe password must have 10 char. Is 8\nPassword must include at least one number!"
            }',
            $this->client->getResponse()->getContent()
        );
    }

    public function testRegisterStrengthPassword(): void
    {
        $this->client->request(
            method: 'POST',
            uri: '/api/register',
            server: ['CONTENT_TYPE' => 'application/json'],
            content:
            '{
                "email": "testt@test.pl",
                "password": "testtest"
            }'
        );
        $this->assertResponseHasHeader('content-type');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertJsonStringEqualsJsonString(
            '{
                "message": "The password must have 10 char. Is 8\nPassword must include at least one number!"
            }',
            $this->client->getResponse()->getContent()
        );

        $this->client->request(
            method: 'POST',
            uri: '/api/register',
            server: ['CONTENT_TYPE' => 'application/json'],
            content:
            '{
                "email": "testt@test.pl",
                "password": "testtesttest"
            }'
        );
        $this->assertResponseHasHeader('content-type');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertJsonStringEqualsJsonString(
            '{
                "message": "Password must include at least one number!"
            }',
            $this->client->getResponse()->getContent()
        );
    }

    public function testRegisterValidate(): void
    {
        $this->client->request(
            method: 'POST',
            uri: '/api/register',
            server: ['CONTENT_TYPE' => 'application/json'],
            content:
            '{
                "email": "",
                "password": ""
            }'
        );
        $this->assertResponseHasHeader('content-type');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY,);
        $this->assertJsonStringEqualsJsonString(
            '{
                "message": "This value should not be blank.\nThis value should not be blank."
            }',
            $this->client->getResponse()->getContent()
        );

        $this->client->request(
            method: 'POST',
            uri: '/api/register',
            server: ['CONTENT_TYPE' => 'application/json'],
            content:
            '{
                "email": "testtest@test.pl",
                "password": ""
            }'
        );
        $this->assertResponseHasHeader('content-type');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertJsonStringEqualsJsonString(
            '{
                "message": "This value should not be blank."
            }',
            $this->client->getResponse()->getContent()
        );
    }
}
