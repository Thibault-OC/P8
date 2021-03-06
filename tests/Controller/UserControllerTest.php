<?php

namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class UserControllerTest extends WebTestCase
{

    public function testHome()
    {
        $client = static::createClient();

        $client->request('GET', '/');

        static::assertSame(200, $client->getResponse()->getStatusCode());

    }

    public function testListAction()
    {
        $securityControllerTest = new SecurityControllerTest();
        $securityControllerTest->setUp();
        $client = $securityControllerTest->testLogin();

        $crawler = $client->request('GET', '/users/liste');
        static::assertSame(200, $client->getResponse()->getStatusCode());
        static::assertSame("Liste des utilisateurs", $crawler->filter('h1')->text());
    }

    public function testListActionNotConnect()
    {
        $client = static::createClient();

        $client->request('GET', '/users/liste');

        static::assertSame(302, $client->getResponse()->getStatusCode());

        $crawler = $client->followRedirect();
        static::assertSame(200, $client->getResponse()->getStatusCode());

        $this->assertEquals(1, $crawler->filter('div.alert-danger')->count());


    }


    public function testCreateAction()
    {
        $securityControllerTest = new SecurityControllerTest();
        $securityControllerTest->setUp();
        $client = $securityControllerTest->testLogin();

        $crawler = $client->request('GET', '/users/create');
        static::assertSame(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Ajouter')->form();
        $client->submit($form, ['user[username]' => 'test500', 'user[password][first]' => 'test' , 'user[password][second]' => 'test' ,'user[email]' => 'email@email.test2' ,'user[Roles]' => 'ROLE_ADMIN' ]);

        static::assertSame(302, $client->getResponse()->getStatusCode());

        $crawler = $client->followRedirect();
        static::assertSame(200, $client->getResponse()->getStatusCode());
    }


    public function testEditAction()
    {
        $securityControllerTest = new SecurityControllerTest();
        $securityControllerTest->setUp();
        $client = $securityControllerTest->testLogin();

        $crawler = $client->request('GET', '/users/174/edit');
        static::assertSame(200, $client->getResponse()->getStatusCode());


        $form = $crawler->selectButton('Modifier')->form();
        $client->submit($form, ['user[username]' => 'test200', 'user[password][first]' => 'test' , 'user[password][second]' => 'test' ,'user[email]' => 'email@email.test' ,'user[Roles]' => 'ROLE_ADMIN'  ]);

        static::assertSame(302, $client->getResponse()->getStatusCode());

        $crawler = $client->followRedirect();
        static::assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }



}