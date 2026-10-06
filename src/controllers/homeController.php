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
        $path = 'src\\views\\homeView';
        (new $path())->show();
    }
}
