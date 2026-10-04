<?php

require_once __DIR__ . '/../../core/model.php';

class SignUpModel extends Model {
    // Héritage de la classe paret du super model noyau



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


    public static function emailExists(string $email): bool {
        $sql = "SELECT COUNT(*) FROM users WHERE email = :email";
        $stmt = self::getPdo()->prepare($sql);
        $stmt->execute([':email' => $email]);

        // fetchColumn() récupère le résultat du COUNT(*) si plus de 1 renvoie true sinon false
        return (int) $stmt->fetchColumn() > 0;
    }


}
        
        
