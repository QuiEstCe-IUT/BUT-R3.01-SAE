<?php

namespace src\views\board;

class PickView {
    /**
     * @param array 
     * @return void
     */
    public function show($characters) {
        $path = 'src\\views\\_layout';
        $layout = new $path();

        $characters = $characters ?? [];
        ?>
        <!DOCTYPE html>
        <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <link rel="stylesheet" href="assets/styles/pickViewStyle.css">
                <?php $layout->start_page(); ?>
                <title>Qui est-ce ? - Choisir un personnage</title>
            </head>
            <body>
                <div id="main-container">
                    <header>
                        <?php $layout->navigation(); ?>
                    </header>

                    <div id="right-container">
                        <main>
                            <div class="cont" style="text-align: center; padding: 20px;">
                                <h1> Choisissez votre personnage</h1>
                                <p style="margin: 5px 0 20px 0; color: var(--color_link);">Sélectionnez un personnage sur le plateau pour commencer la partie.</p>

                                <div class="form_bg" style="max-width: 900px; margin: 0 auto; padding: 20px;">
                                    <?php if (empty($characters)): ?>
                                        <p>Ce personnage n'est pas disponible.</p>
                                    <?php else: ?>
                                        <form action="index.php?action=select_character" method="POST">
                                            <div class="board-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 15px; margin-bottom: 20px;">
                                                <?php foreach ($characters as $character): ?>
                                                    <label class="character-card" style="border: 1px solid #ddd; border-radius: 6px; padding: 10px; background: #fff; cursor: pointer; display: flex; flex-direction: column; align-items: center; transition: 0.2s;">
                                                        <input type="radio" name="character_id" value="<?= htmlspecialchars($character['id']) ?>" required style="margin-bottom: 8px;">
                                                        
                                                        <?php if (!empty($character['image'])): ?>
                                                            <img src="<?= htmlspecialchars($character['image']) ?>" alt="<?= htmlspecialchars($character['name']) ?>" style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px; margin-bottom: 8px;">
                                                        <?php endif; ?>

                                                        <span style="font-weight: bold; color: #2a2c2c; font-size: 0.9em;"><?= htmlspecialchars($character['name']) ?></span>
                                                    </label>
                                                <?php endforeach; ?>
                                            </div>

                                            <button type="submit" class="link btn-page" style="padding: 10px 30px; font-size: 1.1em; cursor: pointer;">Valider mon choix</button>
                                        </form>
                                    <?php endif; ?>
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