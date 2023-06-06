<?php

namespace App\Controller;


use App\Entity\Chocolat;
use App\Classe\Cart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{




    private $cart;


    public function __construct(Cart $cart)
    {
        $this->cart = $cart ;
     }
    

    #[Route('/panier', name: 'app_panier')]
    public function index(): Response
    {
        
        return $this->render('panier/index.html.twig', [
            'chocolats' =>$this->cart->getFull()  ]);
    }






    #[Route('/panier/ajouter/{id}', name: 'add_to_cart')]
    public function add($id)
    {
             $this->cart->add($id);

        return $this->redirectToRoute('app_panier');
    }




    #[Route('/panier/effacer', name: 'remove_my_cart')]
    public function remove()
    {  
        $this->cart->remove();
      return $this->redirectToRoute('app_panier');

    }

    #[Route('/panier/supprimer/{id}', name: 'delete_to_cart')]
    public function delete($id)
    {

        $this->cart->delete($id);
        return $this->redirectToRoute('app_panier');
    }

    
    #[Route('/panier/enlever/{id}', name: 'decrease_to_cart')]
    public function decrease($id)
    {

        $this->cart->decrease($id);
        return $this->redirectToRoute('app_panier');




    }



}