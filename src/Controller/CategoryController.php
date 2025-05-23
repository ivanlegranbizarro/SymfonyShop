<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryForm;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CategoryController extends AbstractController
{
    #[Route('/admin/category', name: 'app_category')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('admin/category/index.html.twig', [
            'categories' => $categories
        ]);
    }

    #[Route('/admin/category/{id}', name: 'app_category_show')]
    public function show(Category $category): Response
    {
        return $this->render('admin/category/show.html.twig', [
            'category' => $category
        ]);
    }

    #[Route('/admin/add/category', name: 'app_category_add')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryForm::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($category);
            $em->flush();
            $this->addFlash('success', 'Category created successfully');
            return $this->redirectToRoute('app_category');
        }
        return $this->render('admin/category/new.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/admin/edit/category/{id}', name: 'app_category_edit')]
    public function edit(Category $category, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(CategoryForm::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Category updated successfully');
            return $this->redirectToRoute('app_category');
        }
        return $this->render('admin/category/edit.html.twig', [
            'form' => $form
        ]);
    }
}
