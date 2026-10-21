<?php
namespace src\controllers\user;

use src\views\user\ForgottenPwdView;
use src\models\UserModel;

/**
 * Controller for handling forgotten password requests.
 *
 * This controller manages both the request to send a password reset link
 * via email, and the actual password reset process once a valid token is provided.
 */
class ForgottenPwdController {
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

                // On vérifie dans la BD que le token correspond bien à une adresse mail
                $email = UserModel::getEmailByToken(password_hash($get_token, PASSWORD_DEFAULT));

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
                            $error = "Les deux mots de passe ne correspondent pas";
                        }

                        // Vérification que le mot de passe n'est pas vide
                        if ($error === null && strlen($postData['form2']['mdp']) < 12) {
                            $error = "Veuillez entrer un mot de passe de taille 12+ caractères";
                        }

                        // Si pas d'erreur, on modifie le mot de passe
                        if ($error === null) {
                            if (!UserModel::emailExists($email)) {
                                $error = "Le compte associé au token a été supprimé entre temps";
                            } else {
                                // On hache le nouveau mot de passe
                                $hash = password_hash($postData['form2']['mdp'], PASSWORD_DEFAULT);
                                // On met à jour la base
                                $reussite = UserModel::updatePassword($email, $hash);

                                if ($reussite) {
                                    // On supprime le token utilisé
                                    UserModel::deleteToken(password_hash($get_token, PASSWORD_DEFAULT));
                                    $success = "Mot de passe modifié avec succès";
                                } else {
                                    $error = "Une erreur est survenue, veuillez réessayer";
                                }
                            }
                        }
                    } else {
                        $error = "Veuillez remplir tous les champs";
                    }
                } else {
                    // Le token est invalide ou expiré
                    $error = "Lien de réinitialisation invalide ou expiré (1 heure max)";
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
                        $error = "Format d'email incorrect";
                    }

                    // Si pas d'erreur, on vérifie l'email en base
                    if ($error === null) {

                        if (!UserModel::emailExists($postData['form']['email'])) {
                            // On ne révèle aucune information sur si le compte existe
                            $success = "Si l'email associé au compte existe, un email a été envoyé, veuillez vérifier votre boîte mail";
                        } else {
                            // On génère un token cryptographiquement sûr
                            $bytes = random_bytes(32);
                            $token = bin2hex($bytes);

                            $hashed_token = password_hash($token, PASSWORD_DEFAULT);

                            // On sauvegarde (token|email) dans la BD
                            $reussite = UserModel::saveToken($hashed_token, $postData['form']['email']);

                            if ($reussite) {
                                // On envoie un email avec le lien de réinitialisation
                                $to = $postData['form']['email'];
                                $from = 'mathiasm@alwaysdata.net';
                                $reply = 'mathiasm@alwaysdata.net';
                                $subject = '=?UTF-8?B?' . base64_encode('Réinitialisation de mot de passe') . '?=';

                                $headers  = 'MIME-Version: 1.0' . "\r\n";
                                $headers .= 'Content-Type: text/plain; charset=UTF-8' . "\r\n";
                                $headers .= 'From: Name <' . $from . '>' . "\r\n";
                                $headers .= 'Reply-To:' . $reply . "\r\n";
                                $headers .= 'X-Mailer: PHP/' . phpversion() . "\r\n";

                                $message = 'Bonjour, suite à votre demande de réinitialisation ';
                                $message .= 'de mot de passe, veuillez cliquer sur le lien suivant :' . "\n";
                                $message .= 'https://mathiasm.alwaysdata.net/user/forgotten_password?token=' . $token . "\n";
                                $message .= 'Ce lien est valable 1 heure.' . "\n";
                                $message .= 'Si vous n\'êtes pas à l\'origine de cette demande, ignorez ce message.';

                                $envoie = mail($to, $subject, $message, $headers);
                                if ($envoie) {
                                    $success = "Si l'email associé au compte existe, un email a été envoyé, veuillez vérifier votre boîte mail";
                                } else {
                                    $error = "Une erreur est survenue lors de l'envoie de l'email, veuillez réessayer";
                                }
                            } else {
                                $error = "Une erreur est survenue, veuillez réessayer";
                            }
                        }
                    }
                } else {
                    $error = "Veuillez remplir tous les champs";
                }
            }
        }

        // On affiche la vue de mot de passe oublié
        (new ForgottenPwdView())->show($success, $error, $get_token);
    }
}
