<?php
namespace src\controllers;

use src\views\HomeView;

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
        (new HomeView())->show();
    }
}
