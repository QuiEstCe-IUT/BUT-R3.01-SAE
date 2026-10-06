<?php
// test de la classe abstraite pour la connexion a la BD
ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = 'postgresql-mathiasm.alwaysdata.net';
$port = '5432';
$dbname = 'mathiasm_web_bd';
$user = 'mathiasm_bd_web_admin';
$password = '1mdpphp';

$dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

try {
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    
    echo "Connexion réussie ";
} catch (PDOException $e) {
    echo "Échec de connexion : " . $e->getMessage();
}