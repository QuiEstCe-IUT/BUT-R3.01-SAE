<?php
namespace src\controllers\board;

use src\views\board\LobbyView;

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

        $action = $_GET['action'] ?? null;

        if ($action === 'create_room') {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                return;
            }

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
                header('Location: /board/lobby');
                exit;
            }
        } elseif ($action === 'join_room') {
            $roomId = filter_input(INPUT_GET, 'room_id', FILTER_VALIDATE_INT);
            if ($roomId === false || $roomId === null) {
                http_response_code(400);
                return;
            }

            $room = null;
            // TODO: Récupérer le salon correspondant à cet identifiant en base.

            if ($room !== null) {
                $roomAvailable = false;
                // TODO: Vérifier que le salon attend un deuxième joueur et que l'utilisateur n'en fait pas déjà partie.

                if ($roomAvailable) {
                    // TODO: Inscrire l'utilisateur connecté comme deuxième joueur en base.

                    $playerCount = 0;
                    // TODO: Récupérer le nombre de joueurs après son inscription.

                    if ($playerCount === 2) {
                        // TODO: Enregistrer l'heure de début de la partie (durée maximale : 30 minutes).
                        // TODO: Rediriger vers le choix du personnage secret.
                        exit;
                    }
                }
            } else {
                // TODO: Signaler que le salon n'existe plus et rediriger vers la liste des salons.
            }
        } elseif ($action === 'leave_room') {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                return;
            }

            $roomId = filter_input(INPUT_POST, 'room_id', FILTER_VALIDATE_INT);
            if ($roomId === false || $roomId === null) {
                http_response_code(400);
                return;
            }

            // TODO: Vérifier que le salon appartient à l'utilisateur et qu'il attend encore un adversaire.
            // TODO: Supprimer ou annuler le salon en base.
            header('Location: /board/lobby');
            exit;
        } elseif ($action !== null) {
            http_response_code(404);
            return;
        }

        $rooms = [];
        // TODO: Récupérer en base les salons ouverts et rejoignables.
        $currentRoom = null;
        // TODO: Récupérer le salon créé par l'utilisateur s'il attend encore un adversaire.
        // Il doit contenir au minimum les clés 'id' et 'name' attendues par la vue.

        (new LobbyView())->show($rooms, $currentRoom);
    }
}
