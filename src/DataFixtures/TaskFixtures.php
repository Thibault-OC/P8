<?php

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class TaskFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');


        for($nbTask = 1; $nbTask <= 10; $nbTask++){

            $user = $this->getReference('user_4');


            $Task = new Task();

            $Task->setUser($user);


            $Task->setTitle($faker->text($maxNbChars = 30) );
            $Task->setContent($faker->text);
            $Task->setCreatedAt($faker->dateTime($max = 'now', $timezone = null));



            $manager->persist($Task);


        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UsersFixtures::class
        ];
    }
}