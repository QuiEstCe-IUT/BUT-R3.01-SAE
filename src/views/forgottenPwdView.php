<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="assets/styles/_default.css">
        <link rel="stylesheet" href="assets/styles/_navigation.css">
        <link rel="stylesheet" href="assets/styles/forgottenPwdStyle.css">
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
                        <?php if (!isset($success)) { ?>
                            <form method="post" class="form_bg" action="index.php?page=forgottenPwd">
                                <p>Email :</p>
                                <input name="form[email]" class="input" type="email" placeholder="Adresse mail" required>
    
                                <p>Nouveau mot de passe :</p>
                                <input name="form[mdp]" class="input" type="password" required>
    
                                <p>Confirmer le mot de passe :</p>
                                <input name="form[mdp2]" class="input" type="password" required>
    
                                <input type="submit" class="submit" value="Modifier">
                            </form>
                            <?php
                            if (isset($error)) {
                                echo $error;
                            }
                            ?>
                        <?php } else { ?>
                            <?php echo $success; ?>
                            <a href="index.php?page=login" class="link">Se connecter</a>
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

