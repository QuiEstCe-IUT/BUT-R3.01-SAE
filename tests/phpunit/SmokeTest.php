<?php

use PHPUnit\Framework\TestCase;

class SmokeTest extends TestCase
{
    public function testPhpUnitRuns(): void
    {
        $this->assertTrue(true);
    }

    public function testProjectAutoloaderWorks(): void
    {
        // Remplace par une vraie classe du projet
        $this->assertTrue(class_exists(\src\controllers\homeController::class));
    }
}