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

    public function testListTaskFinished()
    {
        $client = static::createClient();

        $client->request('GET', '/tasks/finished');

        static::assertSame(200, $client->getResponse()->getStatusCode());


    }

    public function testListTaskNotDone()
    {
        $client = static::createClient();

        $client->request('GET', '/tasks/notdone');

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
        $client->submit($form, ['task[title]' => 'test title', 'task[content]' => 'test content']);

        static::assertSame(302, $client->getResponse()->getStatusCode());

        $crawler = $client->followRedirect();
        static::assertSame(200, $client->getResponse()->getStatusCode());
    }

    public function testCreateTaskNotConnect()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/tasks/create');
        static::assertSame(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Ajouter')->form();
        $client->submit($form, ['task[title]' => 'test title', 'task[content]' => 'test content']);

        static::assertSame(302, $client->getResponse()->getStatusCode());

        $crawler = $client->followRedirect();
        static::assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-danger')->count());
    }

    public function testEditTask()
    {
        $securityControllerTest = new SecurityControllerTest();
        $securityControllerTest->setUp();
        $client = $securityControllerTest->testLogin();

        $crawler = $client->request('GET', '/tasks/415/edit');
        static::assertSame(200, $client->getResponse()->getStatusCode());


        $form = $crawler->selectButton('Modifier')->form();
        $client->submit($form, ['task[title]' => 'test title', 'task[content]' => 'test content' ]);

        static::assertSame(302, $client->getResponse()->getStatusCode());

        $crawler = $client->followRedirect();
        static::assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
    }

    public function testEditTaskNotConnect()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/tasks/415/edit');
        static::assertSame(200, $client->getResponse()->getStatusCode());


        $form = $crawler->selectButton('Modifier')->form();
        $client->submit($form, ['task[title]' => 'test title', 'task[content]' => 'test content' ]);

        static::assertSame(302, $client->getResponse()->getStatusCode());

        $crawler = $client->followRedirect();
        static::assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-danger')->count());
    }


    public function testDeleteTaskNotConnect()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/tasks/453/delete');
        static::assertSame(302, $client->getResponse()->getStatusCode());

        $crawler = $client->followRedirect();
        static::assertSame(200, $client->getResponse()->getStatusCode());

        $this->assertEquals(1, $crawler->filter('div.alert-danger')->count());

    }

    public function testDeleteTask()
    {
        $securityControllerTest = new SecurityControllerTest();
        $securityControllerTest->setUp();
        $client = $securityControllerTest->testLogin();

        $crawler = $client->request('GET', '/tasks/453/delete');
        static::assertSame(302, $client->getResponse()->getStatusCode());

        $crawler = $client->followRedirect();
        static::assertSame(200, $client->getResponse()->getStatusCode());

        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());

    }

    public function testtoggleTaskNotConnect()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/tasks/435/toggle');
        static::assertSame(302, $client->getResponse()->getStatusCode());

        $crawler = $client->followRedirect();
        static::assertSame(200, $client->getResponse()->getStatusCode());

        $this->assertEquals(1, $crawler->filter('div.alert-danger')->count());

    }


    public function testtoggleTask()
    {
        $securityControllerTest = new SecurityControllerTest();
        $securityControllerTest->setUp();
        $client = $securityControllerTest->testLogin();

        $crawler = $client->request('GET', '/tasks/435/toggle');
        static::assertSame(302, $client->getResponse()->getStatusCode());

        $crawler = $client->followRedirect();
        static::assertSame(200, $client->getResponse()->getStatusCode());

        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());

    }


}