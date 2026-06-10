# WoningWijzer — Agent Instructies

## Project
Full-stack PHP woningmarktplatform (eerstejaars, geen framework).
Live data via MySQL, Leaflet-kaarten, CBS/PDOK API's.

## Projectstructuur
```
woningwijzer/
├── index.php                 # Homepage met CBS-statistieken
├── includes/
│   ├── db.php               # Databaseverbinding (PDO)
│   ├── header.php           # HTML head + nav (Tailwind CDN, Leaflet)
│   ├── footer.php           # Footer met dynamische navigatiepaden
│   ├── config.local.example.php  # Voorbeeld per-machine config
│   └── config.local.php      # Per-machine config (gitignored!)
├── pages/
│   ├── zoeken.php           # Woningen doorzoeken + Leaflet-kaart
│   ├── bereken.php          # Rekenmodule (statisch)
│   ├── rechten.php          # Rechten & plichten info
│   ├── woning-toevoegen.php # CREATE formulier + PDOK geocoding
│   ├── woning-bewerken.php  # UPDATE formulier
│   ├── woning-verwijderen.php# DELETE bevestiging
│   ├── woning-detail.php    # Detailpagina met kaart
│   ├── nieuws.php           # Nieuws overzicht (statisch)
│   ├── actie.php            # Petitie, nieuwsbrief, social share
│   ├── meldingen.php        # Meldingen overzicht (DB)
│   └── over-de-crisis.php   # Achtergrondinfo (statisch)
└── data/
    ├── schema.sql           # Alleen voor handmatige reset
    └── cbs_cache.json        # CBS API cache (automatisch gegenereerd)
```

## Database (MariaDB/MySQL)
- **Verbinden**: `includes/db.php` via PDO, TCP `127.0.0.1:3306` / root / geen wachtwoord
- **Auto-setup**: db.php maakt database + tabellen + voorbeelddata automatisch aan
- **4 tabellen**: `woningen`, `meldingen`, `nieuwsbrieven`, `petities`
- **Stijl**: prepared statements overal, `:named` parameters, `fetch()`/`fetchAll()`
- **Per-machine config**: kopieer `config.local.example.php` naar `config.local.php` en pas aan (gitignored)

## Belangrijke conventies
- **PHP zonder framework**, alles in losse `.php` bestanden
- **Navigatiepaden**: variabelen `$root` en `$pagesDir` zorgen dat links werken vanuit root (`/`) én submap (`/woningwijzer/`)
- **Responsive**: Tailwind utility classes, hamburgermenu op mobiel
- **Dark mode**: `darkMode: 'class'` in tailwind.config, togglebtn in nav, localStorage opslag. Voeg `dark:` varianten toe aan alle `bg-white`, `border-gray-100`, `text-gedempt` etc.
- **Formulieren**: validatie aan de bovenkant, fouten in `$fouten[]` array, waarden uit `$_POST` behouden
- **Redirects** (POST-redirect-GET): `header("Location: ...")` + `exit` — altijd vóór enige HTML-output

## Centrale database delen (meerdere gebruikers)
1. Database- PC: `bind-address = 0.0.0.0` in MySQL config, firewall poort 3306 open
2. Database- PC: gebruiker aanmaken `CREATE USER 'root'@'192.168.%' IDENTIFIED BY ''; GRANT ALL ON woningwijzer.* TO 'root'@'192.168.%';`
3. Andere apparaten: kopieer `config.local.example.php` naar `config.local.php` en wijzig `host` naar IP van database-PC

## Dependencies
- **Tailwind CSS**: CDN (`<script src="https://cdn.tailwindcss.com">`)
- **Leaflet**: CDN (`<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">`)
- **Geocoding**: PDOK Locatieserver (gratis, geen key)
- **Statistieken**: CBS Open Data API (gecached in `cbs_cache.json`, 1 uur)
- **Kaarttegels**: OpenStreetMap (gratis, geen key)

## CBS API
- URL: `https://opendata.cbs.nl/ODataApi/odata/85268NED/TypedDataSet`
- Cache: `woningwijzer/data/cbs_cache.json`, 3600 seconden
- Fallback: statische data als API timeout geeft

## PDOK Locatieserver
- URL: `https://geodata.nationaalgeoregister.nl/locatieserver/v3/free?q=...&rows=1`
- Fallback: vaste stadcentrum-coördinaten (amsterdam/rotterdam/utrecht/denhaag/eindhoven/groningen)
- Timeout: 3 seconden

## Stadia-coördinaten (fallback)
```php
$stadCoords = [
    'amsterdam' => [52.3676, 4.9041],
    'rotterdam' => [51.9244, 4.4777],
    'utrecht'   => [52.0907, 5.1214],
    'denhaag'   => [52.0705, 4.3007],
    'eindhoven' => [51.4416, 5.4697],
    'groningen' => [53.2194, 6.5665],
];
```
