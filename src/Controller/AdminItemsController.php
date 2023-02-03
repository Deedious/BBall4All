<?php

namespace App\Controller;

use App\Entity\Items;
use App\Entity\Comments;
use App\Form\Items1Type;
use App\Form\CommentsType;
use App\Service\FileUploader;
use App\Repository\ItemsRepository;
use App\Repository\CommentsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/items')]
class AdminItemsController extends AbstractController
{
    #[Route('/', name: 'app_admin_items_index', methods: ['GET'])]
    public function index(ItemsRepository $itemsRepository): Response
    {
        return $this->render('admin_items/index.html.twig', [
            'items' => $itemsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_items_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ItemsRepository $itemsRepository, FileUploader $fileUploader): Response
    {
        $item = new Items();
        $form = $this->createForm(Items1Type::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $img = $form->get('image')->getData();

            // si l'image est bien présente dans le form et envoyé
            if ($img) {
                // 1 j'utilise le service pour envouyé l'image sur le serveur
                $FileName = $fileUploader->upload($img);
                // 2. je récupére le nom et le set dans l'entité
                $item->setimageName($FileName);
            } 
            
            $itemsRepository->save($item, true);

            return $this->redirectToRoute('app_admin_items_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_items/new.html.twig', [
            'item' => $item,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_items_show', methods: ['GET'])]
    public function show(Items $item, CommentsRepository $CommentsRepository, Request $request): Response
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
        return $this->render('admin_items/show.html.twig', [
            'item' => $item,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_items_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Items $item, ItemsRepository $itemsRepository,FileUploader $fileUploader): Response
    {
        $form = $this->createForm(Items1Type::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $img = $form->get('image')->getData();

            // si l'image est bien présente dans le form et envoyé
            if ($img) {
                // 1 j'utilise le service pour envouyé l'image sur le serveur
                $FileName = $fileUploader->upload($img);
                // 2. je récupére le nom et le set dans l'entité
                $item->setimageName($FileName);
            } 
            $itemsRepository->save($item, true);

            return $this->redirectToRoute('app_admin_items_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_items/edit.html.twig', [
            'item' => $item,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_items_delete', methods: ['POST'])]
    public function delete(Request $request, Items $item, ItemsRepository $itemsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$item->getId(), $request->request->get('_token'))) {
            $itemsRepository->remove($item, true);
        }

        return $this->redirectToRoute('app_admin_items_index', [], Response::HTTP_SEE_OTHER);
    }
}
