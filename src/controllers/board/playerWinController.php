<?php
namespace src\controllers\board;

use src\views\board\BoardView;

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

        // On vérifie que l'on est connecté
        if (isset($_SESSION['suid'])) {
            if ($_SESSION['suid']) {
                // Blabla
            }
        } else {
            // On affiche simplement le nom du joueur
        }
    }
}