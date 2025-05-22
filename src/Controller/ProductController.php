<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductTypeForm;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController
{
    #[Route('/admin/view/products', name: 'app_product')]
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        return $this->render('admin/product/index.html.twig', [
            'products' => $products
        ]);
    }

    #[Route('/admin/add/product', name: 'app_product_add')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductTypeForm::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $newFilename = \uniqid() . '.' . $imageFile->guessExtension();
                $uploadDir = $this->getParameter('uploads_directory');
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
                $imageFile->move($uploadDir, $newFilename);
                $product->setImage($newFilename);
            }
            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute('app_product');
        }

        return $this->render('admin/product/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
