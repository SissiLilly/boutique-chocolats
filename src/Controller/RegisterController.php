<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class RegisterController extends AbstractController



{

    public function __construct(private ManagerRegistry $doctrine){}



    #[Route('/inscription', name: 'app_register')]
    public function index(Request $request , UserPasswordHasherInterface $encoder): Response
    {
        // instancier un utilisateur a partie de la classe user
        $user = new User();

        // afficher le formulaire 
      $form = $this->createForm(RegisterType::class, $user);

      // récuperer l'object formulaire apres la requete submit
      $form = $form->handleRequest($request);

      // verifier si la formulaire a ete envoyé  et valide selon les critères dans la classe RegisterType
       if($form->isSubmitted() && $form->isValid()){
        // récuperer les donnes inserés par le utilisateur
        $user = $form->getData();

        // crypter le mot de passe
        $password = $encoder->hashPassword($user , $user->getPassword());

        $user->setPassword($password);


        // creer une variable doctrine pour avoir acces au manager de doctrine
        $doctrine = $this->doctrine->getManager();

        // lier notre variable avec notre classe cible user
        $userRepository = $doctrine->getRepository(User::class);


           //  récupérer l'email du formulaire inséré
           $email = $form->get('email')->getData();

        // chercher un utilisateur selon l'email sinon null  
        $userExist = $userRepository->findOneBy(['email' => $email]);

        if($userExist){

          // montrer un message d'erreur pour l'utilisateur 
          $form->get('email')->addError(new FormError('Cet e-mail est déjà enregistré.'));
        } else {

        // insertion dans la base de données
        $doctrine = $this->doctrine->getManager();
        $doctrine->persist($user);

        $doctrine->flush();

       

        }







      }($request);


        return $this->render('register/index.html.twig', [
            'form' => $form->createView()
         
        ]);

    }
}
