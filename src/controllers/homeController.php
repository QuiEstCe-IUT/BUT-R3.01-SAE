<?php
namespace src\controllers;

/**
 * Controller for the home page.
 */
class HomeController {
    /**
     * Executes the home page logic and renders the view.
     *
     * @return void
     */
    public function execute() {
        require_once __DIR__ . '/../views/homeView.php';
    }
}
