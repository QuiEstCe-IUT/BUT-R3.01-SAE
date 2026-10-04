<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">

        <link rel="stylesheet" href="assets/styles/_default.css">
        <link rel="stylesheet" href="assets/styles/_navigation.css">
        <link rel="stylesheet" href="assets/styles/mapViewStyle.css">
        <?php start_page(); ?>
    </head>
    <body>
        <div id="main-container">
            <header>
                <?php navigation(); ?>
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
                    <?php end_page(); ?>
                </footer>
            </div>
        </div>
    </body>
</html>