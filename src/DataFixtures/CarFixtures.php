<?php

namespace App\DataFixtures;

use App\Entity\Car;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CarFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 8; $i++) {
            $car = new Car();
            $car->setName('Audi A'.$i);
            $car->setColor('Noir');
            $car->setYear(new DateTime('2014-01-01'));
            $manager->persist($car);
        }

        $manager->flush();
    }
}
