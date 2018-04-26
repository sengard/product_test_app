<?php

namespace App\Controller;

use Doctrine\ORM\Query;
use Symfony\Bundle\FrameworkBundle\Controller\Controller as SymfonyController;

class Controller extends SymfonyController
{
    public function paginate(Query $query)
    {
        $request = $this->get('request_stack')->getCurrentRequest();
        $pagination = $this->get('knp_paginator')->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $pagination;
    }
}
