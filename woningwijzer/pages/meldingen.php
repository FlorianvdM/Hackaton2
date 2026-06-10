<?php
require_once __DIR__ . '/../includes/db.php';

$fouten = [];
$succes = false;

// Nieuwe melding verwerken (POST) — vóór HTML-output voor redirect
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = trim($_POST['type'] ?? '');
    $omschrijving = trim($_POST['omschrijving'] ?? '');

    if (empty($type)) $fouten[] = 'Kies een type melding.';
    if (empty($omschrijving)) $fouten[] = 'Schrijf een omschrijving.';

    if (empty($fouten)) {
        $db = getDb();
        $stmt = $db->prepare("INSERT INTO meldingen (type, omschrijving, status) VALUES (:type, :omschrijving, 'Open')");
        $stmt->execute([':type' => $type, ':omschrijving' => $omschrijving]);

        header("Location: meldingen.php?toegevoegd=1");
        exit;
    }
}

$db = getDb();
$meldingen = $db->query("SELECT * FROM meldingen ORDER BY aangemaakt_op DESC")->fetchAll();

$paginaTitel = 'Meldingen';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="max-w-6xl mx-auto px-4 py-10">

    <p class="text-xs font-semibold uppercase tracking-widest text-oranje mb-1">Meldingen</p>
    <h1 class="font-display text-3xl font-bold mb-2">Misstanden melden</h1>
    <p class="text-gedempt text-base max-w-lg mb-8">
        Zie je iets dat niet klopt op de woningmarkt? Meld het hier. Alle meldingen worden vertrouwelijk behandeld.
    </p>

    <?php if (isset($_GET['toegevoegd'])): ?>
        <div class="bg-green-50 border border-green-200 text-green-800 rounded-xl p-4 mb-6 font-semibold">
            ✅ Melding succesvol toegevoegd!
        </div>
    <?php endif; ?>

    <?php if (!empty($fouten)): ?>
        <div class="bg-red-50 border border-red-200 text-red-800 rounded-xl p-4 mb-6">
            <p class="font-semibold mb-2">Los de volgende fouten op:</p>
            <ul class="text-sm list-disc list-inside">
                <?php foreach ($fouten as $f): ?>
                    <li><?= htmlspecialchars($f) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl border border-gray-100 p-5 text-center">
            <div class="text-3xl mb-2">📋</div>
            <p class="font-display font-bold text-2xl text-oranje"><?= count($meldingen) ?></p>
            <p class="text-xs text-gedempt">Totaal meldingen</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 p-5 text-center">
            <div class="text-3xl mb-2">🔄</div>
            <p class="font-display font-bold text-2xl text-oranje"><?= count(array_filter($meldingen, fn($m) => $m['status'] === 'In behandeling' || $m['status'] === 'Gemeld bij Huurcommissie')) ?></p>
            <p class="text-xs text-gedempt">In behandeling</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 p-5 text-center">
            <div class="text-3xl mb-2">✅</div>
            <p class="font-display font-bold text-2xl text-green-600"><?= count(array_filter($meldingen, fn($m) => $m['status'] === 'Afgehandeld')) ?></p>
            <p class="text-xs text-gedempt">Afgehandeld</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden mb-8">
        <div class="p-5 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-display font-semibold text-lg">Overzicht meldingen</h2>
            <button onclick="document.getElementById('meldingForm').classList.toggle('hidden')" class="bg-oranje hover:bg-orange-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors cursor-pointer">
                + Nieuwe melding
            </button>
        </div>

        <div id="meldingForm" class="p-5 border-b border-gray-100 bg-orange-50 <?= (!empty($fouten)) ? '' : 'hidden' ?>">
            <form method="POST" class="space-y-4 max-w-lg">
                <div>
                    <label class="block text-sm font-semibold mb-1">Type melding</label>
                    <select name="type" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        <option value="">— Kies —</option>
                        <option value="discriminatie" <?= ($_POST['type'] ?? '') === 'discriminatie' ? 'selected' : '' ?>>Discriminatie</option>
                        <option value="illegale praktijken" <?= ($_POST['type'] ?? '') === 'illegale praktijken' ? 'selected' : '' ?>>Illegale praktijken</option>
                        <option value="onderhoud" <?= ($_POST['type'] ?? '') === 'onderhoud' ? 'selected' : '' ?>>Onderhoud</option>
                        <option value="huurverhoging" <?= ($_POST['type'] ?? '') === 'huurverhoging' ? 'selected' : '' ?>>Huurverhoging</option>
                        <option value="anders" <?= ($_POST['type'] ?? '') === 'anders' ? 'selected' : '' ?>>Anders</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Omschrijving</label>
                    <textarea name="omschrijving" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" placeholder="Beschrijf de situatie..."><?= htmlspecialchars($_POST['omschrijving'] ?? '') ?></textarea>
                </div>
                <button type="submit" class="bg-oranje hover:bg-orange-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition-colors cursor-pointer">
                    Melding indienen
                </button>
            </form>
        </div>
        <div class="divide-y divide-gray-100">
            <?php foreach ($meldingen as $m): ?>
                <div class="melding-row p-4 sm:p-5 grid grid-cols-1 sm:grid-cols-[auto_auto_1fr_auto] gap-2 sm:gap-3 items-start sm:items-center">
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
                    <button onclick="this.closest('.melding-row').querySelector('.melding-detail').classList.toggle('hidden')" class="text-oranje text-xs font-semibold hover:underline sm:col-span-1 col-span-2 justify-self-end cursor-pointer">Details →</button>
                    <div class="melding-detail hidden col-span-full text-xs text-gedempt border-t border-gray-100 pt-2 mt-1">
                        Ingediend op: <?= date('j M Y H:i', strtotime($m['aangemaakt_op'])) ?>
                    </div>
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
