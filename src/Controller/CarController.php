<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarType;
use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends AbstractController
{
    #[Route('/car', name: 'app_car')]
    public function index(Request $request, CarRepository $carRepository): Response
    {
        //pour emepecher l'acces si non connecter
        if(!$this->getUser()){
            return $this->redirectToRoute('app_home');
        };

        //pour l'affichage du formulaire
        $car = new Car();
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $carRepository->save($car, true);
           
        }

        return $this->render('car/index.html.twig', [
            'controller_name' => 'CarController',
            'form' => $form
        ]);
    }
}
