<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilePageController extends AbstractController
{
    #[Route('/profile/page', name: 'app_profile_page')]
    public function index(): Response
    {
        return $this->render('profile_page/index.html.twig', [
            'controller_name' => 'ProfilePageController',
        ]);
    }
}
