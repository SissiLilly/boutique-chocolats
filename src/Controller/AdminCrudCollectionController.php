<?php

namespace App\Controller;

use App\Entity\Collection;
use App\Form\CollectionType;
use App\Repository\CollectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/crud/collection')]
class AdminCrudCollectionController extends AbstractController
{
    #[Route('/', name: 'app_admin_crud_collection_index', methods: ['GET'])]
    public function index(CollectionRepository $collectionRepository): Response
    {
        return $this->render('admin/admin_crud_collection/index.html.twig', [
            'collections' => $collectionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_crud_collection_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CollectionRepository $collectionRepository): Response
    {
        $collection = new Collection();
        $form = $this->createForm(CollectionType::class, $collection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $collectionRepository->save($collection, true);

            return $this->redirectToRoute('app_admin_crud_collection_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_crud_collection/new.html.twig', [
            'collection' => $collection,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_crud_collection_show', methods: ['GET'])]
    public function show(Collection $collection): Response
    {
        return $this->render('admin/admin_crud_collection/show.html.twig', [
            'collection' => $collection,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_crud_collection_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Collection $collection, CollectionRepository $collectionRepository): Response
    {
        $form = $this->createForm(CollectionType::class, $collection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $collectionRepository->save($collection, true);

            return $this->redirectToRoute('app_admin_crud_collection_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_crud_collection/edit.html.twig', [
            'collection' => $collection,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_crud_collection_delete', methods: ['POST'])]
    public function delete(Request $request, Collection $collection, CollectionRepository $collectionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$collection->getId(), $request->request->get('_token'))) {
            $collectionRepository->remove($collection, true);
        }

        return $this->redirectToRoute('app_admin_crud_collection_index', [], Response::HTTP_SEE_OTHER);
    }
}
