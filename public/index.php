<?php
// Ce script est le "routeur central", il connecte les scripts entre eux.
session_start();

require_once __DIR__ . '/../core/autoloader.php';

// On récupère l'url + Si l'url n'existe pas on met une chaine vide
$url = $_SERVER['REQUEST_URI'] ?? '';

// On enlève la partie GET de l'url
$url = parse_url($url, PHP_URL_PATH);

$url = trim($url, '/'); // On enlève les / en trop au début ou fin
if (empty($url)) {
    $url = 'home'; // Si l'url est vide on renvoie vers la page d'accueil
}

$params = explode('/', $url); // On sépare les paramètres par le /
$controllerName = $params[0] ?? 'home'; // On récupère le nom du controller (sinon on met home)
$action = $params[1] ?? 'execute'; // On récupère l'action

// On s'assure que le controller existe
if (file_exists(__DIR__ . '/../src/controllers/' . $controllerName . 'Controller.php')) {

    // On instancie la classe
    $path = 'src\\controllers\\' . $controllerName . 'Controller';
    $controller = new $path();

    // On appelle la bonne méthode
    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        // On retourne l'erreur
        http_response_code(404);
        echo "Erreur 404.";
    }
} else {
    // On retourne l'erreur
    http_response_code(404);
    echo "Erreur 404.";
}