<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../core/model.php';
require_once __DIR__ . '/../src/models/authentificationModel.php';
require_once __DIR__ . '/../src/models/signUpModel.php';

try {
    Model::checkConnection();
    echo "Connexion réussie via Model\n";

    AuthentificationModel::checkConnection();
    echo "Connexion réussie via AuthentificationModel\n";

    signUpModel::checkConnection();
    echo "Connexion réussie via signUpModel\n";
} catch (PDOException $e) {
    echo "Échec de connexion : " . $e->getMessage();
}