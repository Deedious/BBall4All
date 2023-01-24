<?php

namespace App\Controller;

use App\Entity\SubCategories;
use App\Form\SubCategoriesType;
use App\Repository\SubCategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/sub/categories')]
class SubCategoriesController extends AbstractController
{
    #[Route('/', name: 'app_sub_categories_index', methods: ['GET'])]
    public function index(SubCategoriesRepository $subCategoriesRepository): Response
    {
        return $this->render('sub_categories/index.html.twig', [
            'sub_categories' => $subCategoriesRepository->findAll(),
        ]);
    }

    

    #[Route('/{id}', name: 'app_sub_categories_show', methods: ['GET'])]
    public function show(SubCategories $subCategory): Response
    {
        return $this->render('sub_categories/show.html.twig', [
            'sub_category' => $subCategory,
        ]);
    }

    
}
