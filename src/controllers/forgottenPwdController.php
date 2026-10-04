<?php
namespace src\controllers;

class forgottenPwdController {
    public function execute() : void {
        $error = null;
        $success = null;

        // Gestion de la réinitialisation de mot de passe
        if (array_key_exists('token', $_GET)) {
            $get_token = $_GET['action'];
        }

        // On regarde si l'utilisateur n'est pas connecté et si il a envoyé un formulaire
        if (!isset($_SESSION['suid'])) {
            if (isset($_POST['form2']) && isset($get_token)) { // Formulaire pour réinitialiser le mot de passe avec le token

                // On vérifie dans la BD que le token correspond bien à une adresse mail (token|email)
                $email = '';

                // Si le mail existe on vérifie que les deux mots de passe correspondent et on met à jour le mot de passe
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
                        if ($error === null && $postData['form2']['mdp'] !== $postData['form2']['mdp2']) {
                            $error = "<p class='error'>Les deux mots de passe ne correspondent pas</p>";
                        }

                        // Vérification que le mot de passe n'est pas vide
                        if ($error === null && strlen($postData['form']['mdp2']) == 0) {
                            $error = "<p class='error'>Veuillez entrer un mot de passe</p>";
                        }

                        // Si pas d'erreur, on verifie modifie le mot de passe
                        if ($error === null) {
                            if (!\SignUpModel::emailExists($email)) {
                                $error = "<p class='error'>Le compte associé au token à été détruit entre temps</p>";
                            } else {
                                // On hache le nouveau mot de passe
                                $hash = password_hash($postData['form2']['mdp'], PASSWORD_DEFAULT);
                                // On met à jour la base
                                $reussite = \ForgottenPwdModel::updatePassword($email, $hash);

                                if ($reussite) {
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
                    // Le token est invalide, on ne trouve pas d'email associé
                    $error = "<p class='error'>Token d'authentification invalide, impossible de réinitialiser le mot de passe</p>";
                }

            } else if (isset($_POST['form'])) { // Formulaire pour envoyer un email à une adresse mail
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
                    if (!preg_match('/^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/', $postData['form']['email'])) {
                        $error = "<p class='error'>Format d'email incorrect</p>";
                    }

                    // Si pas d'erreur, on verifie l'email en base et on maj le mdp
                    if ($error === null) {
                        // On reutilise emailExists() de SignUpModel
                        require_once __DIR__ . '/../models/signUpModel.php';

                        if (!\SignUpModel::emailExists($postData['form']['email'])) {
                            $error = "<p class='error'>Aucun compte associé à cet email</p>";
                        } else {
                            //---- On génère un code d'authentification
                            // Générer 32 octets aléatoires cryptographiquement sûrs
                            $bytes = random_bytes(32);
                            // Convertir en chaîne hexadécimale (64 caractères)
                            $token = bin2hex($bytes);

                            //---- On sauvvegarde en base de données le code d'authentification
                            require_once __DIR__ . '/../models/forgottenPwdModel.php';
                            // On sauvegarde (token|email) dans la BD
                            //$reussite = \ForgottenPwdModel::
                            $reussite = false;

                            if ($reussite) {
                                //---- On envoie un email à l'utilisateur avec le code d'authentification en lien
                                $to = $postData['form']['email'];
                                $from = 'no_reply@mathiasm.alwaysdata.net';
                                $reply = 'no_reply@mathiasm.alwaysdata.net';
                                $subject = 'Réinitialisation de mot de passe';

                                $headers = 'From: Name <' . $from . '>' . "\n";
                                $headers .= 'Return-Path: <' . $reply . '>' . "\n";

                                $message = 'Bonjour, suite à votre demande de réinitialisation de mot de passe, veuillez cliquer sur le lien suivant pour le modifier : ' . "\n";
                                $message .= 'https://mathiasm.alwaysdata.net/index.php?page=forgottenPwd&token=' . $token . "\n";
                                $message .= 'Si vous n\'êtes pas à l\'origine de cette demande, veuillez ignorer ce message.';

                                mail($to, $subject, $message, $headers);

                                $success = "<p class='success'>Un email à été envoyé à l'adresse rentrée, veuillez lire l'email pour continuer</p>";
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

        /*
        // On regarde si l'utilisateur n'est pas connecté et si il a envoyé un formulaire
        if (isset($_POST['form']) && !isset($_SESSION['suid'])) {
            // On filtre les entrées
            $args = [
                'form' => [
                    'filter' => FILTER_DEFAULT,
                    'flags'  => FILTER_REQUIRE_ARRAY,
                ]
            ];
            $postData = filter_input_array(INPUT_POST, $args);

            if (isset($postData['form']['email']) && isset($postData['form']['mdp']) && isset($postData['form']['mdp2'])) {

                // Vérification du format de l'email
                if (!preg_match('/^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/', $postData['form']['email'])) {
                    $error = "<p class='error'>Format d'email incorrect</p>";
                }

                // Vérification que les deux mots de passe correspondent
                if ($error === null && $postData['form']['mdp'] !== $postData['form']['mdp2']) {
                    $error = "<p class='error'>Les deux mots de passe ne correspondent pas</p>";
                }

                // Vérification que le mot de passe n'est pas vide
                if ($error === null && strlen($postData['form']['mdp']) == 0) {
                    $error = "<p class='error'>Veuillez entrer un mot de passe</p>";
                }

                // Si pas d'erreur, on verifie l'email en base et on maj le mdp
                if ($error === null) {
                    // On reutilise emailExists() de SignUpModel
                    require_once __DIR__ . '/../models/signUpModel.php';
                    require_once __DIR__ . '/../models/forgottenPwdModel.php';

                    if (!\SignUpModel::emailExists($postData['form']['email'])) {
                        $error = "<p class='error'>Aucun compte associé à cet email</p>";
                    } else {
                        // On hache le nouveau mot de passe
                        $hash = password_hash($postData['form']['mdp'], PASSWORD_DEFAULT);

                        // On met à jour la base
                        $reussite = \ForgottenPwdModel::updatePassword($postData['form']['email'], $hash);

                        if ($reussite) {
                            $success = "<p class='success'>Mot de passe modifié avec succès</p>";
                        } else {
                            $error = "<p class='error'>Une erreur est survenue, veuillez réessayer</p>";
                        }
                    }
                }
            }
        }
        */

        // On affiche la vue de mot de passe oublié
        require_once __DIR__ . '/../views/forgottenPwdView.php';
    }
}
