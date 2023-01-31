<?php

namespace App\Tests;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class NavigationTest extends WebTestCase
{
    public function testSomething(): void
    {
        //creation de l'objet qui va naviguer dans le site
        $client = static::createClient();
        //on se dirige vers la page d'accueil
        $crawler = $client->request('GET', '/');
        //on test si la page est en 200
        $this->assertResponseIsSuccessful();

        //on compte le nombre d'element sur la page
        $this->assertCount(3, $crawler->filter('.card'));

        //on se dirige vers la page register
        $crawler = $client->request('GET', '/register');
        //on test si la page est en 200
        $this->assertResponseIsSuccessful();

        //on charge la classe pour allez chercher un user en BDD DE TEST
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('benoitbrice@gmail.com');

        //on se connecte
        $client->loginUser($testUser);
        //on verifie si on a acces a la page car qui n'est autoriser que pour une personne connecté
        $client->request('GET', '/car');
        //on test si la page est en 200
        $this->assertResponseIsSuccessful();
    }
}
