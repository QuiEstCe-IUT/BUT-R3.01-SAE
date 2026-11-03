<?php

namespace src\views;

use src\views\_Layout;

/**
 * View for the lobby page.
 */
class LobbyView {
    /**
     * Display the view of the lobby page.
     *
     * @param array $rooms List of available rooms
     * @return void
     */
    public function show($rooms) {
        $layout = new _Layout();
        ?>
        <!DOCTYPE html>
        <html lang="fr">
            <head>
                <meta charset="UTF-8">

                <link rel="stylesheet" href="assets/styles/_default.min.css">
                <link rel="stylesheet" href="assets/styles/_navigation.min.css">
                <link rel="stylesheet" href="assets/styles/lobbyStyle.min.css">
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
                                <h1>🔍 Qui est-ce ? - Salons</h1>
                                <p style="margin:5px 0 20px 0; color:var(--color_link);">Rejoignez un salon ou créez une partie pour deviner le personnage mystère !</p>

                                <div class="lobby-grid" style="display: flex; gap: 20px; flex-wrap: wrap;">
                                    <!-- Formulaire de création de salon -->
                                    <div class="form_bg" style="padding: 20px; flex: 1; min-width: 280px;">
                                        <h3 style="margin:0 0 15px 0; color:#2a2c2c;">Créer un salon</h3>
                                        <form action="index.php?action=lobby" method="POST">
                                            <div style="margin-bottom: 15px;">
                                                <label for="room_name" style="display:block; margin-bottom:5px; font-size:0.9em;">Nom de la partie</label>
                                                <input type="text" id="room_name" name="room_name" placeholder="Ex: Partie entre amis" required style="width: 100%; padding: 8px; box-sizing: border-box;">
                                            </div>
                                            <button type="submit" class="link btn-page" style="width: 100%; cursor: pointer;">Créer et lancer</button>
                                        </form>
                                    </div>

                                    <!-- Liste des salons disponibles -->
                                    <div class="form_bg" style="padding: 20px; flex: 2; min-width: 300px;">
                                        <h3 style="margin:0 0 15px 0; color:#2a2c2c;">Salons disponibles</h3>
                                        <?php if (empty($rooms)): ?>
                                            <p>Aucun salon disponible pour le moment. Créez-en un pour commencer !</p>
                                        <?php else: ?>
                                            <div class="rooms-list" style="display: flex; flex-direction: column; gap: 10px;">
                                                <?php foreach ($rooms as $room): ?>
                                                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px; background: #fff; border-radius: 4px; border: 1px solid #ddd;">
                                                        <div>
                                                            <h4 style="margin:0; color:#2a2c2c;"><?= htmlspecialchars($room['name']) ?></h4>
                                                            <p style="margin:5px 0 0 0; font-size:0.85em; color:var(--color_link);">Statut : En attente d'un adversaire</p>
                                                        </div>
                                                        <a href="game.php?room_id=<?= $room['id'] ?>" class="link btn-page" style="text-decoration: none; padding: 5px 15px;">Rejoindre</a>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
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

