<?php

namespace App\Tests;

use App\Repository\UserRepository;
use App\Repository\CarRepository;
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

        $link = $crawler->selectLink('Authentification')->link();
        $client->click($link);
        //on arrive sur la page /login

        //on test si le text existe afin de savoir qu'on est bien sur la page de login
        $this->assertSelectorTextContains('h1', 'Please sign in');

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
        $crawler = $client->request('GET', '/car');
        //on test si la page est en 200
        $this->assertResponseIsSuccessful();

        // Selection du bouton
        $buttonCrawlerNode = $crawler->selectButton('Valider');

        // retrieve the Form object for the form belonging to this button
        $form = $buttonCrawlerNode->form();
        
        // set values on a form object
        $form['car[name]'] = 'Porsche 911';
        $form['car[color]'] = 'Blanche';

        // submit the Form object
        $client->submit($form);

        //verification de la presence de la voiture en BDD
        $carRepository = static::getContainer()->get(CarRepository::class);
        $car = $carRepository->findOneByName('Porsche 911');

        //verification de la donnée dans le BDD par rapport a ce qu'on a inserer
        $this->assertSame('Porsche 911', $car->getName());


    }
}
