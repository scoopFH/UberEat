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
     * @Route("/", name="home", methods={"GET"})
     */
    public function Home(RestaurantRepository $restaurantRepository): Response
    {
        $restaurantsShowCarousel = 3;

        $restaurants = $restaurantRepository->findall();

        foreach (array_rand($restaurants, $restaurantsShowCarousel) as &$restaurantKey) {
            $highlightedRestaurants[] = $restaurants[$restaurantKey];
        }

        return $this->render('index/home.html.twig', [
            'restaurants' => $restaurants,
            'highlightedRestaurants' => $highlightedRestaurants,
        ]);
    }
}
