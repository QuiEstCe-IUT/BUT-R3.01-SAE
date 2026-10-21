<?php
namespace src\views\user;
use src\views\_Layout;

/**
 * View for the login page.
 */
class LoginView {
    /**
     * Display the view of the login page.
     *
     * @return void
     */
    public function show($error) {
        $path = 'src\\views\\_layout';
        $layout = new $path();
        ?>
        <!DOCTYPE html>
        <html lang="fr">
            <head>
                <meta charset="UTF-8">
        
                <link rel="stylesheet" href="../assets/styles/_default.min.css">
                <link rel="stylesheet" href="../assets/styles/_navigation.min.css">
                <link rel="stylesheet" href="../assets/styles/loginStyle.min.css">
                <?php $layout->start_page(); ?>
            </head>
            <body>
                <div id="main-container">
                    <header>
                        <?php $layout->navigation(); ?>
                    </header>
        
                    <div id="right-container">
                        <main>
                            <?php
                            if (!isset($_SESSION['suid'])) {
                                // On affiche le formulaire et les liens pour s'inscrire ou récupérer son mot de passe si on est pas connecté
                                echo <<<HTML
                                <div class="cont">
                                    <h1>Se connecter</h1>
                                    <form method='post' class="form_bg" action="/user/login">
                                        <p>Email:</p>
                                        <input name='form[email]' class="input" type="text">
                                        <p>Mot de passe:</p>
                                        <input name='form[mdp]' class="input" type="password">
                                        <input type="submit" class="submit">
                                    </form>
                                HTML;
                                ?>
                                <p class='error'><?php if (isset($error)) {
                                    echo $error;
                                } ?></p>
                                <?php
                                echo <<<HTML
                                    <a href="/user/signup" class="link">S'inscrire</a><br>
                                    <a href="/user/forgotten_password" class="link">Mot de passe oublié</a>
                                </div>
                                HTML;
                            } else {
                                // On affiche que l'on est connecté
                                echo <<<HTML
                                <h1>Actuellement connecté en tant que :</h1>
                                HTML;
                                $username = $_SESSION['username'];
                                echo "<p>$username</p>";
                                echo '<a href="/user/logout" class="link">Se déconnecter</a><br><br>';
                                echo '<a href="/user/deletion" class="link" style="color: red;">Supprimer mon compte</a><br>';
                            }
                            ?>
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