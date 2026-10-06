<?php

require_once __DIR__ . '/../../core/model.php';

/**
 * Model for handling forgotten password tokens and updates.
 */
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

    /**
     * Sauvegarde un token de réinitialisation associé à un email.
     * Si un token existe déjà pour cet email, il est remplacé.
     *
     * @param string $token Le token généré
     * @param string $email L'email de l'utilisateur
     * @return bool true si l'insertion a réussi
     */
    public static function saveToken(string $token, string $email): bool {
        // On supprime un éventuel ancien token pour cet email
        $sqlDelete = "DELETE FROM password_resets WHERE email = :email";
        $stmtDelete = self::getPdo()->prepare($sqlDelete);
        $stmtDelete->execute([':email' => $email]);

        // On insère le nouveau token
        $sql = "INSERT INTO password_resets (token, email, created_at) VALUES (:token, :email, NOW())";
        $stmt = self::getPdo()->prepare($sql);

        return $stmt->execute([
            ':token' => $token,
            ':email' => $email,
        ]);
    }

    /**
     * Récupère l'email associé à un token de réinitialisation.
     * Vérifie aussi que le token n'a pas expiré (valide 1 heure).
     *
     * @param string $token Le token à vérifier
     * @return string|false L'email associé au token, ou false si invalide/expiré
     */
    public static function getEmailByToken(string $token): string|false {
        $sql = "SELECT email FROM password_resets WHERE token = :token AND created_at > NOW() - INTERVAL '1 hour'";
        $stmt = self::getPdo()->prepare($sql);
        $stmt->execute([':token' => $token]);

        $result = $stmt->fetch();
        return $result ? $result['email'] : false;
    }

    /**
     * Supprime un token après utilisation.
     *
     * @param string $token Le token à supprimer
     * @return bool true si la suppression a réussi
     */
    public static function deleteToken(string $token): bool {
        $sql = "DELETE FROM password_resets WHERE token = :token";
        $stmt = self::getPdo()->prepare($sql);

        return $stmt->execute([':token' => $token]);
    }
}
