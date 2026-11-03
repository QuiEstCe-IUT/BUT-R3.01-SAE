<?php
namespace src\controllers;

use src\controllers\board\AskQuestionController;
use src\controllers\board\AnswerQuestionController;
use src\controllers\board\ChooseController;

/**
 * Controller for handling the game board logic
 */
class BoardController {
    /**
     * Affiche le plateau en plus d'un conteneur pour écrire une question auquel l'adversaire devra répondre
     *
     * @return void
     */
    public function askQuestion() : void {
        (new AskQuestionController())->execute();
    }

    /**
     * Affiche le plateau en plus d'un conteneur pour écrire la réponse à la question que l'adversaire à posé
     *
     * @return void
     */
    public function answerQuestion() : void {
        (new AnswerQuestionController())->execute();
    }

    /**
     * Affiche le plateau en plus d'un boutton pour indiquer à l'adversaire que l'on à finit de retourner les personnages que l'on pense éliminer
     *
     * @return void
     */
    public function choose() : void {
        (new ChooseController())->execute();
    }

    /**
     * Affiche le résultat de la partie sélectionner
     *
     * @return void
     */
    public function win() : void {

    }
}