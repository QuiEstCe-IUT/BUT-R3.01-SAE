<?php
namespace src\controllers\board;

use src\views\LobbyView;

/**
 * Controller for handling the game lobby.
 */
class LobbyController {
    /**
     * Executes the lobby logic.
     *
     * @return void
     */
    public function execute(): void {
        if (!isset($_SESSION['suid'])) {
            header('Location: /user/login');
            exit;
        }

        $roomId = filter_input(INPUT_GET, 'room_id', FILTER_VALIDATE_INT);
        if ($roomId !== null && $roomId !== false) {
            $room = null;
            // TODO: Récupérer le salon correspondant à cet identifiant en base de données.

            if ($room !== null) {
                $roomAvailable = false;
                // TODO: Vérifier en base que le salon attend encore un deuxième joueur.

                if ($roomAvailable) {
                    // TODO: Ajouter l'utilisateur connecté comme deuxième joueur en base.
                }

                $playerCount = 0;
                // TODO: Récupérer le nombre de joueurs inscrits dans ce salon.

                $gameStarted = false;
                // TODO: Récupérer en base si la partie a déjà commencé.

                if ($playerCount === 2 && !$gameStarted) {
                    // TODO: Enregistrer en base l'heure de début de la partie (durée maximale : 30 minutes).
                }

                if ($playerCount === 2) {
                    // TODO: Rediriger le joueur vers l'étape de choix de son personnage secret.
                }
            } else {
                // TODO: Signaler que le salon n'existe pas et rediriger vers la liste des salons.
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $roomName = $_POST['room_name'] ?? null;
            if (!is_string($roomName) || trim($roomName) === '') {
                http_response_code(400);
                echo 'Le nom du salon est obligatoire.';
                return;
            }

            $roomName = trim($roomName);

            $createdRoomId = null;
            // TODO: Créer le salon en base avec son nom et l'utilisateur connecté comme créateur,
            //       puis récupérer son identifiant.

            if ($createdRoomId !== null) {
                // TODO: Rediriger le créateur vers l'attente du deuxième joueur.
            }
        }

        $rooms = [];
        // TODO: Récupérer en base les salons ouverts et rejoignables.
        (new LobbyView())->show($rooms);
    }
}