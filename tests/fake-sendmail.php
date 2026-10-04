<?php

// commande de test :php -d sendmail_path="php tests/fake-sendmail.php" -S localhost:8000 -t public/

// Script pour intercepter les emails en développement local
$input = file_get_contents('php://stdin');

// On ajoute l'email intercepté dans un fichier à la racine du projet
$logFile = __DIR__ . '/../emails_envoyes.txt';
$logEntry = "================= NOUVEL EMAIL INTERCEPTÉ =================\n";
$logEntry .= "Date : " . date('Y-m-d H:i:s') . "\n";
$logEntry .= "-----------------------------------------------------------\n";
$logEntry .= $input . "\n\n";

file_put_contents($logFile, $logEntry, FILE_APPEND);
