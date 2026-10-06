<?php

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunInSeparateProcess;
use PHPUnit\Framework\TestCase;
use src\controllers\forgottenPwdController;

require_once __DIR__ . '/../../core/utils/utils.inc.php';
require_once __DIR__ . '/../../src/controllers/forgottenPwdController.php';

#[CoversClass(forgottenPwdController::class)]
class MdpOublieTest extends TestCase
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
	public function testFormulaireEstAffichePourUnVisiteur(): void
	{
		ob_start();
		try {
			(new forgottenPwdController())->execute();
		} finally {
			$html = ob_get_clean();
		}

		$this->assertStringContainsString('<h1>Mot de passe oublié</h1>', $html);
		$this->assertStringContainsString("name='form[email]'", $html);
		$this->assertStringContainsString('Envoyer mail', $html);
	}

	#[RunInSeparateProcess]
	public function testUtilisateurConnecteNePeutPasDemanderDeReinitialisation(): void
	{
		$_SESSION = ['suid' => 'session-id'];

		ob_start();
		try {
			(new forgottenPwdController())->execute();
		} finally {
			$html = ob_get_clean();
		}

		$this->assertStringContainsString(
			'Vous êtes déjà connecté, vous ne pouvez pas modifier votre mot de passe',
			$html
		);
		$this->assertStringNotContainsString("name='form[email]'", $html);
	}
}
