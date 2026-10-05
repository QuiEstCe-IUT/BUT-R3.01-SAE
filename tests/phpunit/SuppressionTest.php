<?php

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunInSeparateProcess;
use PHPUnit\Framework\TestCase;
use src\controllers\DeletionController;

require_once __DIR__ . '/../../core/utils/utils.inc.php';
require_once __DIR__ . '/../../src/controllers/deletionController.php';

#[CoversClass(DeletionController::class)]
class SuppressionTest extends TestCase
{
	private array $previousPost;
	private array $previousGet;
	private array $previousSession;

	protected function setUp(): void
	{
		$this->previousPost = $_POST;
		$this->previousGet = $_GET;
		$this->previousSession = $_SESSION ?? [];
		$_POST = [];
		$_GET = [];
		$_SESSION = [];
	}

	protected function tearDown(): void
	{
		$_POST = $this->previousPost;
		$_GET = $this->previousGet;
		$_SESSION = $this->previousSession;
	}

	#[RunInSeparateProcess]
	public function testDeletionRequiresExplicitConfirmation(): void
	{
		$_SESSION = ['suid' => 'session-id', 'user_id' => 123];
		$_POST = ['delete_account' => 'Supprimer définitivement'];

		ob_start();
		try {
			(new DeletionController())->execute();
		} finally {
			$html = ob_get_clean();
		}

		$this->assertSame(['suid' => 'session-id', 'user_id' => 123], $_SESSION);
		$this->assertStringContainsString(
			'Vous devez cocher la case pour confirmer la suppression.',
			$html
		);
	}
}
