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
use App\Form\SearchRestaurantType;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class IndexController extends AbstractController
{
    /**
     * @Route({"/orderBy/{orderBy}", "/"}, defaults={"orderBy"="none"}, name="home", methods={"GET", "POST"})
     */
    public function Home(RestaurantRepository $restaurantRepository, Request $request, string $orderBy): Response
    {
        $form = $this->createForm(SearchRestaurantType::class);
        $form->handleRequest($request);

        $restaurantsShowCarousel = 3;
        $orderByList = ["name","promotion"];

        if ($orderBy == "name") {
            $restaurants = $restaurantRepository->restaurantsOrderBy($orderBy);
        } elseif ($orderBy == "promotion") {
            $restaurants = $restaurantRepository->restaurantsOrderBy($orderBy, 'DESC');
        } else {
            $restaurants = $restaurantRepository->findAll();
        }

        $restaurantsWithPromotions = $restaurantRepository->findIfPromotion();

        $highlightedRestaurants = [];
        foreach (array_rand($restaurantsWithPromotions, $restaurantsShowCarousel) as &$restaurantKey) {
            $highlightedRestaurants[] = $restaurantsWithPromotions[$restaurantKey];
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $restaurantName = $form->getData()->getName();
            if ($orderBy == "promotion") {
                $restaurants = $restaurantRepository->search($restaurantName, $orderBy, 'DESC');
            }
            if ($orderBy == "name") {
                $restaurants = $restaurantRepository->search($restaurantName, $orderBy);
            }
        }

        return $this->render('index/home.html.twig', [
            'orderByList' => $orderByList,
            'orderBy' => $orderBy,
            'restaurants' => $restaurants,
            'highlightedRestaurants' => $highlightedRestaurants,
            'form' => $form->createView(),
        ]);
    }
}
