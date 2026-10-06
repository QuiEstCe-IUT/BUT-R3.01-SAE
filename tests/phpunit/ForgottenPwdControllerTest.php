<?php

namespace src\controllers {
    if (!function_exists(__NAMESPACE__ . '\\filter_input_array')) {
        function filter_input_array(...$arguments)
        {
            return \filter_var_array($_POST, $arguments[1] ?? null);
        }
    }
}

namespace {
    use PHPUnit\Framework\Attributes\CoversClass;
    use PHPUnit\Framework\Attributes\RunInSeparateProcess;
    use PHPUnit\Framework\TestCase;
    use src\controllers\forgottenPwdController;
	use src\views\ForgottenPwdView;

    require_once __DIR__ . '/../../core/utils/utils.inc.php';
    require_once __DIR__ . '/../../src/controllers/forgottenPwdController.php';

    #[CoversClass(forgottenPwdController::class)]
	#[CoversClass(ForgottenPwdView::class)]
    class ForgottenPwdControllerTest extends TestCase
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

	    private function executeController(): string
	    {
		    ob_start();
		    try {
			    (new forgottenPwdController())->execute();
		    } finally {
			    $html = ob_get_clean();
		    }

		    return $html;
	    }

	    #[RunInSeparateProcess]
	    public function testFormulaireEstAffichePourUnVisiteur(): void
	    {
		    $html = $this->executeController();

		    $this->assertStringContainsString('<h1>Mot de passe oublié</h1>', $html);
		    $this->assertStringContainsString('name="form[email]"', $html);
		    $this->assertStringContainsString('Envoyer mail', $html);
	    }

	    #[RunInSeparateProcess]
	    public function testUtilisateurConnecteNePeutPasDemanderDeReinitialisation(): void
	    {
		    $_SESSION = ['suid' => 'session-id'];
		    $html = $this->executeController();

		    $this->assertStringContainsString(
			    'Vous êtes déjà connecté, vous ne pouvez pas modifier votre mot de passe',
			    $html
		    );
		    $this->assertStringNotContainsString('name="form[email]"', $html);
	    }

	    #[RunInSeparateProcess]
	    public function testEmailInvalideAfficheErreurSansInterrogerLaBase(): void
	    {
		    $_POST = ['form' => ['email' => 'email-invalide']];
		    $html = $this->executeController();

		    $this->assertStringContainsString("Format d'email incorrect", $html);
	    }

	    #[RunInSeparateProcess]
	    public function testEmailManquantAfficheErreurSansInterrogerLaBase(): void
	    {
		    $_POST = ['form' => []];
		    $html = $this->executeController();

		    $this->assertStringContainsString('Veuillez remplir tous les champs', $html);
	    }

	    #[RunInSeparateProcess]
	    public function testTokenAfficheLeFormulaireDeNouveauMotDePasse(): void
	    {
		    $_GET = ['token' => 'token-de-test'];
		    $html = $this->executeController();

		    $this->assertStringContainsString('name="form2[mdp]"', $html);
		    $this->assertStringContainsString('name="form2[mdp2]"', $html);
		    $this->assertStringContainsString('token=token-de-test', $html);
	    }
    }
}
