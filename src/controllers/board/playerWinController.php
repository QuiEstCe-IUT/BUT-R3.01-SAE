<?php
namespace src\controllers\board;

use src\views\board\PlayerWinView;

use src\models\UserModel;

/**
 * Controller to simply choose which character you want to eliminate from your board
 */
class ChooseController {
    /**
     * Render the board view with a button to finish eliminating characters and move onto the next question
     *
     * @return void
     */
    public function execute() {
        // On appelle la BD pour vérifier qui à gagné
        // TODO: Lire la BD
        $winner_id = 00000;
        $secretCharacter = '';

        // On récupère le nom du joueur gagnant a partit de son id
        // TODO: Lire la BD
        $winner_name = '';

        // Affichage de la vue de victoire du joueur
        (new PlayerWinView())->show($winner_name, $secretCharacter);
    }
}