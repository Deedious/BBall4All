<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $formulaire = $this->createForm(ContactType::class);
        $formulaire->handleRequest($request);
        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            $task = $formulaire->getData();
            


            // ENVOIE DU MAIL
        $email = (new Email())
        ->from($task['email'])
        ->to('you@example.com')
        //->cc('cc@example.com')
        //->bcc('bcc@example.com')
        //->replyTo('fabien@example.com')
        //->priority(Email::PRIORITY_HIGH)
        ->subject($task['object'])
        ->text($task['message'])
        ->html($task['object']);

        $mailer->send($email);
            
            return $this->render('contact/contact_envoye.html.twig',[
                'data' => $task
            ]);
        }

        return $this->renderForm('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'formulaire' => $formulaire
        ]);
    }

}


        

        