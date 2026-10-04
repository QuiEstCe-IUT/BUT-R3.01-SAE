<?php

require_once __DIR__ . '/../../core/model.php';

class LoginModel extends Model
{

    /**
     * Récupère un utilisateur par son email.
     * Retourne un tableau login, hash_password, etc.) ou false si non trouvé.
     *
     * @param string $email L'email de l'utilisateur
     * @return array ou false
        */

    public static function getUserByEmail(string $email): array|false
    {
        $sql = "SELECT user_id, login, email, hash_password FROM users WHERE email = :email";
        $stmt = self::getPdo()->prepare($sql);
        $stmt->execute([':email' => $email]);

        return $stmt->fetch(); // retourne false si aucun résultat (FETCH_ASSOC par défaut)
    }
}
