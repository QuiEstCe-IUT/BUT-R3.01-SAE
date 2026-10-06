<?php

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunInSeparateProcess;
use PHPUnit\Framework\TestCase;
use src\controllers\LegalNoticeController;
use src\views\LegalNoticeView;

require_once __DIR__ . '/../../core/utils/utils.inc.php';
require_once __DIR__ . '/../../src/controllers/legalNoticeController.php';

#[CoversClass(LegalNoticeController::class)]
#[CoversClass(LegalNoticeView::class)]
class LegalNoticeControllerTest extends TestCase
{
    #[RunInSeparateProcess]
    public function testLegalNoticeControllerRendersLegalDetails(): void
    {
        ob_start();
        try {
            (new LegalNoticeController())->execute();
        } finally {
            $html = ob_get_clean();
        }

        $this->assertStringContainsString('<h2>Mentions légales</h2>', $html);
        $this->assertStringContainsString('Qui est-ce', $html);
        $this->assertStringContainsString('413 avenue Gaston Berger', $html);
        $this->assertStringContainsString('Protection des données personnelles', $html);
    }
}