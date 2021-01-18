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
     * @Route("/admin/stat", name="admin_stat")
     */
    public function index(RestaurantRepository $restaurantRepository,OrderRepository $orderRepository,OrderDishRepository $orderDishRepository): Response
    {
        $nombreRestaurant = $restaurantRepository->getTotal();
        $getOrderPassed = $orderRepository->getOrderPassed();
        $getOrderInProgress = $orderRepository->getOrderInProgress();
        $getTotalIncome = $orderDishRepository->getTotalIncome();


        return $this->render('stat/index.html.twig', [
            'nombreRestaurants' => $nombreRestaurant,
            'orderPassed' => $getOrderPassed,
            'orderInProgress' => $getOrderInProgress,
            'totalIncome' => $getTotalIncome,
        ]);
    }
}
