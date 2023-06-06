<?php

namespace App\Controller;

use App\Entity\Chocolat;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class ChocolatController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/nos-chocolats", name="chocolats")
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        $productsQuery = $this->entityManager->getRepository(Chocolat::class)->createQueryBuilder('c');
        $productsQuery->orderBy('c.nom', 'ASC');
        
        $productsPerPage = $request->query->getInt('limit', 4); // get the number of products to display per page from the request
        
        $products = $paginator->paginate(
            $productsQuery, /* query builder */
            $request->query->getInt('page', 1), /* current page */
            $productsPerPage /* number of items per page */
        );
        
        return $this->render('chocolat/index.html.twig', [
            'products' => $products,
            'productsPerPage' => $productsPerPage // pass the number of products per page to the view
        ]);
    }
    

   

 

    /**
     * @Route("/produit/{slug}", name="product")
     */
    public function show($slug)
    {
        $product = $this->entityManager->getRepository(Chocolat::class)->findOneBySlug($slug);
        $products = $this->entityManager->getRepository(Chocolat::class)->findByIsBest(1);

        // changer les order de nos produits
        shuffle($products);
        // extraire que 4 chocolats de notre tableau products
        $products = array_slice($products, 0, 4);

        if (!$product) {
            return $this->redirectToRoute('products');
        }

        return $this->render('chocolat/show.html.twig', [
            'product' => $product,
            'products' => $products
        ]);
    }
}
