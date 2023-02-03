<?php

namespace App\Controller;

use App\Service\Calcul;
use App\Form\DiscountType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DiscountController extends AbstractController
{
    #[Route('/discount', name: 'app_discount')]
    public function index(Calcul $calcul, Request $request): Response
    {
        $formulaire = $this->createForm(DiscountType::class);

            // traitement de l'envoie du formulaire :
            //1. regarder à partir du formulaire
            // si des données sont à lire dans l'objet request
                $formulaire->handleRequest($request);
            // 2. Si je trouve des données et que le formulaire
            // on a cliqué sur envoyé
                if ($formulaire->isSubmitted() && $formulaire->isValid()) {
           // $form->getData() holds the submitted values
           // but, the original $task variable has also been updated
           $task = $formulaire->getData();
           $newPrice = $calcul->calculer($task['prixInitial'], $task['pourcentagediscount']);
        //    $newPrice = $task['prixInitial'] - ($task['prixInitial']*$task['pourcentagediscount']/100);
           

           // ... perform some action, such as saving the task to the database

           return $this->render('discount/discount_envoye.html.twig', [
            'data' => $task,
            'newPrice' => $newPrice
        ]);
       }
        return $this->renderForm('discount/index.html.twig', [
           'formulaire'=>$formulaire
        ]);
    }

}
