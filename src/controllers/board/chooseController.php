<?php
namespace src\controllers\board;

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
        // On vérifie que l'on est connecté
        if (isset($_SESSION['suid'])) {
            // On vérifie qui doit éliminer ses personnages (celui qui à posé la question) (par la BD)
            $weChoose = false;
            $skip = false; // Si personne ne choisis
            // TODO: Lire la BD

            // plus personne ne choisis, alors on passe à la prochain question
            if ($skip == true) {
                header('Location: /board/askQuestion');
                exit;
            }

            if ($weChoose == true) {
                // On vérifie si on à envoyé la réponse
                if (isset($_POST['form'])) {
                    // On filtre les entrées pour éviter les injections SQL
                    $args = [
                        'form' => [
                            'filter' => FILTER_DEFAULT,
                            'flags'  => FILTER_REQUIRE_ARRAY,
                        ]
                    ];
                    $postData = filter_input_array(INPUT_POST, $args);

                    // On regarde si notre joueur à choisis de passer à la prochaine question OU si il essaye de deviner le personnage du joueur adverse
                    $guess = false;


                    if ($guess == true) {
                        // On essaye de deviner le personnage

                    } else {
                        // On passe à la prochaine question
                        // TODO: Stocker dans la BD le fait que le joueur suivant pose la question

                        // On redirige
                        header('Location: /board/askQuestion');
                        exit;
                    }
                }
                // Sinon on affiche le plateau avec le boutton pour dire qu'on a fini d'éliminer des personnages OU pour essayer de deviner qui est le perso choisis par l'autre joueur
                // On affiche également un texte pour afficher la réponse à la question
                // TODO: Afficher view

            } else {
                // On affiche le plateau avec un texte disant que l'autre joueur est en train d'éliminer des personnages
                // TODO: Afficher view

            }
        } else {
            // On redirige vers la page de connection
            header('Location: /user/login');
        }
    }
}