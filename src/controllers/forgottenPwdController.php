<?php
namespace src\controllers;

/**
 * Controller for handling forgotten password requests.
 *
 * This controller manages both the request to send a password reset link
 * via email, and the actual password reset process once a valid token is provided.
 */
class forgottenPwdController {
    /**
     * Executes the forgotten password logic.
     *
     * Processes form submissions for sending a password reset email and
     * resetting the password. Renders the associated view.
     *
     * @return void
     */
    public function execute() : void {
        $error = null;
        $success = null;
        $get_token = null;

        // Gestion de la réinitialisation de mot de passe
        if (array_key_exists('token', $_GET)) {
            $get_token = $_GET['token']; 
        }

        // On regarde si l'utilisateur n'est pas connecté
        if (!isset($_SESSION['suid'])) {
            if (isset($_POST['form2']) && isset($get_token)) {


                require_once __DIR__ . '/../models/signUpModel.php';
                require_once __DIR__ . '/../models/forgottenPwdModel.php';

                // On vérifie dans la BD que le token correspond bien à une adresse mail
                $email = \ForgottenPwdModel::getEmailByToken($get_token);

                // Si le mail existe on vérifie les mots de passe et on met à jour
                if ($email) {
                    // On filtre les entrées
                    $args = [
                        'form2' => [
                            'filter' => FILTER_DEFAULT,
                            'flags'  => FILTER_REQUIRE_ARRAY,
                        ]
                    ];
                    $postData = filter_input_array(INPUT_POST, $args);

                    if (isset($postData['form2']['mdp']) && isset($postData['form2']['mdp2'])) {
                        // Vérification que les deux mots de passe correspondent
                        if ($postData['form2']['mdp'] !== $postData['form2']['mdp2']) {
                            $error = "<p class='error'>Les deux mots de passe ne correspondent pas</p>";
                        }

                        // Vérification que le mot de passe n'est pas vide
                        if ($error === null && strlen($postData['form2']['mdp']) == 0) {
                            $error = "<p class='error'>Veuillez entrer un mot de passe</p>";
                        }

                        // Si pas d'erreur, on modifie le mot de passe
                        if ($error === null) {
                            if (!\SignUpModel::emailExists($email)) {
                                $error = "<p class='error'>Le compte associé au token a été supprimé entre temps</p>";
                            } else {
                                // On hache le nouveau mot de passe
                                $hash = password_hash($postData['form2']['mdp'], PASSWORD_DEFAULT);
                                // On met à jour la base
                                $reussite = \ForgottenPwdModel::updatePassword($email, $hash);

                                if ($reussite) {
                                    // On supprime le token utilisé
                                    \ForgottenPwdModel::deleteToken($get_token);
                                    $success = "<p class='success'>Mot de passe modifié avec succès</p>";
                                } else {
                                    $error = "<p class='error'>Une erreur est survenue, veuillez réessayer</p>";
                                }
                            }
                        }
                    } else {
                        $error = "<p class='error'>Veuillez remplir tous les champs</p>";
                    }
                } else {
                    // Le token est invalide ou expiré
                    $error = "<p class='error'>Lien de réinitialisation invalide ou expiré (1 heure max)</p>";
                }

            } else if (isset($_POST['form'])) {

                // On filtre les entrées
                $args = [
                    'form' => [
                        'filter' => FILTER_DEFAULT,
                        'flags'  => FILTER_REQUIRE_ARRAY,
                    ]
                ];
                $postData = filter_input_array(INPUT_POST, $args);

                if (isset($postData['form']['email'])) {
                    // Vérification du format de l'email
                    $emailRegex = '/^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/';
                    if (!preg_match($emailRegex, $postData['form']['email'])) {
                        $error = "<p class='error'>Format d'email incorrect</p>";
                    }

                    // Si pas d'erreur, on vérifie l'email en base
                    if ($error === null) {
                        require_once __DIR__ . '/../models/signUpModel.php';
                        require_once __DIR__ . '/../models/forgottenPwdModel.php';

                        if (!\SignUpModel::emailExists($postData['form']['email'])) {
                            $error = "<p class='error'>Aucun compte associé à cet email</p>";
                        } else {
                            // On génère un token cryptographiquement sûr
                            $bytes = random_bytes(32);
                            $token = bin2hex($bytes);

                            // On sauvegarde (token|email) dans la BD
                            $reussite = \ForgottenPwdModel::saveToken($token, $postData['form']['email']);

                            if ($reussite) {
                                // On envoie un email avec le lien de réinitialisation
                                $to = $postData['form']['email'];
                                $from = 'no_reply@mathiasm.alwaysdata.net';
                                $reply = 'no_reply@mathiasm.alwaysdata.net';
                                $subject = 'Réinitialisation de mot de passe';

                                $headers = 'From: Name <' . $from . '>' . "\n";
                                $headers .= 'Return-Path: <' . $reply . '>' . "\n";

                                $message = 'Bonjour, suite à votre demande de réinitialisation ';
                                $message .= 'de mot de passe, veuillez cliquer sur le lien suivant :' . "\n";
                                $message .= 'https://mathiasm.alwaysdata.net/index.php?page=forgottenPwd&token=' . $token . "\n";
                                $message .= 'Ce lien est valable 1 heure.' . "\n";
                                $message .= 'Si vous n\'êtes pas à l\'origine de cette demande, ignorez ce message.';

                                $envoie = mail($to, $subject, $message, $headers);
                                if ($envoie) {
                                    $success = "<p class='success'>Un email a été envoyé, veuillez vérifier votre boîte mail</p>";
                                } else {
                                    $error = "<p class='error'>Une erreur est survenue lors de l'envoie de l'email, veuillez réessayer</p>";
                                }
                            } else {
                                $error = "<p class='error'>Une erreur est survenue, veuillez réessayer</p>";
                            }
                        }
                    }
                } else {
                    $error = "<p class='error'>Veuillez remplir tous les champs</p>";
                }
            }
        }

        // On affiche la vue de mot de passe oublié
        $path = 'src\\views\\forgottenPwdView';
        (new $path())->show($success, $error, $get_token);
    }
}
