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
    use PHPUnit\Framework\TestCase;
    use PHPUnit\Framework\Attributes\CoversClass;
    use PHPUnit\Framework\Attributes\DataProvider;
    use src\controllers\SignUpController;
    use src\views\SignUpView;

    #[CoversClass(SignUpController::class)]
    #[CoversClass(SignUpView::class)]
    #[CoversClass(\SignUpModel::class)]
    class SignUpControllerTest extends TestCase
    {
        private array $previousPost;
        private array $previousGet;
        private array $previousSession;
        private ?\PDO $previousPdo = null;
        private bool $pdoReplaced = false;

        protected function setUp(): void
        {
            require_once __DIR__ . '/../../core/utils/utils.inc.php';
            require_once __DIR__ . '/../../core/model.php';
            require_once __DIR__ . '/../../src/controllers/signUpController.php';

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

            if ($this->pdoReplaced) {
                (new \ReflectionProperty(\Model::class, 'pdo'))->setValue(null, $this->previousPdo);
                $this->pdoReplaced = false;
            }
        }

        /**
         * Exécute le contrôleur avec un formulaire valide par défaut, sauf l'email,
         * pour ne pas interroger la base de données.
         */
        private function executeWithForm(array $overrides = []): string
        {
            $form = array_replace([
                'pseudo' => 'Alice',
                'prenom' => 'Alice',
                'nom' => 'Dubois',
                'email' => 'email-invalide',
                'mdp' => 'password',
                'mdp2' => 'password',
                'phone' => '',
                'adress' => '1 rue de Aix',
                'generalCondition' => 'on',
            ], $overrides);

            $_POST['form'] = $form;

            return $this->execute();
        }

        private function execute(): string
        {
            ob_start();
            try {
                (new SignUpController())->execute();
            } finally {
                $html = ob_get_clean();
            }

            return $html;
        }

        /**
         * Remplace la connexion PostgreSQL du modèle par une base SQLite en mémoire.
         */
        private function useInMemoryDatabase(): \PDO
        {
            if (!in_array('sqlite', \PDO::getAvailableDrivers(), true)) {
                $this->markTestSkipped('Le driver pdo_sqlite est requis pour ce test.');
            }

            $pdo = new \PDO('sqlite::memory:', null, null, [
                \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            ]);
            $pdo->exec('CREATE TABLE users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                login TEXT, first_name TEXT, last_name TEXT, email TEXT,
                hash_password TEXT, phone_number TEXT, adress TEXT
            )');
            $pdo->exec("INSERT INTO users (login, first_name, last_name, email, hash_password, adress)
                        VALUES ('bob', 'Bob', 'Martin', 'bob@example.com', 'hash', '2 rue de Aix')");

            $property = new \ReflectionProperty(\Model::class, 'pdo');
            $this->previousPdo = $property->getValue();
            $property->setValue(null, $pdo);
            $this->pdoReplaced = true;

            return $pdo;
        }

        private function countUsers(\PDO $pdo): int
        {
            return (int) $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
        }

        public function testSignupControllerRendersSignupView(): void
        {
            $html = $this->execute();

            $this->assertStringContainsString("<h1>S'inscrire</h1>", $html);
            $this->assertStringContainsString("name='form[pseudo]'", $html);
            $this->assertStringContainsString("name='form[email]'", $html);
            $this->assertStringContainsString("name='form[mdp]'", $html);
        }

        public function testSignupViewContainsEveryFormField(): void
        {
            $html = $this->execute();

            $fields = ['pseudo', 'prenom', 'nom', 'email', 'mdp', 'mdp2', 'phone', 'adress', 'generalCondition'];
            foreach ($fields as $field) {
                $this->assertStringContainsString("name='form[$field]'", $html);
            }
            $this->assertStringContainsString('action="index.php?page=signUp"', $html);
            $this->assertStringContainsString('href="index.php?page=login"', $html);
        }

        public function testNoErrorIsDisplayedWithoutSubmittedForm(): void
        {
            $html = $this->execute();

            $this->assertStringNotContainsString("class='error'", $html);
        }

        public function testFormThatIsNotAnArrayIsIgnored(): void
        {
            $_POST['form'] = 'pseudo=Alice';

            $html = $this->execute();

            $this->assertStringContainsString("<h1>S'inscrire</h1>", $html);
            $this->assertStringNotContainsString("class='error'", $html);
        }

        public function testPseudoOfExactlyTwentyCharactersIsAccepted(): void
        {
            $html = $this->executeWithForm(['pseudo' => str_repeat('a', 20)]);

            $this->assertStringNotContainsString('le pseudonyme doit être inférieur', $html);
            $this->assertStringNotContainsString('Veuillez entrer un pseudonyme', $html);
        }

        public function testPrenomAndNomOfExactlyThirtyCharactersAreAccepted(): void
        {
            $html = $this->executeWithForm([
                'prenom' => str_repeat('a', 30),
                'nom' => str_repeat('b', 30),
            ]);

            $this->assertStringNotContainsString('le prenom doit être inférieur', $html);
            $this->assertStringNotContainsString('le nom doit être inférieur', $html);
        }

        public function testOnlyTheEmailErrorIsDisplayedWhenOtherFieldsAreValid(): void
        {
            $html = $this->executeWithForm();

            $this->assertSame(1, substr_count($html, "class='error'"));
            $this->assertStringContainsString("L'email est incorrect", $html);
        }

        public function testEveryErrorIsDisplayedAtTheSameTime(): void
        {
            $html = $this->executeWithForm([
                'pseudo' => '',
                'prenom' => '',
                'nom' => '',
                'mdp2' => 'different',
                'adress' => '',
            ]);

            $this->assertSame(6, substr_count($html, "class='error'"));
            $this->assertStringContainsString('Veuillez entrer un pseudonyme', $html);
            $this->assertStringContainsString('Veuillez entrer le prenom', $html);
            $this->assertStringContainsString('Veuillez entrer le nom', $html);
            $this->assertStringContainsString("L'email est incorrect", $html);
            $this->assertStringContainsString('Le mot de passe entré est différent', $html);
            $this->assertStringContainsString('Veuillez entrer une addresse', $html);
        }

        public function testMissingConditionsAreReportedWithOtherErrors(): void
        {
            $_POST['form'] = [
                'pseudo' => 'Alice',
                'prenom' => 'Alice',
                'nom' => 'Dubois',
                'email' => 'email-invalide',
                'mdp' => 'password',
                'mdp2' => 'password',
                'adress' => '1 rue de Aix',
            ];

            $html = $this->execute();

            $this->assertSame(2, substr_count($html, "class='error'"));
            $this->assertStringContainsString("Veuillez accepter les conditions d'utilisation", $html);
        }

        public static function invalidEmailProvider(): array
        {
            return [
                'sans arobase' => ['alice.example.com'],
                'sans domaine' => ['alice@'],
                'sans extension' => ['alice@example'],
                'extension trop longue' => ['alice@example.abcde'],
                'extension trop courte' => ['alice@example.c'],
                'domaine trop court' => ['alice@e.com'],
                'majuscules' => ['Alice@Example.com'],
                'espace' => ['alice dubois@example.com'],
                'vide' => [''],
            ];
        }

        #[DataProvider('invalidEmailProvider')]
        public function testInvalidEmailIsRejected(string $email): void
        {
            $html = $this->executeWithForm(['email' => $email]);

            $this->assertStringContainsString("L'email est incorrect", $html);
        }

        public function testSessionIsNotStartedWhenFormIsInvalid(): void
        {
            $this->executeWithForm();

            $this->assertArrayNotHasKey('suid', $_SESSION);
            $this->assertArrayNotHasKey('username', $_SESSION);
        }

        public function testEmailAlreadyUsedIsRejected(): void
        {
            $pdo = $this->useInMemoryDatabase();

            $html = $this->executeWithForm(['email' => 'bob@example.com']);

            $this->assertStringContainsString('Cet email est déjà associé à un compte', $html);
            $this->assertStringNotContainsString("L'email est incorrect", $html);
            $this->assertSame(1, $this->countUsers($pdo));
            $this->assertArrayNotHasKey('suid', $_SESSION);
        }

        public function testUnusedEmailIsAcceptedButUserIsNotRegisteredWithOtherErrors(): void
        {
            $pdo = $this->useInMemoryDatabase();

            $html = $this->executeWithForm(['email' => 'alice@example.com', 'pseudo' => '']);

            $this->assertStringNotContainsString('Cet email est déjà associé à un compte', $html);
            $this->assertStringNotContainsString("L'email est incorrect", $html);
            $this->assertStringContainsString('Veuillez entrer un pseudonyme', $html);
            $this->assertSame(1, $this->countUsers($pdo));
        }

        public function testModelRegistersUserAndDetectsItsEmail(): void
        {
            $pdo = $this->useInMemoryDatabase();
            require_once __DIR__ . '/../../src/models/signUpModel.php';

            $this->assertFalse(\SignUpModel::emailExists('alice@example.com'));

            $registered = \SignUpModel::register(
                'alice',
                'Alice',
                'Dubois',
                'alice@example.com',
                'hash',
                null,
                '1 rue de Aix'
            );

            $this->assertTrue($registered);
            $this->assertTrue(\SignUpModel::emailExists('alice@example.com'));
            $this->assertSame(2, $this->countUsers($pdo));

            $user = $pdo->query("SELECT * FROM users WHERE email = 'alice@example.com'")->fetch();
            $this->assertSame('alice', $user['login']);
            $this->assertNull($user['phone_number']);
        }
    }
}
