<?php
$paginaTitel = 'Meldingen';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/db.php';

$meldingen = [
    ['id' => 1, 'type' => 'discriminatie', 'omschrijving' => 'Huisbazin weigert huurders met migratieachtergrond.', 'status' => 'In behandeling', 'datum' => '2 juni 2026'],
    ['id' => 2, 'type' => 'illegale praktijken', 'omschrijving' => 'Verhuurder vraagt sleutelgeld van € 2.000 voor sociale huurwoning.', 'status' => 'Gemeld bij Huurcommissie', 'datum' => '28 mei 2026'],
    ['id' => 3, 'type' => 'onderhoud', 'omschrijving' => 'Schimmel in slaapkamer al 8 maanden niet verholpen door verhuurder.', 'status' => 'Open', 'datum' => '15 mei 2026'],
    ['id' => 4, 'type' => 'huurverhoging', 'omschrijving' => 'Huurverhoging van 12% ontvangen, terwijl maximum 5,8% is.', 'status' => 'Afgehandeld', 'datum' => '3 mei 2026'],
];
?>

<div class="max-w-6xl mx-auto px-4 py-10">

    <p class="text-xs font-semibold uppercase tracking-widest text-oranje mb-1">Meldingen</p>
    <h1 class="font-display text-3xl font-bold mb-2">Misstanden melden</h1>
    <p class="text-gedempt text-base max-w-lg mb-8">
        Zie je iets dat niet klopt op de woningmarkt? Meld het hier. Alle meldingen worden vertrouwelijk behandeld.
    </p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl border border-gray-100 p-5 text-center">
            <div class="text-3xl mb-2">📋</div>
            <p class="font-display font-bold text-2xl text-oranje"><?= count($meldingen) ?></p>
            <p class="text-xs text-gedempt">Totaal meldingen</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 p-5 text-center">
            <div class="text-3xl mb-2">🔄</div>
            <p class="font-display font-bold text-2xl text-oranje">3</p>
            <p class="text-xs text-gedempt">In behandeling</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 p-5 text-center">
            <div class="text-3xl mb-2">✅</div>
            <p class="font-display font-bold text-2xl text-green-600">1</p>
            <p class="text-xs text-gedempt">Afgehandeld</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden mb-8">
        <div class="p-5 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-display font-semibold text-lg">Overzicht meldingen</h2>
            <button class="bg-oranje hover:bg-orange-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                + Nieuwe melding
            </button>
        </div>
        <div class="divide-y divide-gray-100">
            <?php foreach ($meldingen as $m): ?>
                <div class="p-5 flex flex-wrap items-center gap-3">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gedempt min-w-[80px]"><?= $m['datum'] ?></span>
                    <span class="<?= match($m['status']) {
                        'Open' => 'bg-yellow-100 text-yellow-800',
                        'In behandeling' => 'bg-blue-100 text-blue-800',
                        'Gemeld bij Huurcommissie' => 'bg-purple-100 text-purple-800',
                        'Afgehandeld' => 'bg-green-100 text-green-800',
                        default => 'bg-gray-100 text-gray-600',
                    } ?> text-xs font-semibold px-2 py-0.5 rounded min-w-[100px] text-center">
                        <?= $m['status'] ?>
                    </span>
                    <span class="font-semibold text-sm capitalize"><?= $m['type'] ?></span>
                    <p class="text-sm text-gedempt flex-1"><?= htmlspecialchars($m['omschrijving']) ?></p>
                    <a href="#" class="text-oranje text-xs font-semibold hover:underline shrink-0">Details →</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <a href="rechten.php" class="bg-white border border-gray-100 rounded-xl p-5 hover:shadow-md transition-shadow group">
            <h4 class="font-display font-bold text-ink group-hover:text-oranje transition-colors mb-2">⚖️ Ken je rechten</h4>
            <p class="text-sm text-gedempt">Lees wat jouw rechten zijn als huurder en hoe je huurgeschillen kunt aanvechten.</p>
        </a>
        <a href="actie.php" class="bg-white border border-gray-100 rounded-xl p-5 hover:shadow-md transition-shadow group">
            <h4 class="font-display font-bold text-ink group-hover:text-oranje transition-colors mb-2">📢 Doe mee</h4>
            <p class="text-sm text-gedempt">Teken de petitie, schrijf je volksvertegenwoordiger en help de woningcrisis oplossen.</p>
        </a>
    </div>

</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
