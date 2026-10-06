<?php

/**
 * Abstract base model class.
 *
 * Provides a singleton PDO database connection to be used by all child models.
 */
abstract class Model {
    /**
     * @var PDO|null Holds the singleton PDO instance
     */
    private static ?PDO $pdo = null;

    protected static function getPdo(): PDO {
        if (self::$pdo === null) {
            $config = require __DIR__ . '/../config/database.php';

            $dsn = "pgsql:host={$config['host']};port={$config['port']};dbname={$config['dbname']}";

            try {
                self::$pdo = new PDO($dsn, $config['user'], $config['password'], [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]);
            } catch (PDOException $e) {
                error_log('Erreur de connexion PDO : ' . $e->getMessage());
                throw new RuntimeException('Impossible de se connecter à la base de données.');
            }
        }

        return self::$pdo;
    }

    public static function checkConnection(): bool {
        return (bool) self::getPdo()->query('SELECT 1');
    }
}