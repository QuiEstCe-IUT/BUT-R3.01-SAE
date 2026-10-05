<?php

namespace src\controllers {
    function filter_input_array(...$arguments)
    {
        return \filter_var_array($_POST, $arguments[1] ?? null);
    }
}

namespace {
    use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
    use PHPUnit\Framework\TestCase;

    require_once __DIR__ . '/../src/controllers/signUpController.php';
    require_once __DIR__ . '/../core/utils/utils.inc.php';

    #[RunTestsInSeparateProcesses]
    class VerificationChampsTest extends TestCase
    {
        protected function setUp(): void
        {
            $_POST = [];
            $_SESSION = [];
            $_GET = [];
        }

        private function executeWithForm(array $overrides = []): string
        {
            $form = array_replace([
                'pseudo' => 'Alice',
                'prenom' => 'Alice',
                'nom' => 'Dubois',
                'email' => 'email-invalide',
                'mdp' => 'password',
                'mdp2' => 'password',
                'adress' => '1 rue de Aix',
                'generalCondition' => 'on',
            ], $overrides);

            if (array_key_exists('generalCondition', $overrides) && $overrides['generalCondition'] === null) {
                unset($form['generalCondition']);
            }

            $_POST['form'] = $form;

            ob_start();
            (new \src\controllers\SignUpController())->execute();
            return ob_get_clean();
        }

        public function testPseudoVideAfficheErreur(): void
        {
            $output = $this->executeWithForm(['pseudo' => '']);

            $this->assertStringContainsString('Veuillez entrer un pseudonyme', $output);
        }

        public function testPseudoTropLongAfficheErreur(): void
        {
            $output = $this->executeWithForm(['pseudo' => str_repeat('a', 21)]);

            $this->assertStringContainsString('le pseudonyme doit être inférieur ou égale à 20 caractères', $output);
        }

        public function testPrenomVideAfficheErreur(): void
        {
            $output = $this->executeWithForm(['prenom' => '']);

            $this->assertStringContainsString('Veuillez entrer le prenom', $output);
        }

        public function testPrenomTropLongAfficheErreur(): void
        {
            $output = $this->executeWithForm(['prenom' => str_repeat('a', 31)]);

            $this->assertStringContainsString('le prenom doit être inférieur ou égale à 30 caractères', $output);
        }

        public function testNomVideAfficheErreur(): void
        {
            $output = $this->executeWithForm(['nom' => '']);

            $this->assertStringContainsString('Veuillez entrer le nom', $output);
        }

        public function testNomTropLongAfficheErreur(): void
        {
            $output = $this->executeWithForm(['nom' => str_repeat('a', 31)]);

            $this->assertStringContainsString('le nom doit être inférieur ou égale à 30 caractères', $output);
        }

        public function testEmailInvalideAfficheErreur(): void
        {
            $output = $this->executeWithForm();

            $this->assertStringContainsString("L'email est incorrect", $output);
        }

        public function testMotsDePasseDifferentsAffichentErreur(): void
        {
            $output = $this->executeWithForm(['mdp2' => 'different']);

            $this->assertStringContainsString('Le mot de passe entré est différent', $output);
        }

        public function testMotDePasseVideAfficheErreur(): void
        {
            $output = $this->executeWithForm(['mdp' => '', 'mdp2' => '']);

            $this->assertStringContainsString('Veuillez entrer un mot de passe', $output);
        }

        public function testConditionsNonAccepteesAffichentErreur(): void
        {
            $output = $this->executeWithForm(['generalCondition' => null]);

            $this->assertStringContainsString("Veuillez accepter les conditions d'utilisation", $output);
        }

        public function testAdresseVideAfficheErreur(): void
        {
            $output = $this->executeWithForm(['adress' => '']);

            $this->assertStringContainsString('Veuillez entrer une addresse', $output);
        }
    }
}