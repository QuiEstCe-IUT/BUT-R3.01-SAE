<?php
namespace src\views;

/**
 * View for the player win page.
 */
class PlayerWinView {
    /**
     * Display the view when the player wins.
     *
     * @param string $winnerName Name of the winner
     * @param string $secretCharacter The character that had to be guessed
     * @return void
     */
    public function show($winnerName, $secretCharacter) {
        $path = 'src\\views\\_layout';
        $layout = new $path();

        $winnerName = $winnerName ?? 'Joueur';
        $secretCharacter = $secretCharacter ?? 'Personnage Mystère';
        ?>
        <!DOCTYPE html>
        <html lang="fr">
            <head>
                <meta charset="UTF-8">

                <link rel="stylesheet" href="assets/styles/_default.min.css">
                <link rel="stylesheet" href="assets/styles/_navigation.min.css">
                <link rel="stylesheet" href="assets/styles/gameStyle.min.css">
                <?php $layout->start_page(); ?>
                <title>Qui est-ce ? - Victoire !</title>
            </head>
            <body>
                <div id="main-container">
                    <header>
                        <?php $layout->navigation(); ?>
                    </header>

                    <div id="right-container">
                        <main>
                            <div class="cont" style="text-align: center; padding: 40px 20px;">
                                <div class="form_bg" style="max-width: 600px; margin: 0 auto; padding: 40px; border-radius: 8px;">
                                    <h1 style="color: #2a2c2c; font-size: 2.5em; margin-bottom: 10px;">🎉 Victoire ! 🎉</h1>
                                    <p style="font-size: 1.2em; color: var(--color_link); margin-bottom: 20px;">
                                        Félicitations <strong style="color: #2a2c2c;"><?= htmlspecialchars($winnerName) ?></strong> !
                                    </p>
                                    
                                    <div style="background: #f9f9f9; padding: 15px; border-radius: 6px; border: 1px solid #ddd; margin-bottom: 30px;">
                                        <p style="margin: 0; font-size: 1em; color: #555;">Le personnage mystère était bien :</p>
                                        <h2 style="margin: 10px 0 0 0; color: #2a2c2c; font-size: 1.8em;"><?= htmlspecialchars($secretCharacter) ?></h2>
                                    </div>

                                    <div style="display: flex; gap: 15px; justify-content: center;">
                                        <a href="index.php?action=lobby" class="link btn-page" style="text-decoration: none; padding: 10px 20px;">Retour au Lobby</a>
                                        <a href="index.php?action=game" class="link btn-page" style="text-decoration: none; padding: 10px 20px; background-color: #2a2c2c; color: #fff;">Rejouer une partie</a>
                                    </div>
                                </div>
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

