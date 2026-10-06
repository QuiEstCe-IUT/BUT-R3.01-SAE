<?php
namespace src\controllers;

require_once __DIR__ . '/../models/articleModel.php';

class ArticleController {

    public function execute(): void {
        // Nombre d'articles par page
        $limit = 5;

        // recupérer la page actuelle depuis l'URL 
        $currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 1;
        if ($currentPage < 1) {
            $currentPage = 1;
        }

        // Récupérer le nombre total d'articles pour calculer le nombre de pages
        $totalArticles = \ArticleModel::getTotalArticles();
        $totalPages = ceil($totalArticles / $limit);

        // Si la page demandée est supérieure au total, on la remet au max
        if ($currentPage > $totalPages && $totalPages > 0) {
            $currentPage = $totalPages;
        }

        // calcul de l'offset
        $offset = ($currentPage - 1) * $limit;
        
        
        if ($offset < 0) {
            $offset = 0;
        }

        // Récupérer les articles paginés
        $articles = \ArticleModel::getPaginatedArticles($limit, $offset);

        // On inclut la vue qui utilisera $articles, $currentPage et $totalPages
        require_once __DIR__ . '/../views/articleView.php';
    }
}
