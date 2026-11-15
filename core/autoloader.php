<?php
/**
 * Autoloader configuration.
 *
 * Automatically loads PHP classes from the src/ and core/ directories based on their namespace.
 */

// Enregistre l'autoloader des classes du projet.
spl_autoload_register(function ($class) {
    $namespacePrefixes = [
        'src\\' => __DIR__ . '/../src',
        'core\\' => __DIR__,
    ];

    foreach ($namespacePrefixes as $namespacePrefix => $baseDirectory) {
        if (str_starts_with($class, $namespacePrefix)) {
            $relativeClass = substr($class, strlen($namespacePrefix));
            $file = $baseDirectory . '/' . str_replace('\\', '/', $relativeClass) . '.php';

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

            return;
        }
    }
});