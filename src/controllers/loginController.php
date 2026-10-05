<?php
namespace src\controllers;

/**
 * Controller for handling user login and logout.
 */
class LoginController {
    /**
     * Executes the login/logout logic and renders the view.
     *
     * @return void
     */
    public function execute() : void {
        $error = null;

        // Gestion de la déconnexion
        if (array_key_exists('action', $_GET)) {
            if ($_GET['action'] == 'logout') {
                $_SESSION = array(); // On vide la variable superglobale session pour se déconnecter
            }
        }

        
        // On vérifie le contenu du formulaire d'authentification (si on est pas déjà connecté)
        if (isset($_POST['form']) && !isset($_SESSION['suid'])) {
            // On filtre les entrées pour éviter les injections SQL
            $args = [
                'form' => [
                    'filter' => FILTER_DEFAULT,
                    'flags'  => FILTER_REQUIRE_ARRAY,
                ]
            ];
            $postData = filter_input_array(INPUT_POST, $args);

            if (isset($postData['form']['email']) && isset($postData['form']['mdp'])) {
                // On charge le modèle et on cherche l'utilisateur par email
                require_once __DIR__ . '/../models/loginModel.php';
                $user = \LoginModel::getUserByEmail($postData['form']['email']);

                if ($user && password_verify($postData['form']['mdp'], $user['hash_password'])) {
                    // informations correctes, on cree la session
                    $_SESSION['suid'] = session_id();
                    $_SESSION['username'] = $user['login'];
                    $_SESSION['user_id'] = $user['user_id']; // pour le delete du compte

                    // on redirige vers la page d'accueil
                    header('Location: index.php?page=home');
                    exit;
                } else {
                    // informations invalide
                    $error = "<p class='error'>Email ou mot de passe incorrect</p>";
                }
            }
        }

        // On affiche le formulaire d'authentification
        require_once __DIR__ . '/../views/loginView.php';
    }
}