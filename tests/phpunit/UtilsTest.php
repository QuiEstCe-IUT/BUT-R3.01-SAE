<?php

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\CoversFunction;

require_once __DIR__ . '/../../core/utils/utils.inc.php';

#[CoversFunction('start_page')]
#[CoversFunction('end_page')]
#[CoversFunction('navigation')]
class UtilsTest extends TestCase
{
    public function testStartPageOutputsFaviconAndTitle(): void
    {
        ob_start();
        start_page();
        $output = ob_get_clean();

        $this->assertStringContainsString('<link rel="icon" type="image/x-icon" href="favicon.ico">', $output);
        $this->assertStringContainsString('<title>Qui est-ce?</title>', $output);
        $this->assertStringContainsString('og:title', $output);
    }

    public function testEndPageOutputsFooterText(): void
    {
        ob_start();
        end_page();
        $output = ob_get_clean();

        $this->assertStringContainsString('<p>Fin de page ici</p>', $output);
        $this->assertStringContainsString('Tous droits réservés', $output);
    }

    public function testNavigationContainsProjectRoutes(): void
    {
        ob_start();
        navigation();
        $output = ob_get_clean();

        $this->assertStringContainsString('/home', $output);
        $this->assertStringContainsString('/user/login', $output);
        $this->assertStringContainsString('/user/signup', $output);
        $this->assertStringContainsString('/user/forgotten_password', $output);
        $this->assertStringContainsString('/legalNotice', $output);
        $this->assertStringContainsString('/map', $output);
        $this->assertStringContainsString('Home', $output);
        $this->assertStringContainsString('Profil', $output);
        $this->assertStringContainsString('Sign up', $output);
    }
}