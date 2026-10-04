<?php
/**
 * Autoloader configuration.
 *
 * Automatically loads PHP classes from the src/ directory based on their namespace.
 */

// On enregistre une fonction anonyme
spl_autoload_register(function ($class) {

    // 1. On retire le préfixe "src\"
    $relativeClass = str_replace('src\\', '', $class);
    // $relativeClass devient : "Controllers\AccueilController"

    // 2. On construit le chemin absolu vers le dossier src/
    // __DIR__ représente le dossier où se trouve l'autoloader ( core/includes/)
    $file = __DIR__ . '/../../src/' . str_replace('\\', '/', $relativeClass) . '.php';
    // $file devient : /chemin/vers/projet/src/Controllers/AccueilController.php

    // 3. Si le fichier existe, on l'inclut
    if (file_exists($file)) {
        require_once $file;
    }
});