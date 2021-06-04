<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserEntityTest extends TestCase
{

    protected function setUp() :void
    {
        parent::setUp();

        $this->user = new User();
    }

    public function testGetId() : void
    {
        static::assertEquals($this->user->getId(), null);
    }

    public function testSetGetUsername() : void
    {
        $value = "test";

        $response = $this->user->setUsername($value);

        self::assertInstanceOf(User::class, $response);
        self::assertEquals($value , $this->user->getUsername());
    }

    public function testSetGetEmail() : void
    {
        $value = "test@test.com";

        $response = $this->user->setEmail($value);

        self::assertInstanceOf(User::class, $response);
        self::assertEquals($value ,$this->user->getEmail());

    }

    public function testSetGetPassword() : void
    {
        $value = "password";

        $response = $this->user->setPassword($value);

        self::assertInstanceOf(User::class, $response);
        self::assertEquals($value ,$this->user->getPassword());

    }

    public function testSetGetRoles() : void
    {

        $value = ['ROLE_ADMIN'];

        $response = $this->user->setRoles($value);

        self::assertInstanceOf(User::class, $response);

        self::assertContains('ROLE_USER' ,$this->user->getRoles());
        self::assertContains('ROLE_ADMIN' ,$this->user->getRoles());


    }


    public function testSetGetTask() : void
    {

        $value = new Task();

        $response = $this->user->addTask($value);

        self::assertInstanceOf(User::class, $response);

        self::assertCount(1 ,$this->user->getTasks());
        self::assertTrue($this->user->getTasks()->contains($value));

        $response = $this->user->removeTask($value);

        self::assertInstanceOf(User::class, $response);

        self::assertCount(0 ,$this->user->getTasks());
        self::assertFalse($this->user->getTasks()->contains($value));



    }


}
