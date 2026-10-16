<?php
namespace src\controllers;

/**
 * Controller for handling the map page.
 */
class mapController {
    /**
     * Executes the map logic renders the view.
     *
     * @return void
     */
    public function execute(): void 
    {
        $pages = [
            [
                'title' => 'Accueil',
                'url'   => '/home'
            ],
            [
                'title' => 'Se connecter',
                'url'   => '/user/login'
            ],
            [
                'title' => 'S\'inscrire',
                'url'   => '/user/signup'
            ],
            [
                'title' => 'Mot de passe oublié',
                'url'   => '/user/forgotten_password'
            ],
            [
                'title' => 'Articles',
                'url'   => '/article'
            ],
            [
                'title' => 'Mentions Légales',
                'url'   => '/legalNotice'
            ],
            [
                'title' => 'Supprimer mon compte',
                'url'   => '/user/deletion'
            ]
        ];
        
        $path = 'src\\views\\mapView';
        (new $path())->show($pages);
    }
}
