<?php
namespace src\views;

/**
 * View for the legal notice page.
 */
class LegalNoticeView {
    /**
     * Display the view of the legal notice page.
     *
     * @return void
     */
    public function show(
        $companyName,
            $address,
            $contactEmail,
            $hostName,
            $hostAddress) {
        ?>
        <!DOCTYPE html>
        <html lang="fr">
            <head>
                <meta charset="UTF-8">

                <link rel="stylesheet" href="assets/styles/_default.min.css">
                <link rel="stylesheet" href="assets/styles/_navigation.min.css">
                <link rel="stylesheet" href="assets/styles/legalNoticeViewStyle.css">
                <?php start_page(); ?>
            </head>
            <body>
                <div id="main-container">
                    <header>
                        <?php navigation(); ?>
                    </header>

                    <div id="right-container">
                        <main>
                            <section class="legal-container">
                                <h2>Mentions légales</h2>

                                <article>
                                    <h3>1. Éditeur du site</h3>
                                    <p><strong>Raison sociale / Nom :</strong> <?= $companyName ?></p>
                                    <p><strong>Adresse :</strong> <?= $address ?></p>
                                    <p><strong>Email :</strong> <?= $contactEmail ?></p>
                                </article>

                                <article>
                                    <h3>2. Hébergement</h3>
                                    <p><strong>Hébergeur :</strong> <?= $hostName ?></p>
                                    <p><strong>Adresse de l'hébergeur :</strong> <?= $hostAddress ?></p>
                                </article>

                                <article>
                                    <h3>3. Propriété intellectuelle</h3>
                                    <p>L'ensemble de ce site relève de la législation française et internationale sur le droit d'auteur et la propriété intellectuelle. Tous les droits de reproduction sont réservés.</p>
                                </article>

                                <article>
                                    <h3>4. Protection des données personnelles</h3>
                                    <p>Conformément au Règlement Général sur la Protection des Données (RGPD), vous disposez d'un droit d'accès, de rectification et de suppression des données vous concernant.</p>
                                </article>
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