<?php

namespace src\views\board;

/**
 * View for the lobby page.
 */
class LobbyView {
    /**
     * Display the view of the lobby page.
     *
     * @param array $rooms List of available rooms
     * @param array|null $currentRoom Details of the room the user is currently waiting in (if any)
     * @return void
     */
    public function show($rooms, ?array $currentRoom = null) {
        $path = 'src\\views\\_layout';
        $layout = new $path();

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
                <div id="main-container">
                    <header>
                        <?php $layout->navigation(); ?>
                    </header>

                    <div id="right-container">
                        <main>
                            <div class="cont">
                                <h1>Qui est-ce ? - Salons</h1>
                                <p style="margin:5px 0 20px 0; color:var(--color_link);">Rejoignez un salon ou créez une partie pour deviner le personnage mystère !</p>

                                <?php if ($currentRoom): ?>
                                    <!--  En attente d'un adversaire dans sa propre partie -->
                                    <div class="form_bg" style="max-width: 600px; margin: 0 auto; padding: 30px; text-align: center;">
                                        <h3 style="margin-top:0; color:#2a2c2c;">Salon : <?= htmlspecialchars($currentRoom['name']) ?></h3>
                                        <p style="font-size: 1.1em; color: var(--color_link); margin: 20px 0;">
                                            En attente d'un adversaire...
                                        </p>
                                        <p style="font-size: 0.9em; color: #666; margin-bottom: 25px;">
                                            Patientez pendant qu'un joueur rejoint votre salon.
                                        </p>
                                        
                                        <!-- Bouton pour quitter / annuler la partie -->
                                        <form action="/board/lobby?action=leave_room" method="POST">
                                            <input type="hidden" name="room_id" value="<?= htmlspecialchars($currentRoom['id']) ?>">
                                            <button type="submit" class="link btn-page" style="background-color: #d9534f; color: white; padding: 10px 25px; border: none; cursor: pointer;">
                                                Quitter la partie
                                            </button>
                                        </form>
                                    </div>

                                <?php else: ?>
                                    <!-- Création de salon avec la liste des salons disponibles  -->
                                    <div class="lobby-grid" style="display: flex; gap: 20px; flex-wrap: wrap;">
                                        <!-- Formulaire de création de salon -->
                                        <div class="form_bg" style="padding: 20px; flex: 1; min-width: 280px;">
                                            <h3 style="margin:0 0 15px 0; color:#2a2c2c;">Créer un salon</h3>
                                            <form action="/board/lobby?action=create_room" method="POST">
                                                <div style="margin-bottom: 15px;">
                                                    <label for="room_name" style="display:block; margin-bottom:5px; font-size:0.9em;">Nom de la partie</label>
                                                    <input type="text" id="room_name" name="room_name" placeholder="Ex: Partie entre amis" required style="width: 100%; padding: 8px; box-sizing: border-box;">
                                                </div>
                                                <button type="submit" class="link btn-page" style="width: 100%; cursor: pointer;">Créer et lancer</button>
                                            </form>
                                        </div>

                                        
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
                                                            <a href="/board/lobby?action=join_room&room_id=<?= $room['id'] ?>" class="link btn-page" style="text-decoration: none; padding: 5px 15px;">Rejoindre</a>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

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