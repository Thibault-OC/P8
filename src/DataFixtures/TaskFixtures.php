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

        $nbTaskForUsers = 1;

        for($nbTask = 1; $nbTask <= 20; $nbTask++){

            $Task = new Task();

            if($nbTaskForUsers <= 15) {

                $user = $this->getReference('user_'.$faker->numberBetween(1, 4));

                $Task->setUser($user);

            }
            $nbTaskForUsers++;

            $Task->setTitle($faker->text($maxNbChars = 30) );
            $Task->setContent($faker->text($maxNbChars = 600));
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