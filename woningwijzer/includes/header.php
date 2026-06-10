<?php
// Actieve pagina bepalen voor navigatie-highlight
$huidigePagina = basename($_SERVER['PHP_SELF'], '.php');

// Bepaal het pad naar de root (werkt zowel vanuit root als vanuit pages/)
$inPages = strpos($_SERVER['PHP_SELF'], 'woningwijzer/pages/') !== false;
$root = $inPages ? '../../' : '';
$pagesDir = $inPages ? './' : 'woningwijzer/pages/';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $paginaTitel ?? 'WoningWijzer' ?> | WoningWijzer Nederland</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts: Space Grotesk + Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;600;700&family=Inter:wght@400;500&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ink:    '#0F1B2D',
                        ink2:   '#2A3D54',
                        oranje: '#E8650A',
                        room:   '#F2EDE4',
                        gedempt: '#7A8494',
                    },
                    fontFamily: {
                        sans:    ['Inter', 'sans-serif'],
                        display: ['"Space Grotesk"', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Pagina-specifieke CSS -->
    <?php if (!empty($paginaCss)): ?>
        <link rel="stylesheet" href="assets/css/<?= htmlspecialchars($paginaCss) ?>">
    <?php endif; ?>
</head>
<body class="bg-room font-sans text-ink min-h-screen flex flex-col">

<!-- Navigatie -->
<nav class="bg-ink sticky top-0 z-50 shadow-lg">
    <div class="max-w-6xl mx-auto px-4 h-16 flex items-center gap-8">

        <!-- Logo -->
        <a href="<?= $root ?>index.php" class="font-display font-bold text-xl text-white flex items-center gap-2 shrink-0">
            🏠 Woning<span class="text-oranje">Wijzer</span>
        </a>

        <!-- Navigatielinks -->
        <ul class="flex items-center gap-1 ml-auto">
            <?php
            $navItems = [
                'index' => ['label' => 'Home', 'href' => $root . 'index.php'],
                'over-de-crisis' => ['label' => 'Crisis', 'href' => $pagesDir . 'over-de-crisis.php'],
                'zoeken' => ['label' => 'Zoeken', 'href' => $pagesDir . 'zoeken.php'],
                'bereken' => ['label' => 'Bereken', 'href' => $pagesDir . 'bereken.php'],
                'rechten' => ['label' => 'Rechten', 'href' => $pagesDir . 'rechten.php'],
                'nieuws' => ['label' => 'Nieuws', 'href' => $pagesDir . 'nieuws.php'],
                'actie' => ['label' => 'Actie', 'href' => $pagesDir . 'actie.php'],
                'meldingen' => ['label' => 'Meldingen', 'href' => $pagesDir . 'meldingen.php'],
            ];
            foreach ($navItems as $id => $item):
                $actief = ($huidigePagina === $id);
                ?>
                <li>
                    <a href="<?= $item['href'] ?>"
                       class="<?= $actief
                    ? 'bg-oranje text-white'
                    : 'text-white/70 hover:text-white hover:bg-white/10' ?>
                              px-3 py-2 rounded-md text-sm font-medium transition-colors">
                        <?= $item['label'] ?>
                    </a>
                </li>
            <?php endforeach; ?>

            <li class="ml-2">
                <a href="<?= $pagesDir ?>actie.php"
                   class="bg-oranje hover:bg-orange-700 text-white px-4 py-2 rounded-md text-sm font-semibold transition-colors">
                    Doe mee
                </a>
            </li>
        </ul>

    </div>
</nav>