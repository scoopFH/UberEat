<?php

namespace App\Controller;

use App\Repository\OrderDishRepository;
use App\Repository\OrderRepository;
use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatController extends AbstractController
{
    /**
     * @Route("/admin/stat", name="stat")
     */
    public function index(RestaurantRepository $restaurantRepository,OrderRepository $orderRepository): Response
    {
        $nbreResaurant = $restaurantRepository->getTotal();
        $getOrderPassed = $orderRepository->getOrderPassed();
        $getOrderInProgress = $orderRepository->getOrderInProgress();




        return $this->render('stat/index.html.twig', [
            'nbreRestaurants' => $nbreResaurant,
            'orderPassed' => $getOrderPassed,
            'orderInProgress' => $getOrderInProgress,
        ]);
    }
}
