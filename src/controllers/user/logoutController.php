<?php
namespace src\controllers\user;

use src\controllers\user\LoginController;
use src\models\UserModel;

/**
 * Controller for handling user logout.
 */
class LogoutController {
    /**
     * Executes the logout logic.
     *
     * @return void
     */
    public function execute() : void {
        $_SESSION = array(); // On vide la variable superglobale session pour se déconnecter

        // Call login
        (new LoginController())->execute();
    }
}