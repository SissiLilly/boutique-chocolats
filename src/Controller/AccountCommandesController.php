<?php

namespace App\Controller;

use App\Entity\Commande;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountCommandesController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/account/commandes', name: 'app_account_commandes')]
    public function index(): Response
    {
        $orders = $this->entityManager->getRepository(Commande::class)->findAllByUser($this->getUser());

        return $this->render('account/order.html.twig', [
            'orders' => $orders
        ]);

    }


}
