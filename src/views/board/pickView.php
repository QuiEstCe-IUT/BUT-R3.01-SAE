<?php

namespace src\views\board;

use src\views\_Layout;

class PickView {
    public function show($characters) {
        $layout = new _Layout();
        $characters = $characters ?? [];
        ?>
        <!DOCTYPE html>
        <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <link rel="stylesheet" href="assets/styles/pickViewStyle.css">
                <?php $layout->start_page(); ?>
                <title>Choisir un personnage</title>
            </head>
            <body>
                <header>
                    <?php $layout->navigation(); ?>
                </header>

                <main style="padding: 20px; text-align: center;">
                    <h1>Choisissez votre personnage</h1>

                    <?php if (empty($characters)): ?>
                        <p>Aucun personnage disponible.</p>
                    <?php else: ?>
                        <form action="/board/selectCharacter" method="POST">
                            <div style="display: flex; flex-wrap: wrap; gap: 10px; justify-content: center; margin-bottom: 20px;">
                                <?php foreach ($characters as $character): ?>
                                    <label style="border: 1px solid #ddd; padding: 10px; cursor: pointer;">
                                        <input type="radio" name="character_id" value="<?= htmlspecialchars($character['id']) ?>" required>
                                        <span><?= htmlspecialchars($character['name']) ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                            <button type="submit">Valider</button>
                        </form>
                    <?php endif; ?>
                </main>

                <footer>
                    <?php $layout->end_page(); ?>
                </footer>
            </body>
        </html>
        <?php
    }
}
