<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{
    /**
     * @Route("/item/{name}", name="product")
     * @param Product $product
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Product $product)
    {
        return $this->render('product/index.html.twig', [
            'product' => $product,
        ]);
    }
}
