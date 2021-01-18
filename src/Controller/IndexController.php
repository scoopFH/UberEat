<?php

namespace App\Controller;

use App\Entity\Restaurant;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Form\Register;
use App\Repository\UserRepository;
use App\Repository\RestaurantRepository;
use App\Form\SearchRestaurantType;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class IndexController extends AbstractController
{
    /**
     * @Route({"/"}, name="home", methods={"GET", "POST"})
     */
    public function Home(RestaurantRepository $restaurantRepository, Request $request): Response
    {
        $form = $this->createForm(SearchRestaurantType::class);
        $form->handleRequest($request);

        if($request->query->get('orderBy')) {
            $orderBy = $request->query->get('orderBy');
        } else {
            $orderBy = "none";
        }

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
            } else {
                $restaurants = $restaurantRepository->search($restaurantName, 'id');
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


    /**
     * @Route("/restaurant/description/{id}",name="restaurant_description", methods={"GET"})
     */
    public function RestaurantDescription(Restaurant $restaurant) : Response
    {
        return $this->render('index/details.html.twig',[
            'restaurants' => $restaurant
        ]);
    }

}
