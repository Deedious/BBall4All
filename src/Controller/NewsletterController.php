<?php

namespace App\Controller;

use App\Form\NewsletterType;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;

class NewsletterController extends AbstractController
{
    #[Route('/newsletter', name: 'app_newsletter')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $formulaire  = $this->createForm(NewsletterType::class);
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
        ->subject('newsletter')
        ->text($task['email'])
        ->html($task['email']);

        $mailer->send($email);

        return $this->render('newsletter/newsletter_envoye.html.twig', [
           'data' => $task        
        ]);
    }

        return $this->renderForm('newsletter/index.html.twig', [
        
        'formulaire' => $formulaire
    ]);
}
}