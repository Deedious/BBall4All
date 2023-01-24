<?php

namespace App\Controller;

use App\Entity\SubCategories;
use App\Form\SubCategories1Type;
use App\Repository\SubCategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/sub/categories')]
class AdminSubCategoriesController extends AbstractController
{
    #[Route('/', name: 'app_admin_sub_categories_index', methods: ['GET'])]
    public function index(SubCategoriesRepository $subCategoriesRepository): Response
    {
        return $this->render('admin_sub_categories/index.html.twig', [
            'sub_categories' => $subCategoriesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_sub_categories_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SubCategoriesRepository $subCategoriesRepository): Response
    {
        $subCategory = new SubCategories();
        $form = $this->createForm(SubCategories1Type::class, $subCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $subCategoriesRepository->save($subCategory, true);

            return $this->redirectToRoute('app_admin_sub_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_sub_categories/new.html.twig', [
            'sub_category' => $subCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_sub_categories_show', methods: ['GET'])]
    public function show(SubCategories $subCategory): Response
    {
        return $this->render('admin_sub_categories/show.html.twig', [
            'sub_category' => $subCategory,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_sub_categories_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SubCategories $subCategory, SubCategoriesRepository $subCategoriesRepository): Response
    {
        $form = $this->createForm(SubCategories1Type::class, $subCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $subCategoriesRepository->save($subCategory, true);

            return $this->redirectToRoute('app_admin_sub_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_sub_categories/edit.html.twig', [
            'sub_category' => $subCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_sub_categories_delete', methods: ['POST'])]
    public function delete(Request $request, SubCategories $subCategory, SubCategoriesRepository $subCategoriesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$subCategory->getId(), $request->request->get('_token'))) {
            $subCategoriesRepository->remove($subCategory, true);
        }

        return $this->redirectToRoute('app_admin_sub_categories_index', [], Response::HTTP_SEE_OTHER);
    }
}
