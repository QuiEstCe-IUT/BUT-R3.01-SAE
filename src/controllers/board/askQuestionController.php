<?php
namespace src\controllers\board;

use src\views\board\BoardView;

/**
 * Controller to ask question to the opponent or wait until the opponent asked a question.
 */
class AskQuestionController {
    /**
     * Executes the question logic and renders the view
     *
     * @return void
     */
    public function execute() {
        // On vérifie que l'on est connecté
        if (isset($_SESSION['suid'])) {
            // On vérifie qui doit poser la question (par la BD)
            $weAsk = false;
            $skip = false; // Si personne ne pose de question
            // TODO: Lire la BD

            // plus personne ne pose de question, alors on passe à la réponse
            if ($skip == true) {
                header('Location: /board/answerQuestion');
                exit;
            }

            if ($weAsk == true) {
                // On vérifie si on à envoyé la question
                if (isset($_POST['form'])) {
                    // On filtre les entrées pour éviter les injections SQL
                    $args = [
                        'form' => [
                            'filter' => FILTER_DEFAULT,
                            'flags'  => FILTER_REQUIRE_ARRAY,
                        ]
                    ];
                    $postData = filter_input_array(INPUT_POST, $args);

                    // On récupère la question qui à été posé
                    $question = '';
                    if (isset($postData['form']['question'])) {
                        $question = $postData['form']['question'];
                    }

                    // On envoie la question à l'autre joueur
                    // TODO: Stocker dans la BD

                    // On recharge la page
                    header('Location: /board/answerQuestion');
                    exit;
                }
                // Sinon on affiche le plateau avec l'entrée pour écrire la question
                // TODO: Afficher view

            } else {
                // On affiche le plateau avec un texte disant que l'autre joueur est en train de poser une question
                // TODO: Afficher view

            }
        } else {
            // On redirige vers la page de connection
            header('Location: /user/login');
        }
    }
}