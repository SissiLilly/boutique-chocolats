<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Chocolat;

class HomeController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $bestProduct = $this->entityManager->getRepository(Chocolat::class)->findByIsBest(1);
       
           // changer les order de nos produits
           shuffle($bestProduct);
           // extraire que 4 chocolats de notre tableau best$bestProduct
           $bestProduct = array_slice($bestProduct, 0, 4);

        return $this->render('home/index.html.twig', [
            'bestProduct' => $bestProduct,
        ]);
    }
}
