<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductTypeForm;
use App\Repository\ProductRepository;
use App\Services\UploadImage;
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
    public function add(Request $request, EntityManagerInterface $em, UploadImage $uploadImage): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductTypeForm::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imageFile')->getData();

            if ($imageFile) {
                $fileName = $uploadImage->uploadImageFile($imageFile);
                $product->setImage($fileName);
            }

            $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'Product created successfully');
            return $this->redirectToRoute('app_product');
        }

        return $this->render('admin/product/new.html.twig', [
            'form' => $form->createView(),
            'product' => null,
            'button_label' => 'Create Product'
        ]);
    }

    #[Route('/admin/product/{id}', name: 'app_product_show')]
    public function show(Product $product): Response
    {
        return $this->render('admin/product/show.html.twig', [
            'product' => $product
        ]);
    }

    #[Route('/admin/edit/product/{id}', name: 'app_product_edit')]
    public function edit(Product $product, Request $request, EntityManagerInterface $em, UploadImage $imageService): Response
    {
        $originalImage = $product->getImage();

        $form = $this->createForm(ProductTypeForm::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imageFile')->getData();

            if ($imageFile) {
                $fileName = $imageService->uploadImageFile($imageFile);
                $product->setImage($fileName);
                $imageService->deleteImageFile($originalImage);
            } else {
                $product->setImage($originalImage);
            }

            $em->flush();

            $this->addFlash('success', 'Product updated successfully');
            return $this->redirectToRoute('app_product');
        }

        return $this->render('admin/product/new.html.twig', [
            'form' => $form->createView(),
            'product' => $product,
            'edit' => 'edit',
            'button_label' => 'Update Product'
        ]);
    }

    #[Route('/admin/delete/product/{id}', name: 'app_product_delete', methods: ['POST'])]
    public function delete(Product $product, Request $request, EntityManagerInterface $em, UploadImage $imageService): Response
    {
        if (!$this->isCsrfTokenValid('delete_product_' . $product->getId(), $request->request->get('_token'))) {
            $this->addFlash('error', 'Invalid CSRF Token');
            return $this->redirectToRoute('app_product');
        }
        $oldImage = $product->getImage();
        $imageService->deleteImageFile($oldImage);
        $em->remove($product);
        $em->flush();
        $this->addFlash('success', 'Product deleted successfully ');
        return $this->redirectToRoute('app_product');
    }
}
