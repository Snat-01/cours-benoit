<?php

namespace App\Controller;

use App\Entity\OpenHours;
use App\Entity\UserOpenHours;
use App\Form\CategoryUserType;
use App\Form\HoursOpenType;
use App\Form\UserType;
use App\Repository\CategoryRepository;
use App\Repository\OpenHoursRepository;
use App\Repository\UserOpenHoursRepository;
use App\Repository\UserRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        };

        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            //si le chmpas mot de passe a été remplis alors on modifie le mdp en BDD
            if($form->get('password')->getData() != ''){
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );
            }

            $userRepository->save($user, true);
            $this->addFlash('success', 'Vos informations ont été mise a jour');
        }

        return $this->render('user/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/user_presta', name: 'app_user_presta')]
    public function presta(Request $request, UserRepository $userRepository, CategoryRepository $categoryRepository): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(CategoryUserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $user->setRoles(['ROLE_PRESTA']);

            $userRepository->save($user, true);

            //on creer le save en mode inversé pour palier au probleme d'enregistrement
            //du manyToMany unidirectionnel
            foreach($user->getCategories() as $row){
                $category = $row->addUser($this->getUser());
                $categoryRepository->save($category, true);
            }

            $stringPresta = "";
            foreach($user->getCategories() as $row){
                if($stringPresta != ""){
                    $stringPresta .= ", ";
                }
                $stringPresta .= $row->getName();
            }

            $this->addFlash('success', 'Vous êtes désormais déclarer en tant que ' . $stringPresta);

            return $this->redirectToRoute('app_user');
        }

        return $this->render('user/presta.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/user_presta_hours', name: 'app_user_presta_hours')]
    public function prestahours(Request $request, UserRepository $userRepository): Response
    {
        return $this->render('user/prestahours.html.twig', [
        ]);
    }

    #[Route('/user_presta_savehours', name: 'app_user_presta_savehours')]
    public function prestasavehours(Request $request, OpenHoursRepository $openHoursRepository, UserOpenHoursRepository $userOpenHoursRepository): Response
    {
        if(isset(json_decode($request->getContent())->date)){
            $date = json_decode($request->getContent())->date;
        }

        $openHours = new OpenHours();

        $form = $this->createForm(HoursOpenType::class, $openHours);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $date = str_replace('date=', '', explode('&', $request->getContent())[0]); 

            $startHours = sprintf("%02d", $request->request->all()['hours_open']['start_hours']['hour']).':'.sprintf("%02d", $request->request->all()['hours_open']['start_hours']['minute']).':00';
            $dateStart = $date.' '.$startHours;

            $endHours = sprintf("%02d", $request->request->all()['hours_open']['end_hours']['hour']).':'.sprintf("%02d", $request->request->all()['hours_open']['end_hours']['minute']).':00';
            $dateEnd = $date.' '.$endHours;

            $openHours = new OpenHours();
            $openHours->setStartHours(new DateTime($dateStart));
            $openHours->setEndHours(new DateTime($dateEnd));

            $openHoursRepository->save($openHours, true);

            $userOpenHours = new UserOpenHours();
            $userOpenHours->setOpenHours($openHours);
            $userOpenHours->setUserId($this->getUser());
            $userOpenHours->setIsBooked(0);

            $userOpenHoursRepository->save($userOpenHours, true);

            return $this->redirectToRoute('app_user_presta_hours');

        }

        return $this->render('user/prestasavehours.html.twig', [
            'form' => $form,
            'dateShow' => $date
        ]);
    }
}
