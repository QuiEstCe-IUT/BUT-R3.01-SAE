<?php

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\CoversMethod;
use src\views\_Layout;

#[CoversMethod(_Layout::class, 'start_page')]
#[CoversMethod(_Layout::class, 'end_page')]
#[CoversMethod(_Layout::class, 'navigation')]
class UtilsTest extends TestCase
{
    public function testStartPageOutputsFaviconAndTitle(): void
    {
        ob_start();
        (new _Layout())->start_page();
        $output = ob_get_clean();

        $this->assertStringContainsString('<link rel="icon" type="image/x-icon" href="favicon.ico">', $output);
        $this->assertStringContainsString('<title>Qui est-ce?</title>', $output);
        $this->assertStringContainsString('og:title', $output);
    }

    public function testEndPageOutputsFooterText(): void
    {
        ob_start();
        (new _Layout())->end_page();
        $output = ob_get_clean();

        $this->assertStringContainsString('<p>Fin de page ici</p>', $output);
        $this->assertStringContainsString('Tous droits réservés', $output);
    }

    public function testNavigationContainsProjectRoutes(): void
    {
        ob_start();
        (new _Layout())->navigation();
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