<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route(path: '/connexion', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Ce code vérifie si l'utilisateur est déjà connecté.
        // S'il est déjà connecté, il sera redirigé vers la page de son compte.
        if ($this->getUser()) {
            return $this->redirectToRoute('app_account');
        }

        // Récupère l'erreur de connexion s'il y en a une.
        $error = $authenticationUtils->getLastAuthenticationError();
        
        // Récupère le dernier nom d'utilisateur saisi par l'utilisateur.
        $lastEmail = $authenticationUtils->getLastUsername();

        // Rend le template 'security/login.html.twig' en passant les variables 'last_username' et 'error'.
        // Ces variables seront utilisées pour afficher le formulaire de connexion et les éventuelles erreurs.
        return $this->render('security/login.html.twig', ['last_email' => $lastEmail, 'error' => $error]);
    }

    #[Route(path: '/deconnexion', name: 'app_logout')]
    public function logout(): void
    {
        // Cette méthode peut être vide, car elle sera interceptée par la clé de déconnexion de votre pare-feu.
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
