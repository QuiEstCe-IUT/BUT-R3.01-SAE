<?php
namespace src\views;

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
        ?>
        <!DOCTYPE html>
        <html lang="fr">
            <head>
                <meta charset="utf-8">

                <link rel="stylesheet" href="assets/styles/_default.min.css">
                <link rel="stylesheet" href="assets/styles/_navigation.min.css">
                <link rel="stylesheet" href="assets/styles/forgottenPwdStyle.min.css">
                <?php start_page(); ?>
            </head>
            <body>
                <div id="main-container">
                    <header>
                        <?php navigation(); ?>
                    </header>

                    <div id="right-container">
                        <main>
                            <div class="cont">
                                <h1>Mot de passe oublié</h1>
                                <?php if (isset($_SESSION['suid'])) { ?>
                                    <p>Vous êtes déjà connecté, vous ne pouvez pas modifier votre mot de passe</p>

                                <?php } else if (isset($success)) { ?>
                                    <!-- Affichage du message de succès -->
                                    <?php echo $success; ?>
                                    <br><br>
                                    <a href="index.php?page=login" class="link">Se connecter</a>

                                <?php } else if (isset($get_token)) { ?>
                                    <!-- Formulaire 2 : Nouveau mot de passe -->
                                    <form method="post" class="form_bg" action="index.php?page=forgottenPwd&token=<?php echo $get_token; ?>">
                                        <p><label for="mdp">Nouveau mot de passe :</label></p>
                                        <input id="mdp" name="form2[mdp]" class="input" type="password" required>

                                        <p><label for="mdp2">Confirmer le mot de passe :</label></p>
                                        <input id="mdp2" name="form2[mdp2]" class="input" type="password" required>

                                        <input type="submit" class="submit" value="Modifier">
                                    </form>
                                    <?php
                                    if (isset($error)) {
                                        echo $error;
                                    }
                                    ?>

                                <?php } else { ?>
                                    <!-- Formulaire 1 : Demande d'email -->
                                    <form method="post" class="form_bg" action="index.php?page=forgottenPwd">
                                        <p><label for="email">Email :</label></p>
                                        <input id="email" name="form[email]" class="input" type="email" placeholder="Adresse mail" required>

                                        <input type="submit" class="submit" value="Envoyer mail">
                                    </form>
                                    <?php
                                    if (isset($error)) {
                                        echo $error;
                                    }
                                    ?>
                                <?php } ?>
                            </div>
                        </main>
                        <footer>
                            <?php end_page(); ?>
                        </footer>
                    </div>
                </div>
            </body>
        </html>
        <?php
    }
}
