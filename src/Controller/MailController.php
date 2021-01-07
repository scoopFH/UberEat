<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class MailController extends AbstractController
{
    // /**
    //  * @Route("/user/email/validationcommand", methods={"GET", "POST"}, name="mail_user_validation_command")
    //  */
    // public function userValidateCommand(MailerInterface $mailer, Request $request)
    // {
    //     $email = (new TemplatedEmail())
    //         ->from('ubereat@gmail.com')
    //         ->to('matthiaschometon787@gmail.com')
    //         ->subject('Your command')
    //         ->htmlTemplate('email/validation_command_user.html.twig')
    //         ->context([
    //             'commandDishes' => 'test',
    //             'deliveryDate' => 'test'
    //         ]);

    //     $mailer->send($email);

    //     return $this->redirectToRoute('home');
    // }

    /**
     * @Route("/restorer/email/validationcommand", methods={"POST"}, name="mail_restorer_validation_command")
     */
    public function restorerValidateCommand(MailerInterface $mailer, Request $request)
    {

        // $email = (new TemplatedEmail())
        //     ->from('ubereat@gmail.com')
        //     ->to($data['userMail'])
        //     ->subject('Your command')
        //     ->htmlTemplate('email/validation_command_user.html.twig')
        //     ->context([
        //         'commandDishes' => $data['commandDishes'],
        //         'deliveryDate' => $data['deliveryDate']
        //     ]);

        // $mailer->send($email);

        return $this->redirectToRoute('home');
    }
}
