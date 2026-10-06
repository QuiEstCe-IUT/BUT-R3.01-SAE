<?php

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunInSeparateProcess;
use PHPUnit\Framework\TestCase;
use src\controllers\HomeController;
use src\views\HomeView;

require_once __DIR__ . '/../../core/utils/utils.inc.php';
require_once __DIR__ . '/../../src/controllers/homeController.php';

#[CoversClass(HomeController::class)]
#[CoversClass(HomeView::class)]
class HomeControllerTest extends TestCase
{
    #[RunInSeparateProcess]
    public function testHomeControllerRendersHomePage(): void
    {
        ob_start();
        try {
            (new HomeController())->execute();
        } finally {
            $html = ob_get_clean();
        }

        $this->assertStringContainsString('<h1>Bienvenue sur notre site</h1>', $html);
        $this->assertStringContainsString('<h2>Espace d\'accueil</h2>', $html);
        $this->assertStringContainsString('Découvrez notre Site!', $html);
        $this->assertStringContainsString('Pourquoi nous rejoindre ?', $html);
    }
}