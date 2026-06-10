<?php
// ============================================================
// db.php — Databaseverbinding via PDO
// Eerstejaars verantwoordelijkheid: MySQL + PHP koppeling
// Werkt op XAMPP (Linux/Windows) én WAMP.
// ============================================================

// ======================================================================
// DATABASE-INSTELLINGEN — pas aan voor jouw omgeving
// ======================================================================
// Lokaal (XAMPP/WAMP):     host='127.0.0.1:3306', user='root', pass=''
// Centrale server:         host='192.168.x.x:3306', user='...', pass='...'
// ======================================================================
define('DB_HOST', '127.0.0.1:3306');  // of bijv. '192.168.1.100:3306'
define('DB_NAME', 'woningwijzer');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHAR', 'utf8mb4');

// Probeer fallback-combinaties als DB_HOST niet werkt (handig voor XAMPP/WAMP)
$dbHosts = array_unique([
    DB_HOST,
    '127.0.0.1:3306',
    'localhost:3306',
    '127.0.0.1:3307',
    'localhost:3307',
]);

function getDb(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        $pdo = _connectOrCreate();
    }

    return $pdo;
}

/** Eerst verbinden zonder database, daarna database aanmaken + gebruiken */
function _connectOrCreate(): PDO
{
    global $dbHosts;

    $lastError = '';

    foreach ($dbHosts as $hostport) {
        // Stap 1 — verbind met MySQL server (zonder database)
        try {
            $dsn = 'mysql:host=' . $hostport . ';charset=' . DB_CHAR;
            $opties = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $opties);
        } catch (PDOException $e) {
            $lastError = $e->getMessage();
            continue;
        }

        // Stap 2 — database aanmaken als die nog niet bestaat
        $pdo->exec('CREATE DATABASE IF NOT EXISTS `' . DB_NAME . '`
                     CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');

        // Stap 3 — herverbind met de specifieke database
        $dsn = 'mysql:host=' . $hostport . ';dbname=' . DB_NAME . ';charset=' . DB_CHAR;
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $opties);

        // Stap 4 — tabellen aanmaken als ze nog niet bestaan
        _maakTabellen($pdo);

        return $pdo;
    }

    // Geen enkele host/port werkte — toon duidelijke fout
    $msg = '<div style="font-family:sans-serif;max-width:600px;margin:2rem auto;padding:1.5rem;'
         . 'border:2px solid #dc2626;border-radius:12px;background:#fef2f2;color:#991b1b;">'
         . '<h2 style="margin:0 0 .5rem;">Databasefout</h2>'
         . '<p style="margin:0 0 .75rem;">Kan geen verbinding maken met MySQL/MariaDB.</p>'
         . '<hr style="border:none;border-top:1px solid #fca5a5;margin:.75rem 0;">'
         . '<p style="font-weight:bold;margin:0 0 .5rem;">Mogelijke oplossingen:</p>'
         . '<ul style="margin:0 0 .75rem;padding-left:1.25rem;">'
         . '<li>Zorg dat MySQL / MariaDB <strong>aanstaat</strong> (XAMPP: start MySQL, WAMP: groen icoon)</li>'
         . '<li>Controleer of <strong>root</strong> zonder wachtwoord werkt in phpMyAdmin</li>'
         . '<li>Als je een <strong>wachtwoord</strong> hebt, pas <code>DB_PASS</code> aan in <code>includes/db.php</code></li>'
         . '<li>Als MySQL op een andere poort draait, pas <code>DB_HOST</code> aan in <code>includes/db.php</code></li>'
         . '</ul>'
         . '<p style="font-size:0.85em;color:#64748b;margin:0;">Technisch: ' . htmlspecialchars($lastError) . '</p>'
         . '</div>';
    die($msg);
}

/** Maak alle tabellen aan als ze nog niet bestaan */
function _maakTabellen(PDO $pdo): void
{
    $pdo->exec('CREATE TABLE IF NOT EXISTS woningen (
        id INT AUTO_INCREMENT PRIMARY KEY,
        type VARCHAR(50) NOT NULL,
        stad VARCHAR(50) NOT NULL,
        categorie VARCHAR(20) NOT NULL,
        prijs DECIMAL(10,2) NOT NULL,
        kamers INT NOT NULL,
        oppervlak INT NOT NULL,
        omschrijving TEXT,
        lat DECIMAL(10,7),
        lng DECIMAL(10,7),
        aangemaakt_op DATETIME DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

    $pdo->exec('CREATE TABLE IF NOT EXISTS meldingen (
        id INT AUTO_INCREMENT PRIMARY KEY,
        type VARCHAR(50) NOT NULL,
        omschrijving TEXT NOT NULL,
        status VARCHAR(50) DEFAULT \'Open\',
        aangemaakt_op DATETIME DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

    $pdo->exec('CREATE TABLE IF NOT EXISTS nieuwsbrieven (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) NOT NULL UNIQUE,
        aangemaakt_op DATETIME DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

    $pdo->exec('CREATE TABLE IF NOT EXISTS petities (
        id INT AUTO_INCREMENT PRIMARY KEY,
        naam VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        aangemaakt_op DATETIME DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

    // Voorbeelddata alleen toevoegen als de tabel leeg is
    $count = $pdo->query('SELECT COUNT(*) FROM woningen')->fetchColumn();
    if ((int) $count === 0) {
        $pdo->exec("INSERT INTO woningen (type, stad, categorie, prijs, kamers, oppervlak, omschrijving, lat, lng) VALUES
            ('appartement', 'amsterdam', 'vrij', 1650, 2, 58, 'Licht appartement in de Jordaan met balkon.', 52.368, 4.885),
            ('woning',      'rotterdam', 'koop', 285000, 4, 102, 'Ruime rijtjeswoning met tuin in Kralingen.', 51.927, 4.505),
            ('studio',      'utrecht', 'vrij', 1100, 1, 32, 'Moderne studio nabij Centraal Station.', 52.090, 5.117),
            ('appartement', 'denhaag', 'sociaal', 760, 3, 75, 'Sociale huurwoning, inschrijftijd vereist.', 52.072, 4.306),
            ('kamer',       'groningen', 'vrij', 620, 1, 18, 'Gemeubileerde kamer in studentenhuis centrum.', 53.220, 6.565),
            ('woning',      'eindhoven', 'koop', 340000, 5, 130, 'Vrijstaande woning met garage en grote tuin.', 51.442, 5.469),
            ('appartement', 'amsterdam', 'koop', 425000, 2, 64, 'Instapklaar appartement in De Pijp.', 52.354, 4.893),
            ('studio',      'rotterdam', 'vrij', 950, 1, 28, 'Gezellige studio met uitzicht op de Maas.', 51.907, 4.487)
        ");
        $pdo->exec("INSERT INTO meldingen (type, omschrijving, status) VALUES
            ('discriminatie', 'Huisbazin weigert huurders met migratieachtergrond.', 'In behandeling'),
            ('illegale praktijken', 'Verhuurder vraagt sleutelgeld van € 2.000 voor sociale huurwoning.', 'Gemeld bij Huurcommissie'),
            ('onderhoud', 'Schimmel in slaapkamer al 8 maanden niet verholpen door verhuurder.', 'Open'),
            ('huurverhoging', 'Huurverhoging van 12% ontvangen, terwijl maximum 5,8% is.', 'Afgehandeld')
        ");
    }
}
