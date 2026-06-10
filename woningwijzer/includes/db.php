<?php
// ============================================================
// db.php — Databaseverbinding via PDO
// Eerstejaars verantwoordelijkheid: MySQL + PHP koppeling
// ============================================================

// Instellingen — pas aan naar je lokale omgeving (bijv. XAMPP/Laragon)
define('DB_HOST', 'localhost');
define('DB_NAME', 'woningwijzer');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHAR', 'utf8mb4');

// PDO verbinding opzetten
function getDb(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHAR;

        $opties = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $opties);
        } catch (PDOException $e) {
            // Toon geen technische foutmelding aan gebruiker
            die('<p class="text-red-600 p-4">Databasefout: kan geen verbinding maken. Controleer de instellingen in db.php.</p>');
        }
    }

    return $pdo;
}
