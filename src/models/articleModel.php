<?php

require_once __DIR__ . '/../../core/model.php';

class ArticleModel extends Model {

    /**
     * Récupère le nombre total d'articles.
     *
     * @return int Le nombre total d'articles.
     */
    public static function getTotalArticles(): int {
        $sql = "SELECT COUNT(*) as total FROM articles";
        $stmt = self::getPdo()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        return (int) $result['total'];
    }

    /**
     * Récupère les articles pour une page donnée avec LIMIT et OFFSET.
     *
     * @param int $limit Le nombre d'articles max à récupérer.
     * @param int $offset Le nombre d'articles à ignorer (pour la pagination).
     * @return array La liste des articles.
     */
    public static function getPaginatedArticles(int $limit, int $offset): array {
        $sql = "SELECT id, title, created_at FROM articles ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
        $stmt = self::getPdo()->prepare($sql);
        // On utilise bindValue pour s'assurer que limit et offset sont bien considérés comme des entiers
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
