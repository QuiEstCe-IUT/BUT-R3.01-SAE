<?php

namespace src\views;

use src\views\_Layout;

/**
 * View for the lobby page.
 */
class LobbyView {
    public function show($rooms, $currentRoom = null) {
        $layout = new _Layout();
        $rooms = $rooms ?? [];
        ?>
        <!DOCTYPE html>
        <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <link rel="stylesheet" href="assets/styles/LobbyView.css">
                <?php $layout->start_page(); ?>
                <title>Qui est-ce ? - Salons</title>
            </head>
            <body>
                <main style="padding: 20px; text-align: center;">
                    <h1>Salons de jeu</h1>
                    <p style="color: var(--color_link); margin-bottom: 20px;">Rejoignez un salon ou créez-en un pour commencer.</p>

                    <div style="display: flex; justify-content: center; gap: 30px; flex-wrap: wrap; max-width: 900px; margin: 0 auto;">

                        
                        <!-- Créer un salon -->
                        <div style="background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 6px; flex: 1; min-width: 280px;">
                            <h3>Créer un salon</h3>
                            <form action="/lobby?action=create_room" method="POST">
                                <input type="text" name="room_name" placeholder="Nom de la partie" required style="width: 100%; padding: 8px; margin-bottom: 10px; box-sizing: border-box;">
                                <button type="submit" style="width: 100%; padding: 8px; cursor: pointer;">Créer</button>
                            </form>
                        </div>
                        

                        <!-- Liste des salons -->
                        <div style="background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 6px; flex: 2; min-width: 300px;">
                            <h3>Salons disponibles</h3>
                            <?php if (empty($rooms)): ?>
                                <p>Aucun salon disponible.</p>
                            <?php else: ?>
                                <div style="display: flex; flex-direction: column; gap: 10px;">
                                    <?php foreach ($rooms as $room): ?>
                                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px; border: 1px solid #eee; border-radius: 4px;">
                                            <span><?= htmlspecialchars($room['name'] ?? 'Partie #' . $room['gid']) ?></span>
                                            <a href="/lobby?action=join_room&room_id=<?= $room['gid'] ?>" style="padding: 5px 10px; background: #2a2c2c; color: #fff; text-decoration: none; border-radius: 4px;">Rejoindre</a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
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
