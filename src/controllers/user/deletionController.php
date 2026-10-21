<?php
namespace src\controllers\user;

use src\views\user\DeletionView;
use src\models\UserModel;

/**
 * Controller for user deletion.
 */
class DeletionController {
    /**
     * Executes the user deletion logic and renders the view.
     *
     * @return void
     */
    public function execute(): void {
        $error = null;
        $success = null;

        // Si l'utilisateur n'est pas connecté, on le redirige vers l'accueil
        if (!isset($_SESSION['suid']) || !isset($_SESSION['user_id'])) {
            header('Location: /home');
            exit;
        }

        if (isset($_POST['delete_account'])) {
            if (isset($_POST['confirm_delete']) && $_POST['confirm_delete'] === 'on') {
                
                $userId = (int) $_SESSION['user_id'];
                
                if (UserModel::deleteUserById($userId)) {
                    // On vide la session car le compte est supprimé
                    $_SESSION = array();
                    $success = "Votre compte et toutes vos données ont été supprimés avec succès.";
                } else {
                    $error = "Une erreur est survenue lors de la suppression de vos données.";
                }
            } else {
                $error = "Vous devez cocher la case pour confirmer la suppression.";
            }
        }

        (new DeletionView())->show($error, $success);
    }
}
