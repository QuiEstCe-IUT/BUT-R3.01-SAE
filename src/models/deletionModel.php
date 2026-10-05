<?php

require_once __DIR__ . '/../../core/model.php';

class DeletionModel extends Model {

    /**
     * Supprime un utilisateur par son identifiant.
     *
     * @param int $userId L'ID de l'utilisateur
     * @return bool True si supprimé, False sinon
     */
    public static function deleteUserById(int $userId): bool {
        $sql = "DELETE FROM users WHERE user_id = :user_id";
        $stmt = self::getPdo()->prepare($sql);
        return $stmt->execute([':user_id' => $userId]);
    }
}
