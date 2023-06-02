<?php

namespace App\Classe;

use Mailjet\Client;
use Mailjet\Resources;

class Mail
{
    private $api_key = '8cc090328c9c1f19f6e6a89b11cef002';
    private $api_key_secret = '3f1b666eb6cbbfae08e115fe12408b44';

    public function send($to_email, $to_name, $subject, $content)
    {
        // Crée une nouvelle instance du client Mailjet
        $mj = new Client($this->api_key, $this->api_key_secret, true, ['version' => 'v3.1', 'verify' => false]);
        
        // Prépare les données de l'email
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "sab79000@gmail.com",
                        'Name' => "huvelin Boutique Chocolat"
                    ],
                    'To' => [
                        [
                            'Email' => $to_email,
                            'Name' => $to_name
                        ]
                    ],
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => [
                        'content' => $content,
                    ]
                ]
            ]
        ];
        
        // Envoie la requête d'envoi d'email à l'API Mailjet
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        
        // Vérifie si l'envoi a réussi et affiche les données de la réponse
        if ($response->success()) {
            dd($response->getData());
        }
    }
}
