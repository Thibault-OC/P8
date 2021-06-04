<?php

namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class TaskControllerTest extends WebTestCase{

  public function testListAction()
    {
        $client = static::createClient();

        $client->request('GET', '/tasks');

        static::assertSame(200, $client->getResponse()->getStatusCode());


    }


}