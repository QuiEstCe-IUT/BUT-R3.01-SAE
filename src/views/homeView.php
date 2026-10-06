<?php
namespace src\views;

/**
 * View for the home page.
 */
class HomeView {
    /**
     * Display the view of the home page.
     *
     * @return void
     */
    public function show() {
        $features = array();
        ?>
        <!DOCTYPE html>
        <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <link rel="stylesheet" href="assets/styles/_default.min.css">
                <link rel="stylesheet" href="assets/styles/_navigation.min.css">
                <link rel="stylesheet" href="assets/styles/homeStyle.min.css">
                <?php start_page(); ?>
            </head>
            <body>
                <div id="main-container">
                    <header>
                        <?php navigation(); ?>
                    </header>
                    <div id="right-container">
                        <main>
                            <h1>Bienvenue sur notre site</h1>
                            <section class="site">
                                <h2>Espace d'accueil</h2>
                                <p>Découvrez notre Site!</p>
                                <div class="site-buttons">
                                </div>
                            </section>
                            <section class="features">
                                <h3>Pourquoi nous rejoindre ?</h3>
                                <div class="cards-container">
                                    <?php foreach ($features as $feature): ?>
                                        <article class="card">
                                            <h4><?= $feature['title'] ?></h4>
                                            <p><?= $feature['description'] ?></p>
                                        </article>
                                    <?php endforeach; ?>
                                </div>
                            </section>
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



