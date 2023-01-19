<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request): Response
    {
        $formulaire = $this->createForm(ContactType::class);
        $formulaire->handleRequest($request);
        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            $task = $formulaire->getData();
            
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
