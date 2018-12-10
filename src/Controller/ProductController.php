<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\Product;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/{id}", name="product")
     */
//    public function index()
//    {
//        $entityManager = $this->getDoctrine()->getManager();
//
//        $product = new Product();
//        $product->setName('Keybord');
//        $product->setPrice(100500);
//        $product->setDescription('this keyboard is amazing');
//        $entityManager->persist($product);
//        $entityManager->flush();
//        return new Response('Saved new product with id '.$product->getId());
//    }

    public function show($id)
    {
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id ' . $id
            );
        }

        return new Response('Check out this great product: ' . $product->getName());
    }

}
