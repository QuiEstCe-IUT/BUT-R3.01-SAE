<?php
namespace src\views\user\board;

use src\views\_Layout;

class BoardView
{
    public function show(array $characters): void
    {
        $layout = new _Layout();
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <link rel="stylesheet" href="/assets/styles/boardViewStyle.css">
            <?php $layout->start_page(); ?>
        </head>
        <body>
            <div id="main-container">
                <header><?php $layout->navigation(); ?></header>
                <div id="right-container">
                    <main>
                        <h1>Qui est-ce ?</h1>
                        <section class="board">
                            <?php foreach ($characters as $character): ?>
                                <article class="card<?= !empty($character['eliminated']) ? ' eliminated' : '' ?>">
                                    <img
                                        src="<?= htmlspecialchars($character['image'], ENT_QUOTES, 'UTF-8') ?>"
                                        alt="<?= htmlspecialchars($character['name'], ENT_QUOTES, 'UTF-8') ?>"
                                    >
                                    <h2><?= htmlspecialchars($character['name'], ENT_QUOTES, 'UTF-8') ?></h2>
                                </article>
                            <?php endforeach; ?>
                        </section>
                    </main>
                    <footer><?php $layout->end_page(); ?></footer>
                </div>
            </div>
        </body>
        </html>
        <?php
    }
}