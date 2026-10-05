<?php

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use src\controllers\SignUpController;

#[CoversClass(SignUpController::class)]
class SignUpControllerTest extends TestCase
{
    private array $previousPost;
    private array $previousGet;
    private array $previousSession;

    protected function setUp(): void
    {
        require_once __DIR__ . '/../core/utils/utils.inc.php';
        require_once __DIR__ . '/../src/controllers/signUpController.php';

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

    public function testSignupControllerRendersSignupView(): void
    {
        ob_start();
        try {
            (new \src\controllers\SignUpController())->execute();
        } finally {
            $html = ob_get_clean();
        }

        $this->assertStringContainsString("<h1>S'inscrire</h1>", $html);
        $this->assertStringContainsString("name='form[pseudo]'", $html);
        $this->assertStringContainsString("name='form[email]'", $html);
        $this->assertStringContainsString("name='form[mdp]'", $html);
    }
}