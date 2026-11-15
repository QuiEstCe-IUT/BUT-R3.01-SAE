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
        $this->assertTrue(class_exists(\src\controllers\HomeController::class));
    }
}