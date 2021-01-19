<?php

namespace App\Controller;

use App\Entity\Dish;
use App\Form\DishType;
use App\Repository\DishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DishController extends AbstractController
{
    /**
     * @Route("/admin/dish", name="dish_index", methods={"GET"})
     */
    public function index(DishRepository $dishRepository): Response
    {
        return $this->render('admin/dish/index.html.twig', [
            'dishes' => $dishRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/dish/new", name="dish_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $dish = new Dish();
        $form = $this->createForm(DishType::class, $dish);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($dish);
            $entityManager->flush();

            $this->addFlash('success', 'Your dish has been created');
            return $this->redirectToRoute('dish_index');
        }

        return $this->render('admin/dish/new.html.twig', [
            'dish' => $dish,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/dish/{id}", name="dish_show", methods={"GET"})
     */
    public function show(Dish $dish): Response
    {
        return $this->render('admin/dish/show.html.twig', [
            'dish' => $dish,
        ]);
    }

    /**
     * @Route("/admin/dish/{id}/edit", name="dish_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Dish $dish): Response
    {
        $form = $this->createForm(DishType::class, $dish);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Your dish has been modified');
            return $this->redirectToRoute('dish_index');
        }

        return $this->render('admin/dish/edit.html.twig', [
            'dish' => $dish,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/dish/{id}", name="dish_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Dish $dish): Response
    {
        if ($this->isCsrfTokenValid('delete' . $dish->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($dish);
            $entityManager->flush();
        }

        $this->addFlash('success', 'Your dish has been deleted');
        return $this->redirectToRoute('dish_index');
    }

    /**
     * @Route("/restorer/dish", name="restorer_dish_index", methods={"GET"})
     */
    public function showMyDishes(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $dishes = $this->getUser()->getRestaurant()->getDish();

        return $this->render('restorer/dish/index.html.twig', [
            'dishes' => $dishes,
        ]);
    }

    /**
     * @Route("/restorer/dish/{id}/edit", name="restorer_dish_edit", methods={"GET","POST"})
     */
    public function editMyDish(Request $request, Dish $dish): Response
    {
        $userOwnDish = false;
        $dishes = $this->getUser()->getRestaurant()->getDish();

        foreach ($dishes as &$myDish) {
            if ($myDish->getId() == $dish->getId()) {
                $userOwnDish = true;
            }
        }

        if ($userOwnDish) {
            $form = $this->createForm(DishType::class, $dish);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                $this->addFlash('success', 'Your dish has been modified');
                return $this->redirectToRoute('restorer_dish_index');
            }

            return $this->render('/admin/dish/edit.html.twig', [
                'dish' => $dish,
                'form' => $form->createView(),
            ]);
        }

        return $this->redirectToRoute('restorer_dish_index');
    }

    /**
     * @Route("/restorer/dish/{id}", name="restorer_dish_delete", methods={"DELETE"})
     */
    public function deleteMyDish(Request $request, Dish $dish): Response
    {
        $userOwnDish = false;
        $dishes = $this->getUser()->getRestaurant()->getDish();

        foreach ($dishes as &$myDish) {
            if ($myDish->getId() == $dish->getId()) {
                $userOwnDish = true;
            }
        }

        if ($this->isCsrfTokenValid('delete' . $dish->getId(), $request->request->get('_token')) && $userOwnDish) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($dish);
            $entityManager->flush();
            $this->addFlash('success', 'Your dish has been deleted');
        }

        return $this->redirectToRoute('restorer_dish_index');
    }

    /**
     * @Route("/restorer/dish/new", name="restorer_dish_new", methods={"GET","POST"})
     */
    public function createRestorerDish(Request $request): Response
    {
        $restaurant = $this->getUser()->getRestaurant();
        $dish = new Dish();
        $dish->setRestaurant($restaurant);

        $form = $this->createForm(DishType::class, $dish);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($dish);
            $entityManager->flush();

            $this->addFlash('success', 'Your dish has been created');
            return $this->redirectToRoute('restorer_dish_index');
        }

        return $this->render('restorer/dish/new.html.twig', [
            'dish' => $dish,
            'form' => $form->createView(),
        ]);
    }
}
