<?php
namespace src\views;

/**
 * View for the map page.
 */
class MapView {
    /**
     * Display the view of the map page.
     *
     * @return void
     */
    public function show($pages) {
        $path = 'src\\views\\_layout';
        $layout = new $path();
        ?>
        <!DOCTYPE html>
        <html lang="fr">
            <head>
                <meta charset="UTF-8">
        
                <link rel="stylesheet" href="assets/styles/_default.min.css">
                <link rel="stylesheet" href="assets/styles/_navigation.min.css">
                <link rel="stylesheet" href="assets/styles/mapViewStyle.css">
                <?php $layout->start_page(); ?>
            </head>
            <body>
                <div id="main-container">
                    <header>
                        <?php $layout->navigation(); ?>
                    </header>
        
                    <div id="right-container">
                        <main>
                            <section class="sitemap-container">
                                <h2>Plan du site</h2>
                                <p>Retrouvez ci-dessous l'ensemble des pages accessibles sur notre site :</p>
        
                                <ul class="sitemap-list">
                                <?php foreach ($pages as $page): ?>
                                    <li>
                                        <a href="<?= $page['url'] ?>"><?= $page['title'] ?></a>
                                    </li>
                                <?php endforeach; ?>
                                </ul>
                            </section>
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