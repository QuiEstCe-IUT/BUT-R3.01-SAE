<?php
/**
 * Autoloader configuration.
 *
 * Automatically loads PHP classes from the src/ directory based on their namespace.
 */

// Enregistre l'autoloader des classes du projet.
spl_autoload_register(function ($class) {
    $namespacePrefix = 'src\\';
    if (!str_starts_with($class, $namespacePrefix)) {
        return;
    }

    $relativeClass = substr($class, strlen($namespacePrefix));
    $file = __DIR__ . '/../src/' . str_replace('\\', '/', $relativeClass) . '.php';

    if (!is_file($file)) {
        $directory = dirname($file);
        $filename = basename($file);

        if (!is_dir($directory)) {
            return;
        }

        foreach (scandir($directory) as $entry) {
            if (strcasecmp($entry, $filename) === 0) {
                $file = $directory . '/' . $entry;
                break;
            }
        }
    }

    if (is_file($file)) {
        require_once $file;
    }
});