<?php

namespace src\views\board;

use src\views\_Layout;

/**
 * View for the player win page.
 */
class PlayerWinView {
    public function show($winnerName, $secretCharacter) {
        $layout = new _Layout();
        ?>
        <!DOCTYPE html>
        <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <link rel="stylesheet" href="assets/styles/_default.min.css">
                <link rel="stylesheet" href="assets/styles/gameStyle.min.css">
                <?php $layout->start_page(); ?>
                <title>Victoire !</title>
            </head>
            <body>
                <main style="padding: 40px 20px; text-align: center;">
                    <div style="max-width: 600px; margin: 0 auto; background: #fff; padding: 40px; border: 1px solid #ddd; border-radius: 8px;">
                        <h1 style="color: #2a2c2c; font-size: 2.5em; margin-bottom: 10px;">🎉 Victoire ! 🎉</h1>
                        <p style="font-size: 1.2em; color: var(--color_link); margin-bottom: 20px;">
                            Félicitations <strong><?= htmlspecialchars($winnerName) ?></strong> !
                        </p>
                        
                        <div style="background: #f9f9f9; padding: 15px; border-radius: 6px; border: 1px solid #ddd; margin-bottom: 30px;">
                            <p style="margin: 0; color: #555;">Le personnage mystère était :</p>
                            <h2 style="margin: 10px 0 0 0; color: #2a2c2c; font-size: 1.8em;"><?= htmlspecialchars($secretCharacter) ?></h2>
                        </div>

                        <div style="display: flex; gap: 15px; justify-content: center;">
                            <a href="/lobby" style="padding: 10px 20px; border: 1px solid #ddd; text-decoration: none; border-radius: 4px;">Retour au Lobby</a>
                            <a href="/board/pick" style="padding: 10px 20px; background: #2a2c2c; color: #fff; text-decoration: none; border-radius: 4px;">Rejouer</a>
                        </div>
                    </div>
                </main>

                <footer>
                    <?php $layout->end_page(); ?>
                </footer>
            </body>
        </html>
        <?php
    }
}
