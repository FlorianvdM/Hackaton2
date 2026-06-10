<?php
$paginaTitel = 'Woning bewerken';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/db.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$demoWoningen = [
    1 => ['type' => 'appartement', 'stad' => 'amsterdam', 'categorie' => 'vrij', 'prijs' => 1650, 'kamers' => 2, 'oppervlak' => 58, 'omschrijving' => 'Licht appartement in de Jordaan met balkon.'],
    2 => ['type' => 'woning', 'stad' => 'rotterdam', 'categorie' => 'koop', 'prijs' => 285000, 'kamers' => 4, 'oppervlak' => 102, 'omschrijving' => 'Ruime rijtjeswoning met tuin in Kralingen.'],
    3 => ['type' => 'studio', 'stad' => 'utrecht', 'categorie' => 'vrij', 'prijs' => 1100, 'kamers' => 1, 'oppervlak' => 32, 'omschrijving' => 'Moderne studio nabij Centraal Station.'],
    4 => ['type' => 'appartement', 'stad' => 'denhaag', 'categorie' => 'sociaal', 'prijs' => 760, 'kamers' => 3, 'oppervlak' => 75, 'omschrijving' => 'Sociale huurwoning, inschrijftijd vereist.'],
    5 => ['type' => 'kamer', 'stad' => 'groningen', 'categorie' => 'vrij', 'prijs' => 620, 'kamers' => 1, 'oppervlak' => 18, 'omschrijving' => 'Gemeubileerde kamer in studentenhuis centrum.'],
    6 => ['type' => 'woning', 'stad' => 'eindhoven', 'categorie' => 'koop', 'prijs' => 340000, 'kamers' => 5, 'oppervlak' => 130, 'omschrijving' => 'Vrijstaande woning met garage en grote tuin.'],
    7 => ['type' => 'appartement', 'stad' => 'amsterdam', 'categorie' => 'koop', 'prijs' => 425000, 'kamers' => 2, 'oppervlak' => 64, 'omschrijving' => 'Instapklaar appartement in De Pijp.'],
    8 => ['type' => 'studio', 'stad' => 'rotterdam', 'categorie' => 'vrij', 'prijs' => 950, 'kamers' => 1, 'oppervlak' => 28, 'omschrijving' => 'Gezellige studio met uitzicht op de Maas.'],
];

$woning = $demoWoningen[$id] ?? null;

$succes = false;
$fouten = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = trim($_POST['type'] ?? '');
    $stad = trim($_POST['stad'] ?? '');
    $categorie = trim($_POST['categorie'] ?? '');
    $prijs = (int) ($_POST['prijs'] ?? 0);
    $kamers = (int) ($_POST['kamers'] ?? 0);
    $oppervlak = (int) ($_POST['oppervlak'] ?? 0);
    $omschrijving = trim($_POST['omschrijving'] ?? '');

    if (empty($type)) $fouten[] = 'Kies een type woning.';
    if (empty($stad)) $fouten[] = 'Kies een gemeente.';
    if (empty($categorie)) $fouten[] = 'Kies huur of koop.';
    if ($prijs <= 0) $fouten[] = 'Vul een geldige prijs in.';
    if ($kamers <= 0) $fouten[] = 'Vul het aantal kamers in.';
    if ($oppervlak <= 0) $fouten[] = 'Vul de oppervlakte in.';
    if (empty($omschrijving)) $fouten[] = 'Schrijf een korte omschrijving.';

    if (empty($fouten)) {
        $succes = true;
    }
}
?>

<div class="max-w-2xl mx-auto px-4 py-10">

    <a href="zoeken.php" class="text-sm text-gedempt hover:text-ink mb-6 inline-flex items-center gap-1">
        ← Terug naar overzicht
    </a>

    <?php if (!$woning): ?>
        <div class="text-center py-16">
            <div class="text-5xl mb-4">🏚️</div>
            <h1 class="font-display text-2xl font-bold mb-2">Woning niet gevonden</h1>
            <p class="text-gedempt mb-4">Deze woning bestaat niet of is verwijderd.</p>
            <a href="zoeken.php" class="bg-oranje hover:bg-orange-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition-colors inline-block">
                ← Terug naar zoeken
            </a>
        </div>
    <?php else: ?>
        <p class="text-xs font-semibold uppercase tracking-widest text-oranje mb-1">CRUD — Update</p>
        <h1 class="font-display text-3xl font-bold mb-6">Woning bewerken</h1>

        <?php if ($succes): ?>
            <div class="bg-green-50 border border-green-200 text-green-800 rounded-xl p-4 mb-6 flex items-center gap-3">
                ✅ <span class="font-semibold">Woning succesvol bijgewerkt!</span>
                <a href="zoeken.php" class="ml-auto text-sm underline">Bekijk overzicht</a>
            </div>
        <?php endif; ?>

        <?php if (!empty($fouten)): ?>
            <div class="bg-red-50 border border-red-200 text-red-800 rounded-xl p-4 mb-6">
                <p class="font-semibold mb-2">Los de volgende fouten op:</p>
                <ul class="text-sm list-disc list-inside space-y-1">
                    <?php foreach ($fouten as $f): ?>
                        <li><?= htmlspecialchars($f) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="woning-bewerken.php?id=<?= $id ?>"
              class="bg-white rounded-xl border border-gray-100 p-6 space-y-5">

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-gedempt mb-1">Type woning</label>
                <select name="type" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-ink" required>
                    <option value="">Kies een type</option>
                    <option value="appartement" <?= ($_POST['type'] ?? $woning['type']) === 'appartement' ? 'selected' : '' ?>>Appartement</option>
                    <option value="woning"      <?= ($_POST['type'] ?? $woning['type']) === 'woning' ? 'selected' : '' ?>>Eengezinswoning</option>
                    <option value="studio"      <?= ($_POST['type'] ?? $woning['type']) === 'studio' ? 'selected' : '' ?>>Studio</option>
                    <option value="kamer"       <?= ($_POST['type'] ?? $woning['type']) === 'kamer' ? 'selected' : '' ?>>Kamer</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-gedempt mb-1">Gemeente</label>
                <select name="stad" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-ink" required>
                    <option value="">Kies een gemeente</option>
                    <?php foreach (['amsterdam', 'rotterdam', 'utrecht', 'denhaag', 'eindhoven', 'groningen'] as $s): ?>
                        <option value="<?= $s ?>" <?= ($_POST['stad'] ?? $woning['stad']) === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-gedempt mb-1">Huur / Koop</label>
                <select name="categorie" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-ink" required>
                    <option value="">Kies een categorie</option>
                    <option value="sociaal" <?= ($_POST['categorie'] ?? $woning['categorie']) === 'sociaal' ? 'selected' : '' ?>>Sociale huur</option>
                    <option value="vrij"    <?= ($_POST['categorie'] ?? $woning['categorie']) === 'vrij' ? 'selected' : '' ?>>Vrije sector huur</option>
                    <option value="koop"    <?= ($_POST['categorie'] ?? $woning['categorie']) === 'koop' ? 'selected' : '' ?>>Koop</option>
                </select>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-gedempt mb-1">Prijs (€)</label>
                    <input type="number" name="prijs" min="1"
                           value="<?= htmlspecialchars($_POST['prijs'] ?? $woning['prijs']) ?>"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-ink" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-gedempt mb-1">Kamers</label>
                    <input type="number" name="kamers" min="1" max="20"
                           value="<?= htmlspecialchars($_POST['kamers'] ?? $woning['kamers']) ?>"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-ink" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-gedempt mb-1">Oppervlak (m²)</label>
                    <input type="number" name="oppervlak" min="1"
                           value="<?= htmlspecialchars($_POST['oppervlak'] ?? $woning['oppervlak']) ?>"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-ink" required>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-gedempt mb-1">Omschrijving</label>
                <textarea name="omschrijving" rows="3" placeholder="Korte beschrijving van de woning..."
                          class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-ink resize-none"
                          required><?= htmlspecialchars($_POST['omschrijving'] ?? $woning['omschrijving']) ?></textarea>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 pt-2">
                <button type="submit" class="bg-oranje hover:bg-orange-700 text-white px-6 py-2.5 rounded-lg text-sm font-semibold transition-colors">
                    Wijzigingen opslaan
                </button>
                <a href="zoeken.php" class="border border-gray-200 hover:bg-gray-50 text-ink px-5 py-2.5 rounded-lg text-sm transition-colors text-center">Annuleren</a>
            </div>

        </form>
    <?php endif; ?>

</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
