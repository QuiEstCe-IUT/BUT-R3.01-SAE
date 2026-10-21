<?php
/**
 * Autoloader configuration.
 *
 * Automatically loads PHP classes from the src/ directory based on their namespace.
 */

// On enregistre une fonction anonyme
spl_autoload_register(function ($class) {
    // 1. On retire le préfixe "src\" si présent dans le namespace
    $relativeClass = str_replace('src\\', '', $class);

    // 2. On adapte le chemin __DIR__
    // Comme autoloader.php est dans src/core/, 
    // il faut remonter d'un niveau (../) pour atteindre le dossier src/
    $file = __DIR__ . '/../' . str_replace('\\', '/', $relativeClass) . '.php';

    // 3. Si le fichier existe, on l'inclut
    if (file_exists($file)) {
        require_once $file;
    }
});