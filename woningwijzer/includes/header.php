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

    <!-- Leaflet (OpenStreetMap kaarten) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
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
                    },
                    animation: {
                        'fade-in':     'fadeIn 0.6s ease-out forwards',
                        'fade-in-up':  'fadeInUp 0.6s ease-out forwards',
                        'slide-down':  'slideDown 0.3s ease-out forwards',
                        'scale-in':    'scaleIn 0.3s ease-out forwards',
                        'pulse-soft':  'pulseSoft 2s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%':   { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        fadeInUp: {
                            '0%':   { opacity: '0', transform: 'translateY(24px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        slideDown: {
                            '0%':   { opacity: '0', transform: 'translateY(-8px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        scaleIn: {
                            '0%':   { opacity: '0', transform: 'scale(0.95)' },
                            '100%': { opacity: '1', transform: 'scale(1)' },
                        },
                        pulseSoft: {
                            '0%, 100%': { opacity: '1' },
                            '50%':      { opacity: '0.6' },
                        },
                    }
                }
            }
        }
    </script>

    <style>
        [data-reveal] {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        [data-reveal].revealed {
            opacity: 1;
            transform: translateY(0);
        }
        [data-reveal-delay="1"] { transition-delay: 0.1s; }
        [data-reveal-delay="2"] { transition-delay: 0.2s; }
        [data-reveal-delay="3"] { transition-delay: 0.3s; }
        [data-reveal-delay="4"] { transition-delay: 0.4s; }
        [data-reveal-delay="5"] { transition-delay: 0.5s; }
        [data-reveal-delay="6"] { transition-delay: 0.6s; }
        [data-reveal-delay="7"] { transition-delay: 0.7s; }
        [data-reveal-delay="8"] { transition-delay: 0.8s; }

        .animate-stagger > * {
            opacity: 0;
            transform: translateY(16px);
            transition: opacity 0.5s ease-out, transform 0.5s ease-out;
        }
        .animate-stagger.staggered > *:nth-child(1) { transition-delay: 0.05s; }
        .animate-stagger.staggered > *:nth-child(2) { transition-delay: 0.1s; }
        .animate-stagger.staggered > *:nth-child(3) { transition-delay: 0.15s; }
        .animate-stagger.staggered > *:nth-child(4) { transition-delay: 0.2s; }
        .animate-stagger.staggered > *:nth-child(5) { transition-delay: 0.25s; }
        .animate-stagger.staggered > *:nth-child(6) { transition-delay: 0.3s; }
        .animate-stagger.staggered > *:nth-child(7) { transition-delay: 0.35s; }
        .animate-stagger.staggered > *:nth-child(8) { transition-delay: 0.4s; }
        .animate-stagger.staggered > *:nth-child(9) { transition-delay: 0.45s; }
        .animate-stagger.staggered > *:nth-child(10) { transition-delay: 0.5s; }
        .animate-stagger.staggered > * {
            opacity: 1;
            transform: translateY(0);
        }
    </style>

    <!-- Pagina-specifieke CSS -->
    <?php if (!empty($paginaCss)): ?>
        <link rel="stylesheet" href="assets/css/<?= htmlspecialchars($paginaCss) ?>">
    <?php endif; ?>
</head>
<body class="bg-room dark:bg-gray-950 font-sans text-ink dark:text-gray-100 min-h-screen flex flex-col">

<!-- Navigatie -->
<nav class="bg-ink sticky top-0 z-50 shadow-lg">
    <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between gap-4">

        <!-- Logo -->
        <a href="<?= $root ?>index.php" class="font-display font-bold text-xl text-white flex items-center gap-2 shrink-0">
            🏠 Woning<span class="text-oranje">Wijzer</span>
        </a>

        <!-- Hamburger (mobile) -->
        <button id="menu-toggle" class="md:hidden text-white p-2 rounded-lg hover:bg-white/10 transition-colors" aria-label="Menu">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <!-- Navigatielinks -->
        <ul id="nav-menu" class="hidden md:flex items-center gap-1">
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
                <button id="dark-toggle" class="text-white/70 hover:text-white p-2 rounded-md hover:bg-white/10 transition-colors text-sm" aria-label="Donker/licht modus">
                    <span id="dark-icon">🌙</span>
                </button>
            </li>
            <li class="ml-2">
                <a href="<?= $pagesDir ?>actie.php"
                   class="bg-oranje hover:bg-orange-700 text-white px-4 py-2 rounded-md text-sm font-semibold transition-colors">
                    Doe mee
                </a>
            </li>
        </ul>

    </div>

    <!-- Mobiel menu dropdown -->
    <div id="mobile-menu" class="hidden md:hidden bg-ink border-t border-white/10">
        <div class="max-w-6xl mx-auto px-4 py-3 space-y-1">
            <?php foreach ($navItems as $id => $item):
                $actief = ($huidigePagina === $id);
            ?>
                <a href="<?= $item['href'] ?>"
                   class="<?= $actief ? 'bg-oranje text-white' : 'text-white/70 hover:text-white hover:bg-white/10' ?>
                          block px-3 py-2 rounded-md text-sm font-medium transition-colors">
                    <?= $item['label'] ?>
                </a>
            <?php endforeach; ?>
            <button id="dark-toggle-mobile" class="w-full text-left text-white/70 hover:text-white hover:bg-white/10 block px-3 py-2 rounded-md text-sm font-medium transition-colors mt-2">
                <span id="dark-icon-mobile">🌙</span> Donker modus
            </button>
            <a href="<?= $pagesDir ?>actie.php"
               class="block text-center bg-oranje hover:bg-orange-700 text-white px-4 py-2 rounded-md text-sm font-semibold transition-colors mt-2">
                Doe mee
            </a>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Mobiel menu toggle
    var toggle = document.getElementById('menu-toggle');
    var menu = document.getElementById('mobile-menu');
    if (toggle && menu) {
        toggle.addEventListener('click', function () {
            menu.classList.toggle('hidden');
        });
    }

    // Dark mode toggle
    var html = document.documentElement;
    var icons = [
        document.getElementById('dark-icon'),
        document.getElementById('dark-icon-mobile'),
    ];
    var labels = document.getElementById('dark-toggle-mobile');

    function setTheme(dark) {
        if (dark) {
            html.classList.add('dark');
            localStorage.setItem('theme', 'dark');
            icons.forEach(function (el) { if (el) el.textContent = '☀️'; });
            if (labels) labels.textContent = '☀️ Licht modus';
        } else {
            html.classList.remove('dark');
            localStorage.setItem('theme', 'light');
            icons.forEach(function (el) { if (el) el.textContent = '🌙'; });
            if (labels) labels.textContent = '🌙 Donker modus';
        }
    }

    // Laad voorkeur
    var saved = localStorage.getItem('theme');
    if (saved === 'dark' || (!saved && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        setTheme(true);
    }

    document.getElementById('dark-toggle').addEventListener('click', function () {
        setTheme(!html.classList.contains('dark'));
    });
    var mobileToggle = document.getElementById('dark-toggle-mobile');
    if (mobileToggle) {
        mobileToggle.addEventListener('click', function () {
            setTheme(!html.classList.contains('dark'));
        });
    }
});
</script>