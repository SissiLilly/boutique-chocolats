<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Commande;
use Symfony\Component\Routing\Annotation\Route;

class CommandeRéussieController extends AbstractController
{
    
    private $entityManager;

    //
    public function __construct(EntityManagerInterface $entityManager) 
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/commande/success/{orderId}', name: 'app_commande_sucess')]
    public function index(int $orderId): Response
    {

        $commande = $this->entityManager->getRepository(Commande::class)->find($orderId); 


        return $this->render('commande_réussie/index.html.twig', [
            'commande' => $commande,
        ]);
    }
}
