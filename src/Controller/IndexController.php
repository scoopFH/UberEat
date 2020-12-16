<?php

namespace App\Controller;

use App\Entity\Restaurant;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Form\Register;
use App\Form\RestaurantCreation;
use App\Repository\UserRepository;
use App\Repository\RestaurantRepository;

class IndexController extends AbstractController
{
    /**
     * @Route("/register", name="register_user", methods={"GET","POST"})
     */
    public function registerUser(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(Register::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('register_user');
        }

        return $this->render('index/register.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/register/restorer/{restaurantId}", name="register_restorer", methods={"GET","POST"})
     */
    public function registerRestorer(Request $request, int $restaurantId, RestaurantRepository $restaurantrepo): Response
    {
        $user = new User();

        $restaurant = $restaurantrepo->find($restaurantId);

        $form = $this->createForm(Register::class, $user);

        if($restaurant->getUsers() == null) {
            $user->setRestaurant($restaurant);
        } else {
            return $this->redirectToRoute('register_user');
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('index/register.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/register/restorer/restaurant/create", name="restorer_create_restaurant", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $restaurant = new Restaurant();
        $form = $this->createForm(RestaurantCreation::class, $restaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($restaurant);
            $entityManager->flush();

            return $this->redirectToRoute('register_restorer', ['restaurantId' => $restaurant->getId()]);
        }

        return $this->render('restaurant/new.html.twig', [
            'restaurant' => $restaurant,
            'form' => $form->createView(),
        ]);
    }
}
