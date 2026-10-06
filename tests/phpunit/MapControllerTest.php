<?php

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use src\controllers\mapController;

require_once __DIR__ . '/../../core/utils/utils.inc.php';
require_once __DIR__ . '/../../src/controllers/mapController.php';

#[CoversClass(mapController::class)]
class MapControllerTest extends TestCase
{
	public function testMapControllerRendersEveryPageRoute(): void
	{
		ob_start();
		try {
			(new mapController())->execute();
		} finally {
			$html = ob_get_clean();
		}

		$this->assertStringContainsString('<h2>Plan du site</h2>', $html);

		foreach ([
			'index.php?page=home',
			'index.php?page=login',
			'index.php?page=signUp',
			'index.php?page=forgottenPwd',
			'index.php?page=legalNotice',
			'index.php?page=article',
			'index.php?page=about',
			'index.php?page=contact',
			'index.php?page=deletion',
		] as $route) {
			$this->assertStringContainsString($route, $html);
		}

		$this->assertSame(8, substr_count($html, '<li>'));
	}
}
