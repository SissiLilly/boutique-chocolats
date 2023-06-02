<?php

namespace App\Classe;


use App\Entity\Chocolat;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{
    private $session;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, SessionInterface $session)
    {
        $this->session = $session;
        $this->entityManager = $entityManager;
    }



    public function add($id)
    {

/*         récuperer la variable qui refrer au panier 
        dans la session si il est vide un tableau vide va etre affecter a notre variable  */
        $cart = $this->session->get('cart', []);

       


        // si un produit spécifique n'exist pas dans le panier 
        if (!empty($cart[$id])) {
            // si le produit exist on allons augmenter la quantite 
            $cart[$id]++;
        } else {
            // sinon on affecte 1 comme quantite
            $cart[$id] = 1;
        }


        // je fait la mise a jour de ma session avec la variable cart
        $this->session->set('cart', $cart);
    }


    // prendre le contenu du panier
    public function get()
    {
        return $this->session->get('cart');
    }

    // enlever le contenu du panier
    public function remove()
    {
        return $this->session->remove('cart');
    }


    // supprimer un produit du panier
    public function delete($id)
    {
        $cart = $this->session->get('cart', []);

        // la methode unset supprimer un element du tableau en fonction de son id
        unset($cart[$id]);
        // mise a jour de notre variable session
        return $this->session->set('cart', $cart);
    }


    // diminiuer la quantité
    public function decrease($id)
    {
        $cart = $this->session->get('cart', []);

         // si la quantite est supérieur a 1 donc nous allons enlever 1 
        if ($cart[$id] > 1) {
            $cart[$id]--;
        } else {
            // sinon c veut que la quantite est egale a 1 on va le supprimer de notre panier
            unset($cart[$id]);
        }

        return $this->session->set('cart', $cart);
    }

    public function getFull()
    {
        $cartComplete = [];


        //verifier si le panier est vide avant de parcourir les produit contenat a lui
        if ($this->get()) {

         
            // parcourir toutes la produit dans le panier
            foreach ($this->get() as $id => $quantity) {
                // récuperer les information pour chaque produit selon l'id
                $product_object = $this->entityManager->getRepository(Chocolat::class)->findOneById($id);

                // si notre id produit n'exist pas dans la base de donnes il va toute simplement l'enlever et continue la boucle
                if (!$product_object) {
                    $this->delete($id);
                    continue;
                }

                // enfin nous allons avoir un tableau qui contient les information des produits avec leur quantites
                $cartComplete[] = [
                    'product' => $product_object,
                    'quantity' => $quantity
                ];
            }
        }

        return $cartComplete;
    }

}
