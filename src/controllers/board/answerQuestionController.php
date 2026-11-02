<?php
namespace src\controllers\board;

/**
 * Controller to answer a question from the opponent or wait until the opponent answered our question
 */
class AnswerQuestionController {
    /**
     * Executes the answer logic and renders the view
     *
     * @return void
     */
    public function execute() {
        // On vérifie que l'on est connecté
        if (isset($_SESSION['suid'])) {
            // On vérifie qui doit répondre à la question (par la BD)
            $weAnswer = false;
            $skip = false; // Si personne ne réponds
            // TODO: Lire la BD

            // plus personne n'est en train de répondre, alors on passe à la vue pour éliminer des personnages
            if ($skip == true) {
                header('Location: /board/choose');
                exit;
            }

            if ($weAnswer == true) {
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

                    // On récupère la réponse qui à été écrite
                    $reponse = '';
                    if (isset($postData['form']['reponse'])) {
                        $reponse = $postData['form']['reponse'];
                    }

                    // On envoie la réponse à l'autre joueur
                    // TODO: Stocker dans la BD

                    // On recharge la page
                    header('Location: /board/choose');
                    exit;
                }
                // Sinon on affiche le plateau avec l'entrée pour répondre à la question
                // TODO: Afficher view

            } else {
                // On affiche le plateau avec un texte disant que l'autre joueur est en train de répondre à la question
                // TODO: Afficher view

            }
        } else {
            // On redirige vers la page de connection
            header('Location: /user/login');
        }
    }
}