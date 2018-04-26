<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends Controller
{
    /**
     * @Route("/", name="index")
     * @param ProductRepository $productRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(ProductRepository $productRepository)
    {
        $pagination = $this->paginate($productRepository->findAllQuery());
        return $this->render('index/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }
}
