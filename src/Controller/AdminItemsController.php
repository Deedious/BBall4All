<?php

namespace App\Controller;

use App\Entity\Items;
use App\Form\Items1Type;
use App\Repository\ItemsRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function show(Items $item): Response
    {
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
