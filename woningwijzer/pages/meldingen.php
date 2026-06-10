<?php
$paginaTitel = 'Meldingen';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/db.php';

$db = getDb();
$meldingen = $db->query("SELECT * FROM meldingen ORDER BY aangemaakt_op DESC")->fetchAll();
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
                <div class="p-4 sm:p-5 grid grid-cols-1 sm:grid-cols-[auto_auto_1fr_auto] gap-2 sm:gap-3 items-start sm:items-center">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gedempt"><?= date('j M Y', strtotime($m['aangemaakt_op'])) ?></span>
                    <span class="<?= match($m['status']) {
                        'Open' => 'bg-yellow-100 text-yellow-800',
                        'In behandeling' => 'bg-blue-100 text-blue-800',
                        'Gemeld bij Huurcommissie' => 'bg-purple-100 text-purple-800',
                        'Afgehandeld' => 'bg-green-100 text-green-800',
                        default => 'bg-gray-100 text-gray-600',
                    } ?> text-xs font-semibold px-2 py-0.5 rounded text-center w-fit sm:w-auto">
                        <?= $m['status'] ?>
                    </span>
                    <span class="font-semibold text-sm capitalize"><?= $m['type'] ?></span>
                    <p class="text-sm text-gedempt sm:col-span-1 col-span-2"><?= htmlspecialchars($m['omschrijving']) ?></p>
                    <a href="#" class="text-oranje text-xs font-semibold hover:underline sm:col-span-1 col-span-2 justify-self-end">Details →</a>
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
