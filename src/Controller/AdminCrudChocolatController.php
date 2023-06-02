<?php

namespace App\Controller;

use App\Entity\Chocolat;
use App\Form\ChocolatType;
use App\Repository\ChocolatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/admin/crud/chocolat')]
class AdminCrudChocolatController extends AbstractController
{
    #[Route('/', name: 'app_admin_crud_chocolat_index', methods: ['GET'])]
    public function index(ChocolatRepository $chocolatRepository): Response
    {
        return $this->render('admin/admin_crud_chocolat/index.html.twig', [
            'chocolats' => $chocolatRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_crud_chocolat_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ChocolatRepository $chocolatRepository, \Symfony\Component\String\Slugger\SluggerInterface $sluggerInterface): Response
    {
        $chocolat = new Chocolat();
        $form = $this->createForm(ChocolatType::class, $chocolat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $imageFile = $form->get('image')->getData();



            // Extraire le nom de fichier d'origine sans l'extension
            $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);

            // Utiliser le service slugger pour créer une version du nom de fichier d'origine compatible avec les URL
            $safeFilename = $sluggerInterface->slug($originalFilename);

            // Générer un nouveau nom de fichier en ajoutant un identifiant unique et l'extension de fichier d'origine
            $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

            // Essayer de déplacer le fichier téléchargé vers le répertoire désigné avec le nouveau nom de fichier
            try {
                $imageFile->move(
                    $this->getParameter('image_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                // Si une exception est levée, il y a eu un problème lors du déplacement du fichier
            }

            // Enregistrer le nom du fichier dans l'entité Chocolat
            $chocolat->setImageName($newFilename);
            // Set the slug before saving to database
            $chocolat->setSlug($sluggerInterface->slug(strtolower($chocolat->getNom())));
            $chocolatRepository->save($chocolat, true);

            $this->addFlash("success", "Chocolat ajouté avec success");

            return $this->redirectToRoute('app_admin_crud_chocolat_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('admin/admin_crud_chocolat/new.html.twig', [
            'chocolat' => $chocolat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_crud_chocolat_show', methods: ['GET'])]
    public function show(Chocolat $chocolat): Response
    {
        return $this->render('admin/admin_crud_chocolat/show.html.twig', [
            'chocolat' => $chocolat,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_crud_chocolat_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Chocolat $chocolat, ChocolatRepository $chocolatRepository, \Symfony\Component\String\Slugger\SluggerInterface $sluggerInterface): Response
    {
        $form = $this->createForm(ChocolatType::class, $chocolat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $chocolatRepository->save($chocolat, true);
            $imageFile = $form->get('image')->getData();
            // Extraire le nom de fichier d'origine sans l'extension
            $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);

            // Utiliser le service slugger pour créer une version du nom de fichier d'origine compatible avec les URL
            $safeFilename = $sluggerInterface->slug($originalFilename);

            // Générer un nouveau nom de fichier en ajoutant un identifiant unique et l'extension de fichier d'origine
            $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

            try {
                $imageFile->move(
                    $this->getParameter('image_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                // Si une exception est levée, il y a eu un problème lors du déplacement du fichier
            }

            // Enregistrer le nom du fichier dans l'entité Chocolat
            $chocolat->setImageName($newFilename);
            // Set the slug before saving to database
            $chocolat->setSlug($sluggerInterface->slug(strtolower($chocolat->getNom())));
            $chocolatRepository->save($chocolat, true);

            return $this->redirectToRoute('app_admin_crud_chocolat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_crud_chocolat/edit.html.twig', [
            'chocolat' => $chocolat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_crud_chocolat_delete', methods: ['POST'])]
    public function delete(Request $request, Chocolat $chocolat, ChocolatRepository $chocolatRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $chocolat->getId(), $request->request->get('_token'))) {
            $chocolatRepository->remove($chocolat, true);
        }

        return $this->redirectToRoute('app_admin_crud_chocolat_index', [], Response::HTTP_SEE_OTHER);
    }
}
