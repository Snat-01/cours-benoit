<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    //declaration d'une varibale privée pour pouvoir l'utiliser dans toute la classe
    private $userPasswordHasherInterface;

    public function __construct (UserPasswordHasherInterface $userPasswordHasherInterface) 
    {
        //attribution de la classe a la variable privée
        $this->userPasswordHasherInterface = $userPasswordHasherInterface;
    }

    public function load(ObjectManager $manager): void
    {
        //creation de l'objet que l'on va persisté en BDD
        $user = new User();
        $user->setEmail('benoitbrice@gmail.com');
        $user->setPassword(
            $this->userPasswordHasherInterface->hashPassword(
                $user,
                '123456'
            )
        );
        $manager->persist($user);

        $manager->flush();
    }
}
