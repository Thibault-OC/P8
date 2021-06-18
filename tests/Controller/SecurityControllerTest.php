<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function loginUser(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $this->client->submit($form, ['_username' => 'admin', '_password' => 'password']);

    }

    public function testLogin()
    {
        $this->loginUser();
        $this->client->request('GET', '/');
        static::assertEquals(200, $this->client->getResponse()->getStatusCode());

        return $this->client;
    }

    public function testLogout()
    {
        $this->loginUser();
        $crawler = $this->client->request('GET', '/');
        $crawler->selectLink('Se déconnecter')->link();
        $this->throwException(new \Exception('Logout'));

        self::assertEquals(200, $this->client->getResponse()->getStatusCode());

    }

}
