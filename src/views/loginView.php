<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">

        <link rel="stylesheet" href="assets/styles/_default.css">
        <link rel="stylesheet" href="assets/styles/_navigation.css">
        <link rel="stylesheet" href="assets/styles/loginStyle.css">
        <?php start_page(); ?>
    </head>
    <body>
        <div id="main-container">
            <header>
                <?php navigation(); ?>
            </header>

            <div id="right-container">
                <main>
                    <?php
                    if (!isset($_SESSION['suid'])) {
                        // On affiche le formulaire et les liens pour s'inscrire ou récupérer son mot de passe si on est pas connecté
                        echo <<<HTML
                        <div class="cont">
                            <h1>Se connecter</h1>
                            <form method='post' class="form_bg" action="index.php?page=login">
                                <p>Email:</p>
                                <input name='form[email]' class="input" type="text">
                                <p>Mot de passe:</p>
                                <input name='form[mdp]' class="input" type="password">
                                <input type="submit" class="submit">
                            </form>
                        HTML;

                        if (isset($error)) {
                            echo $error;
                        }

                        echo <<<HTML
                            <a href="index.php?page=signUp" class="link">S'inscrire</a><br>
                            <a href="index.php?page=forgottenPwd" class="link">Mot de passe oublié</a>
                        </div>
                        HTML;
                    } else {
                        // On affiche que l'on est connecté
                        echo <<<HTML
                        <h1>Actuellement connecté en tant que :</h1>
                        HTML;
                        $username = $_SESSION['username'];
                        echo "<p>$username</p>";
                        echo '<a href="index.php?page=login&action=logout">Se déconnecter</a><br>';
                    }
                    ?>
                </main>
                <footer>
                    <?php end_page(); ?>
                </footer>
            </div>
        </div>
    </body>
</html>