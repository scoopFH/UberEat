<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\Restaurant;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Form\Register;
use App\Form\RestaurantRestorer;
use App\Repository\UserRepository;
use App\Repository\RestaurantRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SecurityController extends AbstractController
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("/registration/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/registration/logout", name="app_logout")
     */
    public function logout()
    {
        $this->session->remove('shoppingBasket');
    }

    /**
     * @Route("/registration/register", name="register_user", methods={"GET","POST"})
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

            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/register.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/register/restorer", name="restorer_register", methods={"GET","POST"})
     */
    public function registerRestorer(Request $request): Response
    {
        $user = new User();
        $user->setRoles(["ROLE_RESTORER"]);
        $form = $this->createForm(Register::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $restaurant = $this->session->get('myRestaurant', []);
            $user->setRestaurant($restaurant);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->persist($restaurant);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/register.html.twig', [
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
        $form = $this->createForm(RestaurantRestorer::class, $restaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->session->set('myRestaurant', $restaurant);

            return $this->redirectToRoute('restorer_register');
        }

        return $this->render('security/restaurant/new.html.twig', [
            'restaurant' => $restaurant,
            'form' => $form->createView(),
        ]);
    }
}
