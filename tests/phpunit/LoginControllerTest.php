<?php

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\RunInSeparateProcess;
use PHPUnit\Framework\Attributes\CoversClass;
use src\controllers\LoginController;

#[CoversClass(LoginController::class)]
class LoginControllerTest extends TestCase
{
    private array $previousPost;
    private array $previousGet;
    private array $previousSession;

    protected function setUp(): void
    {
        require_once __DIR__ . '/../core/utils/utils.inc.php';
        require_once __DIR__ . '/../src/controllers/loginController.php';

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

    public function testLoginControllerRendersLoginView(): void
    {
        ob_start();
        try {
            (new \src\controllers\LoginController())->execute();
        } finally {
            $html = ob_get_clean();
        }

        $this->assertStringContainsString('<h1>Se connecter</h1>', $html);
        $this->assertStringContainsString("name='form[email]'", $html);
        $this->assertStringContainsString("name='form[mdp]'", $html);
    }

    #[RunInSeparateProcess]
    public function testLogoutClearsSessionAndShowsLoginForm(): void
    {
        $_SESSION = ['suid' => 'session-id', 'username' => 'jules'];
        $_GET = ['action' => 'logout'];

        ob_start();
        try {
            (new \src\controllers\LoginController())->execute();
        } finally {
            $html = ob_get_clean();
        }

        $this->assertSame([], $_SESSION);
        $this->assertStringContainsString("name='form[email]'", $html);
    }
}