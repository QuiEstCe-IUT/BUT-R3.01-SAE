<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">

        <link rel="stylesheet" href="assets/styles/_default.min.css">
        <link rel="stylesheet" href="assets/styles/_navigation.min.css">
        <link rel="stylesheet" href="assets/styles/articleStyle.min.css">
        <?php start_page(); ?>
    </head>
    <body>
        <div id="main-container">
            <header>
                <?php navigation(); ?>
            </header>

            <div id="right-container">
                <main>
                    <div class="cont">
                        <h1>Actualités / Articles</h1>
                        
                        <div class="articles-list">
                            <?php if (empty($articles)): ?>
                                <p>Aucun article trouvé.</p>
                            <?php else: ?>
                                <?php foreach ($articles as $article): ?>
                                    <div class="form_bg" style="padding: 10px; width: 90%;">
                                        <h3 style="margin:0; color:#2a2c2c;"><?= htmlspecialchars($article['title']) ?></h3>
                                        <p style="margin:5px 0; font-size:0.9em; color:#577482;">Publié le : <?= htmlspecialchars($article['created_at']) ?></p>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <?php if ($totalPages > 1): ?>
                            <div class="pagination">
                                <?php if ($currentPage > 1): ?>
                                    <a href="index.php?page=article&p=<?= $currentPage - 1 ?>" class="link btn-page">&laquo; Précédent</a>
                                <?php endif; ?>

                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <?php if ($i === $currentPage): ?>
                                        <span class="link btn-page active-page" style="font-weight: bold; color: rgb(42, 44, 44);"><?= $i ?></span>
                                    <?php else: ?>
                                        <a href="index.php?page=article&p=<?= $i ?>" class="link btn-page"><?= $i ?></a>
                                    <?php endif; ?>
                                <?php endfor; ?>

                                <?php if ($currentPage < $totalPages): ?>
                                    <a href="index.php?page=article&p=<?= $currentPage + 1 ?>" class="link btn-page">Suivant &raquo;</a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                    </div>
                </main>
                <footer>
                    <?php end_page(); ?>
                </footer>
            </div>
        </div>
    </body>
</html>
