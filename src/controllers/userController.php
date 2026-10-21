<?php
namespace src\controllers;

use src\controllers\user\LoginController;
use src\controllers\user\SignUpController;
use src\controllers\user\ForgottenPwdController;
use src\controllers\user\DeletionController;

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