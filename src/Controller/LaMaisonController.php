<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LaMaisonController extends AbstractController
{
    #[Route('/la/maison', name: 'app_la_maison')]
    public function index(): Response
    {
        return $this->render('la_maison/index.html.twig', [
            'controller_name' => 'LaMaisonController',
        ]);
    }
}
