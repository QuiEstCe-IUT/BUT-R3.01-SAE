<?php
namespace src\controllers;

class MapController
{
    public function execute(): void
    {
        $pages = [
            [
                'title' => 'Accueil',
                'url'   => 'index.php?page=home'
            ],
            [
                'title' => 'Se connecter',
                'url'   => 'index.php?page=login'
            ],
            [
                'title' => 'S\'inscrire',
                'url'   => 'index.php?page=signUp'
            ],
            [
                'title' => 'Mot de passe oublié',
                'url'   => 'index.php?page=forgottenPwd'
            ],
            [
                'title' => 'Mentions Légales',
                'url'   => 'index.php?page=legalNotice'
            ],

            [
                'title' => 'À propos',
                'url'   => 'index.php?page=about'
            ],
            [
                'title' => 'Contact',
                'url'   => 'index.php?page=contact'
            ]
        ];


        require_once __DIR__ . '/../views/mapView.php';
    }
}
