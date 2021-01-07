<?php

namespace App\Controller;

use App\Entity\Order;
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
            $this->shoppingBasket = "";
        }
    }

    /**
     * @Route("/shopping", name="shopping_index")
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
    public function add($id): Response
    {
        if (empty($this->shoppingBasket[$id])) {
            $this->shoppingBasket[$id] = 0;
        }

        $this->shoppingBasket[$id]++;

        $this->session->set('shoppingBasket', $this->shoppingBasket);

        return $this->redirectToRoute('shopping_index');
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
        $order = new Order();

        foreach ($this->shoppingBasket as $id => $quantity) {
            foreach($quantity as &$id) {
                $order->addDish($dishRepository->find($id));
            }
        }

        $user = $this->getUser();
        $order->setUsers($user);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($order);
        $entityManager->flush();

        $email = (new TemplatedEmail())
            ->from('ubereat@gmail.com')
            ->to('matthiaschometon787@gmail.com')
            ->subject('Your command')
            ->htmlTemplate('email/validation_command.html.twig')
            ->context([
                'order' => $order,
            ]);

        $mailer->send($email);

        return $this->redirectToRoute('shopping_index');
    }
}
