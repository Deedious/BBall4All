<?php

namespace App\Controller;

use App\Entity\Items;
use App\Form\ItemsType;
use App\Entity\Comments;
use App\Form\CommentsType;
use App\Repository\ItemsRepository;
use App\Repository\CommentsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/items')]
class ItemsController extends AbstractController
{
    #[Route('/', name: 'app_items_index', methods: ['GET'])]
    public function index(ItemsRepository $itemsRepository): Response
    {
        return $this->render('items/index.html.twig', [
            'items' => $itemsRepository->findAll(),
        ]);
    }

    

    #[Route('/{id}', name: 'app_items_show', methods: ['GET'])]
    public function show(Items $item, Request $request, CommentsRepository $CommentsRepository): Response
    {
        $comment = new Comments();
        // dd($Comments);

        $form = $this->createForm(CommentsType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $CommentsRepository->save($comment, true);

            return $this->redirectToRoute('app_items_show', ['id' => $item->getId()], Response::HTTP_SEE_OTHER);
        }

        // recuperer tout les commantaires correspondant à l'identifiant de l'URL
        $Comments=$CommentsRepository->findBy(['Items' => $item->getId()]);
        // dd($Comments);

        return $this->renderForm('items/show.html.twig', [
            'item' => $item,
            'comments' => $Comments,
            'form' => $form,
             ]);
       
             
}
}