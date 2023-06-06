<?php

namespace App\Controller;

use App\Entity\Adress;
use App\Form\AdressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class AccountAdressController extends AbstractController
{
    private $entityManager;
    private $session;

    public function __construct(EntityManagerInterface $entityManager , SessionInterface $session)
    {
        $this->entityManager = $entityManager;
        $this->session = $session;
    }


    #[Route('/compte/adresses', name: 'account_address')]
    public function index()
    {
        return $this->render('account/address.html.twig');
    }



  #[Route('/compte/ajouter-une-adresse', name: 'account_address_add')]
    public function add(Request $request)
    {
        // mettre mes produits si exist dans la variable cart 
        $cart = $this->session->get('cart', []);

        // instancier de la entite adress 
        $address = new Adress();

        //creer une formulation de type adresse
        $form = $this->createForm(AdressType::class, $address);

        // mettre notre formulaire pour accepter des requete 
        $form->handleRequest($request);

        // si la formulaire est sumbité et valide
        if ($form->isSubmitted() && $form->isValid()) {

            // indique que l adresse inteseré fait reference a mon utilisateur actuel
            $address->setUser($this->getUser());
            $this->entityManager->persist($address);
            $this->entityManager->flush();
            

            
            if ($cart) {
                return $this->redirectToRoute('app_commande');
            } else {
                return $this->redirectToRoute('account_address');
            }
        }

        return $this->render('account/address_form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/compte/modifier-une-adresse/{id}', name: 'account_address_edit')]
    public function edit(Request $request, $id)
    {
        $address = $this->entityManager->getRepository(Adress::class)->findOneById($id);

        if (!$address || $address->getUser() != $this->getUser()) {
            return $this->redirectToRoute('account_address');
        }

        $form = $this->createForm(AdressType::class, $address);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            return $this->redirectToRoute('account_address');
        }

        return $this->render('account/address_form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/compte/supprimer-une-adresse/{id}', name: 'account_address_delete')]
    public function delete($id)
    {
        $address = $this->entityManager->getRepository(Adress::class)->findOneById($id);

        if ($address && $address->getUser() == $this->getUser()) {
            $this->entityManager->remove($address);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('account_address');
    }

}
