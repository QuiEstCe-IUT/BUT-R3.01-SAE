<?php

namespace src\models;

use core\Model;

/**
 * Model for handling all user related data
 */
class UserModel extends Model {
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

    /**
     * Récupère un utilisateur par son email.
     * Retourne un tableau login, hash_password, etc.) ou false si non trouvé.
     *
     * @param string $email L'email de l'utilisateur
     * @return array ou false
     */
    public static function getUserByEmail(string $email): array|false {
        $sql = "SELECT user_id, login, email, hash_password FROM users WHERE email = :email";
        $stmt = self::getPdo()->prepare($sql);
        $stmt->execute([':email' => $email]);

        return $stmt->fetch(); // retourne false si aucun résultat (FETCH_ASSOC par défaut)
    }

    /**
     * Enregistre un nouvelle utilisateur
     *
     * @param string $login Le login
     * @param string $firstName Le prenom
     * @param string $lastName Le nom de famille
     * @param string $email L'email
     * @param string $hashPassword Le mot de passe haché
     * @param string $phoneNumber Le numéro de telephone
     * @param string $adress L'adresse
     */
    public static function register(
        string $login,
        string $firstName,
        string $lastName,
        string $email,
        string $hashPassword,
        ?string $phoneNumber,
        string $adress): bool {

        // préparer la requete SQL pour inserer les données dans la table users
        $sql = "INSERT INTO users (login, first_name, last_name, email, hash_password, phone_number, adress)
                VALUES (:login, :first_name, :last_name, :email, :hash_password, :phone_number, :adress)";

        // Préparer la requête SQL
        $stmt = self::getPdo()->prepare($sql);

        // Exécuter la requête avec les paramètres de la fonction
        return $stmt->execute([
            ':login'         => $login,
            ':first_name'    => $firstName,
            ':last_name'     => $lastName,
            ':email'         => $email,
            ':hash_password' => $hashPassword,
            ':phone_number'  => $phoneNumber,
            ':adress'        => $adress,
        ]);
    }

    /**
     * Retourne si l'email existe
     *
     * @param string $email L'email à vérifier
     */
    public static function emailExists(string $email): bool {
        $sql = "SELECT COUNT(*) FROM users WHERE email = :email";
        $stmt = self::getPdo()->prepare($sql);
        $stmt->execute([':email' => $email]);

        // fetchColumn() récupère le résultat du COUNT(*) si plus de 1 renvoie true sinon false
        return (int) $stmt->fetchColumn() > 0;
    }

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