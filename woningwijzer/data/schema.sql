-- ============================================================
-- Database schema voor WoningWijzer
-- ============================================================
-- Dit script maakt de database en alle tabellen aan.
-- Uitvoeren via: mysql -u root < woningwijzer/data/schema.sql
-- ============================================================

CREATE DATABASE IF NOT EXISTS woningwijzer
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE woningwijzer;

-- Woningen
CREATE TABLE IF NOT EXISTS woningen (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Meldingen
CREATE TABLE IF NOT EXISTS meldingen (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(50) NOT NULL,
    omschrijving TEXT NOT NULL,
    status VARCHAR(50) DEFAULT 'Open',
    aangemaakt_op DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Nieuwsbrief aanmeldingen
CREATE TABLE IF NOT EXISTS nieuwsbrieven (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    aangemaakt_op DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Petities
CREATE TABLE IF NOT EXISTS petities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    naam VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    aangemaakt_op DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Voorbeelddata
INSERT INTO woningen (type, stad, categorie, prijs, kamers, oppervlak, omschrijving, lat, lng) VALUES
('appartement', 'amsterdam', 'vrij', 1650, 2, 58, 'Licht appartement in de Jordaan met balkon.', 52.368, 4.885),
('woning',      'rotterdam', 'koop', 285000, 4, 102, 'Ruime rijtjeswoning met tuin in Kralingen.', 51.927, 4.505),
('studio',      'utrecht', 'vrij', 1100, 1, 32, 'Moderne studio nabij Centraal Station.', 52.090, 5.117),
('appartement', 'denhaag', 'sociaal', 760, 3, 75, 'Sociale huurwoning, inschrijftijd vereist.', 52.072, 4.306),
('kamer',       'groningen', 'vrij', 620, 1, 18, 'Gemeubileerde kamer in studentenhuis centrum.', 53.220, 6.565),
('woning',      'eindhoven', 'koop', 340000, 5, 130, 'Vrijstaande woning met garage en grote tuin.', 51.442, 5.469),
('appartement', 'amsterdam', 'koop', 425000, 2, 64, 'Instapklaar appartement in De Pijp.', 52.354, 4.893),
('studio',      'rotterdam', 'vrij', 950, 1, 28, 'Gezellige studio met uitzicht op de Maas.', 51.907, 4.487);

INSERT INTO meldingen (type, omschrijving, status) VALUES
('discriminatie', 'Huisbazin weigert huurders met migratieachtergrond.', 'In behandeling'),
('illegale praktijken', 'Verhuurder vraagt sleutelgeld van € 2.000 voor sociale huurwoning.', 'Gemeld bij Huurcommissie'),
('onderhoud', 'Schimmel in slaapkamer al 8 maanden niet verholpen door verhuurder.', 'Open'),
('huurverhoging', 'Huurverhoging van 12% ontvangen, terwijl maximum 5,8% is.', 'Afgehandeld');
