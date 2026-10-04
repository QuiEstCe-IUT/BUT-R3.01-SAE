<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../_assets/utils/utils.inc.php';

class UtilsTest extends TestCase
{
    public function testStartPageOutputsFaviconAndTitle(): void
    {
        ob_start();
        start_page();
        $output = ob_get_clean();

        $this->assertStringContainsString('<link rel="icon" type="image/x-icon" href="favicon.ico">', $output);
        $this->assertStringContainsString('<title>Qui est-ce?</title>', $output);
    }

    public function testEndPageOutputsFooterText(): void
    {
        ob_start();
        end_page();
        $output = ob_get_clean();

        $this->assertSame('<p>Fin de page ici</p>', $output);
    }

    public function testNavigationContainsProjectRoutes(): void
    {
        ob_start();
        navigation();
        $output = ob_get_clean();

        $this->assertStringContainsString('index.php?page=home', $output);
        $this->assertStringContainsString('index.php?page=login', $output);
        $this->assertStringContainsString('index.php?page=signUp', $output);
        $this->assertStringContainsString('index.php?page=forgottenPwd', $output);
        $this->assertStringContainsString('Mot de passe oublié', $output);
    }
}