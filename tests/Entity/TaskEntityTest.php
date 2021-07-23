<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class TaskEntityTest extends TestCase
{
    protected function setUp() :void
    {
        parent::setUp();

        $this->task = new Task();
    }

    public function testGetId() : void
    {
        static::assertEquals($this->task->getId(), null);
    }

    public function testSetGetCeatedAt() : void
    {
        $value ="2021-05-21 11:54:25";

        $response = $this->task->setCreatedAt($value);


        self::assertInstanceOf(Task::class, $response);
        self::assertEquals($value ,$this->task->getCreatedAt());

    }

    public function testSetGetTitle() : void
    {
        $value ="title";

        $response = $this->task->setTitle($value);


        self::assertInstanceOf(Task::class, $response);
        self::assertEquals($value ,$this->task->getTitle());

    }

    public function testSetGetContent() : void
    {
        $value ="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat";

        $response = $this->task->setContent($value);


        self::assertInstanceOf(Task::class, $response);
        self::assertEquals($value ,$this->task->getContent());

    }

    public function testIsDone() : void
    {
        $value =1;

        $response = $this->task->toggle($value);


        self::assertInstanceOf(Task::class, $response);
        self::assertEquals($value ,$this->task->isDone());

    }


    public function testSetGetUser() : void
    {

        $value = new User();

        $response = $this->task->setUser($value);

        self::assertInstanceOf(Task::class, $response);
        self::assertEquals($value , $this->task->getUser());

    }


}
