<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Commande;
use App\Form\CommandeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CommandeController extends AbstractController
{
    private $entityManager;

    //
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/commande', name: 'app_commande')]
    public function index(Cart $Cart): Response
    {

        // si l'utilisateur n'est authentifie il va etre rediger vers la page de connexion
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }


        // si l'utilisateur n a pas d'adresse il va etre rediger vers la page pour ajouter une adresse
        if (!$this->getUser()->getAdresses()->getValues()) {
            return $this->redirectToRoute('account_address_add');
        }

        $form = $this->createForm(CommandeType::class, null, [
            'user' => $this->getUser()
        ]);

        return $this->render('commande/index.html.twig', [
            'form' => $form->createView(),
            'panier' => $Cart->getFull()
        ]);
    }






    #[Route('/commande-recu', name: 'app_commande-recu')]
    public function recu(Request $request): Response
    {
        return $this->render('commande/sucess.html.twig', []);
    }






    #[Route('/commande/recapitulatif', name: 'order_recap')]
    public function add(Cart $cart, Request $request)
    {
        $form = $this->createForm(CommandeType::class, null, [
            'user' => $this->getUser()
        ]);

        $form = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $date = new \DateTime();
            $transporteur = $form->get('transporteur')->getData();
            $livraison = $form->get('adresse')->getData();
            $livraison_content = '<br/>' . $livraison->getAddress();


            // Enregistrer ma commande Commande()
            $commande = new Commande(); // Crée une nouvelle instance de l'entité Commande

            $reference = $date->format('dmY') . '-' . uniqid(); 
            // Génère une référence unique pour la commande
            $commande->setReference($reference); 
            // Définit la référence de la commande

            $commande->setUser($this->getUser()); 
            // Définit l'utilisateur associé à la commande

            $commande->setCreatedAt($date); 
            // Définit la date de création de la commande

            $commande->setNomTransporteur($transporteur->getNom()); 
            // Définit le nom du transporteur pour la commande
            $commande->setPrixTransporteur(floatval($transporteur->getPrix())); 
            // Définit le prix du transporteur pour la commande

            $commande->setLivraison($livraison_content); 
            // Définit les informations de livraison pour la commande

            $commande->setEtatCommande(2); 
            // Définit l'état de la commande (2 représente en cours de préparation)

            foreach ($cart->getFull() as $product) {
                $commande->setProduct($product['product']->getNom()); 
                // Définit le nom du produit pour la commande

                $commande->setQuantite($product['quantity']); 
                // Définit la quantité du produit pour la commande

                $commande->setPrixProduit($product['product']->getPrix()); 
                // Définit le prix unitaire du produit pour la commande

                $commande->setPrixCommande($product['product']->getPrix() * $product['quantity']); 
                // Calcule le prix total de la commande pour ce produit

                $this->entityManager->persist($commande); 
                // Persiste la commande dans l'EntityManager
            }



            return $this->redirectToRoute('app_commande_sucess', ['orderId' => $commande->getId()]);




            return $this->render('commande/add.html.twig', [
                'cart' => $cart->getFull(),
                'carrier' => $transporteur,
                'delivery' => $livraison_content,
                'reference' => $commande->getReference()
            ]);
        }
        return $this->redirectToRoute('app_panier');
    }
}
