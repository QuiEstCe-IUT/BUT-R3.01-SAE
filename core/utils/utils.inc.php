<?php
/**
 * Utility functions for generating common HTML elements.
 */

/**
 * Generates the start of an HTML page, including meta tags and title.
 *
 * @return void
 */
function start_page(): void {
    echo '<link rel="icon" type="image/x-icon" href="favicon.ico">';
    echo '<title>Qui est-ce?</title>';
    
    // prefixe meta description)
    echo '<meta name="description" content="Jeu en ligne Qui est-ce? - Devinez le personnage mystère de votre adversaire.">';

    // Open Graph (Facebook, Discord, LinkedIn, etc.)
    echo '<meta property="og:title" content="Qui est-ce?">';
    echo '<meta property="og:description" content="Jeu en ligne Qui est-ce? - Devinez le personnage mystère de votre adversaire.">';
    echo '<meta property="og:type" content="website">';
    echo '<meta property="og:image" content="favicon.ico">';

    // Twitter Card
    echo '<meta name="twitter:card" content="summary">';
    echo '<meta name="twitter:title" content="Qui est-ce?">';
    echo '<meta name="twitter:description" content="Jeu en ligne Qui est-ce? - Devinez le personnage mystère de votre adversaire.">';
}

/**
 * Generates the end of an HTML page, including footer information.
 *
 * @return void
 */
function end_page(): void {
    echo <<<HTML
    <p>&copy; <?= date('Y') ?> - Tous droits réservés.</p>
    <p>Fin de page ici</p>
    HTML;
}

/**
 * Generates the main navigation menu for the website.
 *
 * @return void
 */
function navigation(): void {
    echo <<<HTML
        <nav id="navigation">
            <a class="link-cont" href="index.php?page=home">
                <svg class="m-icon" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M240-200h120v-240h240v240h120v-360L480-740 240-560v360Zm-80 80v-480l320-240 320 240v480H520v-240h-80v240H160Zm320-350Z"/></svg>
                <p class="desc">Home</p>
            </a>
            <a class="link-cont" href="index.php?page=login">
                <svg class="m-icon" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M234-276q51-39 114-61.5T480-360q69 0 132 22.5T726-276q35-41 54.5-93T800-480q0-133-93.5-226.5T480-800q-133 0-226.5 93.5T160-480q0 59 19.5 111t54.5 93Zm146.5-204.5Q340-521 340-580t40.5-99.5Q421-720 480-720t99.5 40.5Q620-639 620-580t-40.5 99.5Q539-440 480-440t-99.5-40.5ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm100-95.5q47-15.5 86-44.5-39-29-86-44.5T480-280q-53 0-100 15.5T294-220q39 29 86 44.5T480-160q53 0 100-15.5ZM523-537q17-17 17-43t-17-43q-17-17-43-17t-43 17q-17 17-17 43t17 43q17 17 43 17t43-17Zm-43-43Zm0 360Z"/></svg>
                <p class="desc">Profil</p>
            </a>
            <a class="link-cont" href="index.php?page=signUp">
                <svg class="m-icon" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h167q11-35 43-57.5t70-22.5q40 0 71.5 22.5T594-840h166q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560h-80v120H280v-120h-80v560Zm308.5-571.5Q520-783 520-800t-11.5-28.5Q497-840 480-840t-28.5 11.5Q440-817 440-800t11.5 28.5Q463-760 480-760t28.5-11.5Z"/></svg>
                <p class="desc">Sign up</p>
            </a>
            <a class="link-cont" href="index.php?page=forgottenPwd">
                <svg class="m-icon" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480h80q0 66 25 124.5t68.5 102q43.5 43.5 102 69T480-159q134 0 227-93t93-227q0-134-93-227t-227-93q-89 0-161.5 43.5T204-640h116v80H80v-240h80v80q55-73 138-116.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm-80-240q-17 0-28.5-11.5T360-360v-120q0-17 11.5-28.5T400-520v-40q0-33 23.5-56.5T480-640q33 0 56.5 23.5T560-560v40q17 0 28.5 11.5T600-480v120q0 17-11.5 28.5T560-320H400Zm40-200h80v-40q0-17-11.5-28.5T480-600q-17 0-28.5 11.5T440-560v40Z"/></svg>
                <p class="desc">Reset</p>
            </a>
            <a class="link-cont" href="index.php?page=article">
                <svg class="m-icon" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm80-80h400v-80H280v80Zm0-160h400v-80H280v80Zm0-160h400v-80H280v80ZM200-200v-560 560Z"/></svg>
                <p class="desc">Articles</p>
            </a>
            <a class="link-cont" href="index.php?page=legalNotice">
                <svg class="m-icon" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f"><path d="M160-120v-80h480v80H160Zm226-194L160-540l84-86 228 226-86 86Zm254-254L414-796l86-84 226 226-86 86Zm184 408L302-682l56-56 522 522-56 56Z"/></svg>
                <p class="desc">Legal notice</p>
            </a>
            <a class="link-cont" href="index.php?page=map">
                <svg class="m-icon" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f"><path d="m600-120-240-84-186 72q-20 8-37-4.5T120-170v-560q0-13 7.5-23t20.5-15l212-72 240 84 186-72q20-8 37 4.5t17 33.5v560q0 13-7.5 23T812-192l-212 72Zm-40-98v-468l-160-56v468l160 56Zm80 0 120-40v-474l-120 46v468Zm-440-10 120-46v-468l-120 40v474Zm440-458v468-468Zm-320-56v468-468Z"/></svg>
                <p class="desc">Website map</p>
            </a>
            <!--
            <div class="link-cont"><a class="nav-link" href="index.php?page=home">Accueil</a></div>
            <div class="link-cont"><a class="nav-link" href="index.php?page=login">Authentification</a></div>
            <div class="link-cont"><a class="nav-link" href="index.php?page=signUp">Inscription</a></div>
            <div class="link-cont"><a class="nav-link" href="index.php?page=forgottenPwd">Mot de passe oublié</a></div>
            -->
        </nav>
    HTML;
}

