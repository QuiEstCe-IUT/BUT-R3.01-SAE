<?php
// Ce script est le "routeur central", il connecte les scripts entre eux.
session_start();

require_once __DIR__ . '/../core/utils/utils.inc.php';
require_once __DIR__ . '/../core/includes/autoloader.php';

$page = 'home'; // Page par défaut


// On récupère les infos 
if (array_key_exists('page', $_GET)) {
    $page = $_GET['page'];
}

// Détection de la session fermée
if (!isset($_SESSION['uid'])) {
    // $page = 'login'; // TODO: seulement rediriger vers auth si on était sur une page connecté
}



// On redirige vers le bon controller

if (file_exists(__DIR__ . '/../src/controllers/' . $page . 'Controller.php')) {

    $path = 'src\\controllers\\' . $page . 'Controller';
    $controller = new $path();
    $controller->execute();

} else {
    // Si la page n'existe pas on redirige vers l'accueil
    $path = 'src\\controllers\\homeController';
    $controller = new $path();
    $controller->execute();
}
