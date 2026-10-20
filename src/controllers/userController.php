<?php
namespace src\controllers;

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
        $path = 'src\\controllers\\user\\loginController';
        $actionController = new $path();
        $actionController->execute('');
    }

    /**
     * Handle user logout
     *
     * @return void
     */
    public function logout() : void {
        $path = 'src\\controllers\\user\\loginController';
        $actionController = new $path();
        $actionController->execute('logout');
    }

    /**
     * Handle user signup
     *
     * @return void
     */
    public function signup() : void {
        $path = 'src\\controllers\\user\\signUpController';
        $actionController = new $path();
        $actionController->execute();
    }

    /**
     * Handle user forgotten password
     *
     * @return void
     */
    public function forgotten_password() : void {
        $path = 'src\\controllers\\user\\forgottenPwdController';
        $actionController = new $path();
        $actionController->execute();
    }

    /**
     * Handle user deletion
     *
     * @return void
     */
    public function deletion() : void {
        $path = 'src\\controllers\\user\\deletionController';
        $actionController = new $path();
        $actionController->execute();
    }
}