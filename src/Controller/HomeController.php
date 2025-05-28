<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, ProductRepository $productRepository): Response
    {
        $query = $request->query->get('q');
        $categoryId = $request->query->getInt('categoryId') ?: null;

        $products = $productRepository->findBySearchAndCategory($query, $categoryId);

        return $this->render('home/index.html.twig', [
            'products' => $products,
        ]);
    }
}
