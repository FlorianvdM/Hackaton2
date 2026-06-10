<?php
// ============================================================
// config.local.example.php — Voorbeeld per-apparaat config
// ============================================================
// KOPIEER dit bestand naar config.local.php en pas de waarden
// aan. config.local.php staat in .gitignore, dus wijzigingen
// blijven per machine behouden en worden niet meegenomen in git.
// ============================================================

return [
    'host' => '127.0.0.1:3306',       // of bijv. '192.168.1.10:3306' voor centrale DB
    'name' => 'woningwijzer',
    'user' => 'root',
    'pass' => '',
    'char' => 'utf8mb4',
];
