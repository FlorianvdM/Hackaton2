<?php
$paginaTitel = 'Nieuws & beleid';
require_once __DIR__ . '/../includes/header.php';

$artikelen = [
    [
        'datum' => '3 juni 2026',
        'categorie' => 'Wetgeving',
        'titel' => 'Huurverhoging 2026: wat verandert er?',
        'samenvatting' => 'Het kabinet heeft de maximale huurverhoging voor 2026 vastgesteld. Sociale huur stijgt maximaal met de inflatie + 1%. Vrije sector: geen wettelijk maximum, maar wel toetsing.',
        'link' => '#',
    ],
    [
        'datum' => '28 mei 2026',
        'categorie' => 'Beleid',
        'titel' => '30.000 sociale huurwoningen erbij in 2026',
        'samenvatting' => 'Minister kondigt aan dat gemeenten versneld sociale huurwoningen moeten bouwen. Doel: 30.000 extra eenheden in 2026, met focus op jongeren en spoedzoekers.',
        'link' => '#',
    ],
    [
        'datum' => '15 mei 2026',
        'categorie' => 'Huurmarkt',
        'titel' => 'Huurprijzen in vrije sector dalen licht',
        'samenvatting' => 'De gemiddelde huurprijs in de vrije sector is voor het eerst in jaren gedaald. Daling van 1,2% t.o.v. vorig kwartaal, vooral in Amsterdam en Utrecht.',
        'link' => '#',
    ],
    [
        'datum' => '2 mei 2026',
        'categorie' => 'Wetgeving',
        'titel' => 'Wet betaalbare huur: evaluatie na 2 jaar',
        'samenvatting' => 'De Wet betaalbare huur heeft sinds 2024 duizenden huurders beschermd. Evaluatie toont dat de huurprijzen in het middensegment met gemiddeld 8% zijn gedaald.',
        'link' => '#',
    ],
    [
        'datum' => '20 april 2026',
        'categorie' => 'Onderzoek',
        'titel' => 'Starters steeds vaker aangewezen op vrije sector',
        'samenvatting' => 'Uit onderzoek van het CBS blijkt dat 1 op de 3 starters direct in de vrije sector terechtkomt. De wachttijd voor sociale huur in grote steden loopt op tot 10 jaar.',
        'link' => '#',
    ],
    [
        'datum' => '8 april 2026',
        'categorie' => 'Beleid',
        'titel' => 'Gemeenten krijgen meer macht bij woningtoewijzing',
        'samenvatting' => 'Nieuwe wet moet gemeenten meer zeggenschap geven over wie een sociale huurwoning krijgt. Voorrang voor leraren, verpleegkundigen en andere cruciale beroepen.',
        'link' => '#',
    ],
];
?>

<div class="max-w-6xl mx-auto px-4 py-10">

    <p class="text-xs font-semibold uppercase tracking-widest text-oranje mb-1">Nieuws & beleid</p>
    <h1 class="font-display text-3xl font-bold mb-2">Woningmarkt in beweging</h1>
    <p class="text-gedempt text-base max-w-lg mb-8">
        Blijf op de hoogte van de laatste ontwikkelingen, wetswijzigingen en analyses rondom de Nederlandse woningmarkt.
    </p>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-12">
        <?php foreach ($artikelen as $a): ?>
            <div class="bg-white dark:bg-gray-800 dark:text-gray-200 rounded-xl border border-gray-100 dark:border-gray-700 p-5 hover:shadow-md transition-shadow">
                <div class="flex items-center gap-2 mb-3">
                    <span class="text-xs text-gedempt"><?= $a['datum'] ?></span>
                    <span class="bg-oranje/10 text-oranje text-[10px] font-semibold uppercase tracking-wider px-2 py-0.5 rounded">
                        <?= $a['categorie'] ?>
                    </span>
                </div>
                <h3 class="font-display font-semibold text-base text-ink dark:text-gray-100 mb-2"><?= htmlspecialchars($a['titel']) ?></h3>
                <p class="text-sm text-gedempt leading-relaxed mb-4"><?= htmlspecialchars($a['samenvatting']) ?></p>
                <a href="<?= $a['link'] ?>" class="text-oranje text-xs font-semibold hover:underline">→ Lees verder</a>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="bg-orange-50 border border-orange-200 rounded-xl p-5 mb-8">
        <h3 class="font-display font-semibold text-base mb-2">📬 Blijf op de hoogte</h3>
        <p class="text-sm text-gedempt mb-4">Ontvang maandelijks een overzicht van het belangrijkste woningmarktnieuws in je mailbox.</p>
        <form class="flex gap-2 max-w-md">
            <input type="email" placeholder="Jouw e-mailadres" class="flex-1 border border-gray-200 dark:border-gray-600 rounded-lg px-3 py-2 text-sm text-ink dark:text-gray-100">
            <button type="submit" class="bg-oranje hover:bg-orange-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors">Aanmelden</button>
        </form>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <a href="actie.php" class="bg-white dark:bg-gray-800 dark:text-gray-200 border border-gray-100 dark:border-gray-700 rounded-xl p-5 hover:shadow-md transition-shadow group">
            <h4 class="font-display font-bold text-ink dark:text-gray-100 group-hover:text-oranje transition-colors mb-2">📢 Kom in actie</h4>
            <p class="text-sm text-gedempt">Teken petities, schrijf je volksvertegenwoordiger en help de woningcrisis oplossen.</p>
        </a>
        <a href="meldingen.php" class="bg-white dark:bg-gray-800 dark:text-gray-200 border border-gray-100 dark:border-gray-700 rounded-xl p-5 hover:shadow-md transition-shadow group">
            <h4 class="font-display font-bold text-ink dark:text-gray-100 group-hover:text-oranje transition-colors mb-2">🔔 Meld misstanden</h4>
            <p class="text-sm text-gedempt">Zie je illegale praktijken of discriminatie? Meld het via ons meldingssysteem.</p>
        </a>
    </div>

</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
