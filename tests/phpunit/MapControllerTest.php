<?php

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use src\controllers\mapController;

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
			'/home',
			'/user/login',
			'/user/signup',
			'/user/forgotten_password',
			'/legalNotice',
			'/article',
			'/user/deletion',
		] as $route) {
			$this->assertStringContainsString($route, $html);
		}

		$this->assertSame(7, substr_count($html, '<li>'));
	}
}
