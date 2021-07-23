<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsersFixtures extends Fixture
{

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {


        $users = [
            1=>[
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => 'password',
                'roles' => ['ROLE_ADMIN'],
            ],
            2=>[
                'username' => 'antoine',
                'email' => 'antoine@gmail.com',
                'password' => 'password',
                'roles' => [],
            ],
            3=>[
                'username' => 'didier',
                'email' => 'didier@gmail.com',
                'password' => 'password',
                'roles' => [],
            ],
            4=>[
                'username' => 'daniel',
                'email' => 'daniel@gmail.com',
                'password' => 'password',
                'roles' => [],
            ]

        ];



        foreach($users as $key=> $value){
            $user = new User();
            $user->setUsername($value['username']);
            $user->setEmail($value['email']);
            $user->setPassword($this->encoder->encodePassword($user, $value['password']));
            $user->setRoles($value['roles']);
            $manager->persist($user);

            $this->addReference('user_'. $key, $user);
        }


        $manager->flush();
    }
}
