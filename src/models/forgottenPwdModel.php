<?php

require_once __DIR__ . '/../../core/model.php';

class ForgottenPwdModel extends Model {

    /**
     * Met à jour le mot de passe d'un utilisateur à partir de son email.
     *
     * @param string $email L'email de l'utilisateur
     * @param string $hashPassword Le nouveau mot de passe hashé
     * @return bool true si la mise à jour a réussi
     */
    public static function updatePassword(string $email, string $hashPassword): bool {
        $sql = "UPDATE users SET hash_password = :hash_password WHERE email = :email";
        $stmt = self::getPdo()->prepare($sql);

        return $stmt->execute([
            ':hash_password' => $hashPassword,
            ':email' => $email,
        ]);
    }
}
