<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use App\Form\OrderRestorer;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     * @Route("/admin/order", name="order_index", methods={"GET"})
     */
    public function index(OrderRepository $orderRepository): Response
    {
        return $this->render('admin/order/index.html.twig', [
            'orders' => $orderRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/order/new", name="order_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($order);
            $entityManager->flush();

            return $this->redirectToRoute('order_index');
        }

        return $this->render('admin/order/new.html.twig', [
            'order' => $order,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/show/{id}", name="order_show", methods={"GET"})
     */
    public function show(Order $order): Response
    {
        return $this->render('admin/order/show.html.twig', [
            'order' => $order,
        ]);
    }

    /**
     * @Route("/admin/{id}/edit", name="order_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Order $order): Response
    {
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('order_index');
        }

        return $this->render('admin/order/edit.html.twig', [
            'order' => $order,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/{id}", name="order_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Order $order): Response
    {
        if ($this->isCsrfTokenValid('delete' . $order->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($order);
            $entityManager->flush();
        }

        return $this->redirectToRoute('order_index');
    }

    /**
     * @Route("/restorer/order", name="restorer_order_index", methods={"GET"})
     */
    public function showRestorerOrders(): Response
    {
        $orders = $this->getUser()->getRestaurant()->getOrders();
        return $this->render('restorer/order/index.html.twig', [
            'orders' => $orders,
        ]);
    }

    /**
     * @Route("/restorer/order/{id}/edit", name="restorer_order_edit", methods={"GET","POST"})
     */
    public function editRestorerDish(Request $request, Order $order): Response
    {
        $userOwnOrder = false;
        $orders = $this->getUser()->getRestaurant()->getOrders();

        foreach ($orders as &$myOrder) {
            if ($myOrder->getId() == $order->getId()) {
                $userOwnOrder = true;
            }
        }

        if ($userOwnOrder) {
            $form = $this->createForm(OrderRestorer::class, $order);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('restorer_order_index');
            }

            return $this->render('restorer/order/edit.html.twig', [
                'order' => $order,
                'form' => $form->createView(),
            ]);
        }

        return $this->redirectToRoute('restorer_order_index');
    }
}
