<?php

namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class TaskControllerTest extends WebTestCase{

  public function testListTask()
    {
        $client = static::createClient();

        $client->request('GET', '/tasks');

        static::assertSame(200, $client->getResponse()->getStatusCode());


    }

    public function testCreateTask()
    {
        $securityControllerTest = new SecurityControllerTest();
        $securityControllerTest->setUp();
        $client = $securityControllerTest->testLogin();

        $crawler = $client->request('GET', '/tasks/create');
        static::assertSame(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Ajouter')->form();
        $client->submit($form, ['task[title]' => 'test title', 'task[content]' => 'test content' ]);

        static::assertSame(302, $client->getResponse()->getStatusCode());

        $crawler = $client->followRedirect();
        static::assertSame(200, $client->getResponse()->getStatusCode());
    }


}