<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrController extends AbstractController
{
    #[Route('/or', name: 'or')]
    public function index(): Response
    {
        return $this->render('or/index.html.twig', [
            'controller_name' => 'OrController',
        ]);
    }
}
