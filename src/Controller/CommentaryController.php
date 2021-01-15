<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OrderRepository;
use App\Entity\Commentary;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CommentaryType;

class CommentaryController extends AbstractController
{
    /**
     * @Route("/order/{id}/comment", name="order_comment", methods={"GET","POST"})
     */
    public function commentOrders(OrderRepository $orderRepo, int $id, Request $request): Response
    {
        if ($this->getUser() != null && $orderRepo->find($id)->getUsers() == $this->getUser()) {
            if ($orderRepo->find($id)->getCommentary() == null) {
                $commentary = new Commentary();
                $commentary->setOrderDishes($orderRepo->find($id));
                $form = $this->createForm(CommentaryType::class, $commentary);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($commentary);
                    $entityManager->flush();

                    return $this->redirectToRoute('user_orders');
                }

                return $this->render('user/orders/commentary/form.html.twig', [
                    'form' => $form->createView(),
                ]);
            } else {
                $commentary = $orderRepo->find($id)->getCommentary();
                return $this->render('user/orders/commentary/form.html.twig', [
                    'commentary' => $commentary
                ]);
            }
        } else {
            return $this->redirectToRoute('home');
        }
    }
}
