<?php
namespace src\controllers;

use src\controllers\user\loginController;
use src\controllers\user\signUpController;
use src\controllers\user\forgottenPwdController;
use src\controllers\user\deletionController;

/**
 * Controller for handling user logic.
 */
class UserController {
    /**
     * Handle user login
     *
     * @return void
     */
    public function login() : void {
        (new LoginController())->execute('');
    }

    /**
     * Handle user logout
     *
     * @return void
     */
    public function logout() : void {
        (new LoginController())->execute('logout');
    }

    /**
     * Handle user signup
     *
     * @return void
     */
    public function signup() : void {
        (new SignUpController())->execute();
    }

    /**
     * Handle user forgotten password
     *
     * @return void
     */
    public function forgotten_password() : void {
        (new ForgottenPwdController())->execute();
    }

    /**
     * Handle user deletion
     *
     * @return void
     */
    public function deletion() : void {
        (new DeletionController())->execute();
    }
}