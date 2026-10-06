<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../core/model.php';
require_once __DIR__ . '/../src/models/loginModel.php';
require_once __DIR__ . '/../src/models/signUpModel.php';
require_once __DIR__ . '/../src/models/forgottenPwdModel.php';

try {
    Model::checkConnection();
    echo "Connexion réussie via Model\n";

    LoginModel::checkConnection();
    echo "Connexion réussie via LoginModel\n";

    SignUpModel::checkConnection();
    echo "Connexion réussie via SignUpModel\n";

    ForgottenPwdModel::checkConnection();
    echo "Connexion réussie via ForgottenPwdModel\n";

    echo "Toutes les connexions à la base de données fonctionnent parfaitement ! :)\n";
} catch (PDOException $e) {
    echo "Échec de connexion : " . $e->getMessage();
}
