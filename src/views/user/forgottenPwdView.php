<?php
namespace src\views\user;
use src\views\_Layout;

/**
 * View for the forgotten password page.
 */
class ForgottenPwdView {
    /**
     * Display the view of the forgotten password page.
     *
     * @return void
     */
    public function show($success, $error, $get_token) {
        $path = 'src\\views\\_layout';
        $layout = new $path();
        ?>
        <!DOCTYPE html>
        <html lang="fr">
            <head>
                <meta charset="utf-8">

                <link rel="stylesheet" href="../assets/styles/_default.min.css">
                <link rel="stylesheet" href="../assets/styles/_navigation.min.css">
                <link rel="stylesheet" href="../assets/styles/forgottenPwdStyle.min.css">
                <?php $layout->start_page(); ?>
            </head>
            <body>
                <div id="main-container">
                    <header>
                        <?php $layout->navigation(); ?>
                    </header>

                    <div id="right-container">
                        <main>
                            <div class="cont">
                                <h1>Mot de passe oublié</h1>
                                <?php if (isset($_SESSION['suid'])) { ?>
                                    <p>Vous êtes déjà connecté, vous ne pouvez pas modifier votre mot de passe</p>

                                <?php } else if (isset($success)) { ?>
                                    <!-- Affichage du message de succès -->
                                    <p class='success'><?php echo $success; ?></p>
                                    <br><br>
                                    <a href="/user/login" class="link">Se connecter</a>

                                <?php } else if (isset($get_token)) { ?>
                                    <!-- Formulaire 2 : Nouveau mot de passe -->
                                    <form method="post" class="form_bg" action="/user/forgotten_password?token=<?php echo $get_token; ?>">
                                        <p><label for="mdp">Nouveau mot de passe :</label></p>
                                        <input id="mdp" name="form2[mdp]" class="input" type="password" minlength="12" required>

                                        <p><label for="mdp2">Confirmer le mot de passe :</label></p>
                                        <input id="mdp2" name="form2[mdp2]" class="input" type="password" minlength="12" required>

                                        <input type="submit" class="submit" value="Modifier">
                                    </form>
                                    <p class='error'><?php
                                    if (isset($error)) {
                                        echo $error;
                                    }
                                    ?></p>

                                <?php } else { ?>
                                    <!-- Formulaire 1 : Demande d'email -->
                                    <form method="post" class="form_bg" action="/user/forgotten_password">
                                        <p><label for="email">Email :</label></p>
                                        <input id="email" name="form[email]" class="input" type="email" placeholder="Adresse mail" required>

                                        <input type="submit" class="submit" value="Envoyer mail">
                                    </form>
                                    <p class='error'><?php
                                    if (isset($error)) {
                                        echo $error;
                                    }
                                    ?></p>
                                <?php } ?>
                            </div>
                        </main>
                        <footer>
                            <?php $layout->end_page(); ?>
                        </footer>
                    </div>
                </div>
            </body>
        </html>
        <?php
    }
}
