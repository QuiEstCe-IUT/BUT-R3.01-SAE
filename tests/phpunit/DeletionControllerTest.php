<?php

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunInSeparateProcess;
use PHPUnit\Framework\TestCase;
use src\controllers\user\DeletionController;
use src\views\user\DeletionView;

require_once __DIR__ . '/../../src/views/_layout.php';
require_once __DIR__ . '/../../src/controllers/user/deletionController.php';

#[CoversClass(DeletionController::class)]
#[CoversClass(DeletionView::class)]
class DeletionControllerTest extends TestCase
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

	#[RunInSeparateProcess]
	public function testConnectedUserSeesDeletionFormWithoutSubmittingIt(): void
	{
		$_SESSION = ['suid' => 'session-id', 'user_id' => 123];

		ob_start();
		try {
			(new DeletionController())->execute();
		} finally {
			$html = ob_get_clean();
		}

		$this->assertStringContainsString('<h1>Supprimer mon compte</h1>', $html);
		$this->assertStringContainsString('name="confirm_delete"', $html);
		$this->assertSame(123, $_SESSION['user_id']);
	}
}
