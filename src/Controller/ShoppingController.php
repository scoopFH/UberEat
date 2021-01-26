<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderDish;
use App\Repository\DishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class ShoppingController extends AbstractController
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;

        if (!is_null($this->session->get('shoppingBasket', []))) {
            $this->shoppingBasket = $this->session->get('shoppingBasket', []);
        } else {
            $this->shoppingBasket = [];
        }
    }

    /**
     * @Route("/shopping/recap", name="shopping_index")
     */
    public function index(DishRepository $dishRepository): Response
    {
        $shoppingBasketOrganized = [];

        foreach ($this->shoppingBasket as $id => $quantity) {
            if (!is_null($dishRepository->find($id))) {
                $shoppingBasketOrganized[] = [
                    'dish' => $dishRepository->find($id),
                    'quantity' => $quantity
                ];
            }
        }

        $total = 2.5;

        foreach ($shoppingBasketOrganized as $couple) {
            $total += $couple['dish']->getPrice() * $couple['quantity'];
        }

        return $this->render('user/shopping/index.html.twig', [
            "items" => $shoppingBasketOrganized,
            "total" => $total
        ]);
    }

    /**
     * @Route("/shopping/add/{id}", name="shopping_add")
     */
    public function add($id, DishRepository $dishRepository): Response
    {
        if (!is_null($this->shoppingBasket) || !empty($this->shoppingBasket)) {
            foreach ($this->shoppingBasket as $idDish => $quantity) {
                if ($dishRepository->find($idDish)->getRestaurant() != $dishRepository->find($id)->getRestaurant()) {
                    return $this->redirectToRoute('shopping_index');
                }
            }
        }

        if (empty($this->shoppingBasket[$id])) {
            $this->shoppingBasket[$id] = 0;
        }

        $this->shoppingBasket[$id]++;

        $this->session->set('shoppingBasket', $this->shoppingBasket);
        return $this->redirectToRoute('shopping_index');
    }

    /**
     * @Route("/restaurant/shopping/add/{id}", name="restaurant_shopping_add")
     */
    public function addFromRestaurant($id, DishRepository $dishRepository): Response
    {
        if (!is_null($this->shoppingBasket) || !empty($this->shoppingBasket)) {
            foreach ($this->shoppingBasket as $idDish => $quantity) {
                if ($dishRepository->find($idDish)->getRestaurant() != $dishRepository->find($id)->getRestaurant()) {
                    return $this->redirectToRoute('home');
                }
            }
        }

        if (empty($this->shoppingBasket[$id])) {
            $this->shoppingBasket[$id] = 0;
        }

        $this->shoppingBasket[$id]++;

        $this->session->set('shoppingBasket', $this->shoppingBasket);
        $this->addFlash('success', $dishRepository->find($id)->getName().' has been add to your order');

        return $this->render('index/details.html.twig', [
            "restaurants" => $dishRepository->find($id)->getRestaurant(),
        ]);
    }

    /**
     * @Route("/shopping/remove/{id}", name="shopping_remove")
     */
    public function remove($id): Response
    {
        if (!empty($this->shoppingBasket[$id])) {
            if ($this->shoppingBasket[$id] == 1) {
                unset($this->shoppingBasket[$id]);
            } else {
                $this->shoppingBasket[$id]--;
            }
        }

        $this->session->set('shoppingBasket', $this->shoppingBasket);

        return $this->redirectToRoute('shopping_index');
    }

    /**
     * @Route("/shopping/order/buy", name="shopping_order_buy")
     */
    public function buyOrder(DishRepository $dishRepository, MailerInterface $mailer): Response
    {
        if ($this->shoppingBasket != []) {
            $entityManager = $this->getDoctrine()->getManager();
            $order = new Order();
            $total = 2.5;
            $orderDishes = [];
            $restaurant = $dishRepository->find(array_key_first($this->shoppingBasket))->getRestaurant();
            $order->setRestaurant($restaurant);

            foreach ($this->shoppingBasket as $id => $quantity) {
                $orderDish = new OrderDish();
                $orderDish->setDish($dishRepository->find($id));
                $orderDish->setOrders($order);
                $orderDish->setQuantity($quantity);
                $orderDishes[] = $orderDish;
                $entityManager->persist($orderDish);
                for ($i = 0; $i < $quantity; $i++) {
                    $total += $dishRepository->find($id)->getPrice();
                }
            }

            $user = $this->getUser();

            if ($user->getBalance() < $total) {
                $this->addFlash('warning', 'Your order cannot be completed');
                return $this->redirectToRoute('home');
            } else {
                $user->setBalance($user->getBalance() - $total);
            }

            $order->setUsers($user);

            $entityManager->persist($order);
            $entityManager->flush();

            //$restorerMail = $restaurant->getUsers()->getEmail();

            $email = (new TemplatedEmail())
                ->from('ubereat@gmail.com')
                // ->to($restorerMail)
                ->to('matthiaschometon787@gmail.com')
                ->subject('Your command')
                ->htmlTemplate('email/validation_command.html.twig')
                ->context([
                    'order' => $order,
                    'orderDishes' => $orderDishes,
                    'total' => $total,
                    'user' => $user,
                ]);

            $mailer->send($email);

            $email = (new TemplatedEmail())
                ->from('ubereat@gmail.com')
                ->to('matthiaschometon787@gmail.com')
                //->to($user->getEmail())
                ->subject('command of ' . $user->getFirstname() . ' ' . $user->getLastname())
                ->htmlTemplate('email/validation_command.html.twig')
                ->context([
                    'order' => $order,
                    'orderDishes' => $orderDishes,
                    'total' => $total,
                    'user' => $user,
                ]);

            $mailer->send($email);

            $this->session->remove('shoppingBasket');
            $this->addFlash('success', 'Your order has been completed');
            return $this->redirectToRoute('shopping_index');
        }
        return $this->redirectToRoute('home');
    }
}
