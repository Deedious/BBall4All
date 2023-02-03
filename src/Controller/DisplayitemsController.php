<?php

namespace App\Controller;

use App\Entity\SubCategories;
use App\Repository\ItemsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DisplayitemsController extends AbstractController
{
    #[Route('/displayitems/{id}', name: 'app_displayitems')]
    public function index(
            SubCategories $subCategories,
            ItemsRepository $itemsRepository

    ): Response
    {
       // dd( $subCategories  );
     // dd($itemsRepository->findBy([ 'SubCategories'  => $subCategories  ]));
        // REPOSITORY DE L ITEM
        // METHODE QUI VA FILTRER SUR LA SOUS CATEGORIE QUI M INTERESSE
        return $this->render('displayitems/index.html.twig', [
            'data_items_sub_cat' => $itemsRepository->findBy([ 'SubCategories'  => $subCategories  ])
        ]);
    }
}
