<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends Controller
{
    /**
     * @Route("/category/{name}", name="category")
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Category $category)
    {
        return $this->render('category/index.html.twig', [
            'category' => $category,
        ]);
    }
}
