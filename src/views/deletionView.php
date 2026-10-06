<?php
namespace src\views;

/**
 * View for the signup page.
 */
class DeletionView {
    /**
     * Display the view of the signup page.
     *
     * @return void
     */
    public function show($error, $success) {
        ?>
        <!DOCTYPE html>
        <html lang="fr">
            <head>
                <meta charset="UTF-8">

                <link rel="stylesheet" href="assets/styles/_default.min.css">
                <link rel="stylesheet" href="assets/styles/_navigation.min.css">
                <link rel="stylesheet" href="assets/styles/loginStyle.min.css">
                <?php start_page(); ?>
            </head>
            <body>
                <div id="main-container">
                    <header>
                        <?php navigation(); ?>
                    </header>

                    <div id="right-container">
                        <main>
                            <div class="cont" style="width: 60%; padding: 20px;">
                                <h1>Supprimer mon compte</h1>

                                <?php if (isset($success)) { ?>
                                    <p style="color: green; text-align: center; margin-bottom: 20px;"><?= $success ?></p>
                                    <div style="text-align: center;">
                                        <a href="index.php?page=home" class="link">Retour à l'accueil</a>
                                    </div>
                                <?php } else { ?>
                                    <p style="text-align: center; margin-bottom: 20px;">Attention : Cette action est irréversible. Toutes vos données seront définitivement effacées de notre base de données.</p>

                                    <form method="post" class="form_bg" action="index.php?page=deletion" style="width: 90%; padding: 20px;">
                                        <div style="margin: 20px 0; text-align: center;">
                                            <input type="checkbox" id="confirm_delete" name="confirm_delete">
                                            <label for="confirm_delete">Je confirme vouloir supprimer définitivement mon compte et toutes mes données.</label>
                                        </div>

                                        <input type="submit" name="delete_account" class="submit" value="Supprimer définitivement" style="background-color: #ff4d4d; color: white; border: none; cursor: pointer; width: 250px;">
                                    </form>

                                    <?php if (isset($error)) { ?>
                                        <p class="error" style="text-align: center; margin-top: 15px;"><?= $error ?></p>
                                    <?php } ?>
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
