<?php

namespace App\Controller;

use App\Form\NewsletterType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NewsletterController extends AbstractController
{
    #[Route('/newsletter', name: 'app_newsletter')]
    public function index(Request $request): Response
    {
        $formulaire  = $this->createForm(NewsletterType::class);
        $formulaire->handleRequest($request);
        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            $task = $formulaire->getData();

        return $this->render('newsletter/newsletter_envoye.html.twig', [
           'data' => $task        
        ]);
    }

        return $this->renderForm('newsletter/index.html.twig', [
        
        'formulaire' => $formulaire
    ]);
}
}