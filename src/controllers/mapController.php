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
                'title' => 'Supprimer mon compte',
                'url'   => 'index.php?page=deletion'
            ]
        ];
        
        $path = 'src\\views\\mapView';
        (new $path())->show($pages);
    }
}
