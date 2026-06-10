<?php
// ============================================================
// pages/woning-toevoegen.php — Woning aanmaken (CREATE)
// Eerstejaars: HTML form, PHP POST verwerking, MySQL INSERT
// ============================================================

require_once __DIR__ . '/../includes/db.php';

$fouten = [];

// Stad-coordinaten als fallback
$stadCoords = [
    'amsterdam' => [52.3676, 4.9041],
    'rotterdam' => [51.9244, 4.4777],
    'utrecht' => [52.0907, 5.1214],
    'denhaag' => [52.0705, 4.3007],
    'eindhoven' => [51.4416, 5.4697],
    'groningen' => [53.2194, 6.5665],
];

// Formulierverwerking bij POST (vóór enige HTML-output, zodat header() redirect werkt)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = trim($_POST['type'] ?? '');
    $stad = trim($_POST['stad'] ?? '');
    $categorie = trim($_POST['categorie'] ?? '');
    $prijs = (int) ($_POST['prijs'] ?? 0);
    $kamers = (int) ($_POST['kamers'] ?? 0);
    $oppervlak = (int) ($_POST['oppervlak'] ?? 0);
    $omschrijving = trim($_POST['omschrijving'] ?? '');
    $adres = trim($_POST['adres'] ?? '');

    if (empty($type)) $fouten[] = 'Kies een type woning.';
    if (empty($stad)) $fouten[] = 'Kies een gemeente.';
    if (empty($categorie)) $fouten[] = 'Kies huur of koop.';
    if ($prijs <= 0) $fouten[] = 'Vul een geldige prijs in.';
    if ($kamers <= 0) $fouten[] = 'Vul het aantal kamers in.';
    if ($oppervlak <= 0) $fouten[] = 'Vul de oppervlakte in.';
    if (empty($omschrijving)) $fouten[] = 'Schrijf een korte omschrijving.';

    $lat = null;
    $lng = null;
    if (empty($fouten)) {
        $zoekterm = rawurlencode(trim($adres) ? "$adres, $stad, Nederland" : $stad);
        $pdokUrl = "https://geodata.nationaalgeoregister.nl/locatieserver/v3/free?q=$zoekterm&rows=1";
        $ctx = stream_context_create(['http' => ['timeout' => 3]]);
        $resp = @file_get_contents($pdokUrl, false, $ctx);
        if ($resp) {
            $pdok = json_decode($resp, true);
            if (!empty($pdok['response']['docs'][0])) {
                $doc = $pdok['response']['docs'][0];
                $lat = $doc['lat'] ?? null;
                $lng = $doc['lon'] ?? null;
            }
        }
        if (!$lat || !$lng) {
            $lat = $stadCoords[$stad][0] ?? null;
            $lng = $stadCoords[$stad][1] ?? null;
        }

        $db = getDb();
        $stmt = $db->prepare("
            INSERT INTO woningen (type, stad, categorie, prijs, kamers, oppervlak, omschrijving, lat, lng, aangemaakt_op)
            VALUES (:type, :stad, :categorie, :prijs, :kamers, :oppervlak, :omschrijving, :lat, :lng, NOW())
        ");
        $stmt->execute([
            ':type'         => $type,
            ':stad'         => $stad,
            ':categorie'    => $categorie,
            ':prijs'        => $prijs,
            ':kamers'       => $kamers,
            ':oppervlak'    => $oppervlak,
            ':omschrijving' => $omschrijving,
            ':lat'          => $lat,
            ':lng'          => $lng,
        ]);

        header("Location: zoeken.php?kaart=1");
        exit;
    }
}

$paginaTitel = 'Woning toevoegen';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="max-w-2xl mx-auto px-4 py-10">

    <a href="zoeken.php" class="text-sm text-gedempt hover:text-ink mb-6 inline-flex items-center gap-1">
        ← Terug naar overzicht
    </a>

    <p class="text-xs font-semibold uppercase tracking-widest text-oranje mb-1">CRUD — Create</p>
    <h1 class="font-display text-3xl font-bold mb-6">Woning toevoegen</h1>

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

    <form method="POST" action="woning-toevoegen.php"
          class="bg-white dark:bg-gray-800 dark:text-gray-200 rounded-xl border border-gray-100 dark:border-gray-700 p-6 space-y-5">

        <!-- Type -->
        <div>
            <label class="block text-xs font-semibold uppercase tracking-wide text-gedempt mb-1">Type woning</label>
            <select name="type" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-ink" required>
                <option value="">Kies een type</option>
                <option value="appartement" <?= ($_POST['type'] ?? '') === 'appartement' ? 'selected' : '' ?>>Appartement</option>
                <option value="woning"      <?= ($_POST['type'] ?? '') === 'woning' ? 'selected' : '' ?>>Eengezinswoning</option>
                <option value="studio"      <?= ($_POST['type'] ?? '') === 'studio' ? 'selected' : '' ?>>Studio</option>
                <option value="kamer"       <?= ($_POST['type'] ?? '') === 'kamer' ? 'selected' : '' ?>>Kamer</option>
            </select>
        </div>

        <!-- Stad -->
        <div>
            <label class="block text-xs font-semibold uppercase tracking-wide text-gedempt mb-1">Gemeente</label>
            <select name="stad" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-ink" required>
                <option value="">Kies een gemeente</option>
                <?php foreach (['amsterdam', 'rotterdam', 'utrecht', 'denhaag', 'eindhoven', 'groningen'] as $s): ?>
                    <option value="<?= $s ?>" <?= ($_POST['stad'] ?? '') === $s ? 'selected' : '' ?>>
                        <?= ucfirst($s) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Categorie -->
        <div>
            <label class="block text-xs font-semibold uppercase tracking-wide text-gedempt mb-1">Huur / Koop</label>
            <select name="categorie" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-ink" required>
                <option value="">Kies een categorie</option>
                <option value="sociaal" <?= ($_POST['categorie'] ?? '') === 'sociaal' ? 'selected' : '' ?>>Sociale huur</option>
                <option value="vrij"    <?= ($_POST['categorie'] ?? '') === 'vrij' ? 'selected' : '' ?>>Vrije sector huur</option>
                <option value="koop"    <?= ($_POST['categorie'] ?? '') === 'koop' ? 'selected' : '' ?>>Koop</option>
            </select>
        </div>

        <!-- Prijs + Kamers + Oppervlak (3 kolommen) -->
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-gedempt mb-1">Prijs (€)</label>
                <input type="number" name="prijs" min="1"
                       value="<?= htmlspecialchars($_POST['prijs'] ?? '') ?>"
                       placeholder="bijv. 1200"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-ink" required>
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-gedempt mb-1">Kamers</label>
                <input type="number" name="kamers" min="1" max="20"
                       value="<?= htmlspecialchars($_POST['kamers'] ?? '') ?>"
                       placeholder="bijv. 3"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-ink" required>
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-gedempt mb-1">Oppervlak (m²)</label>
                <input type="number" name="oppervlak" min="1"
                       value="<?= htmlspecialchars($_POST['oppervlak'] ?? '') ?>"
                       placeholder="bijv. 65"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-ink" required>
            </div>
        </div>

        <!-- Adres -->
        <div>
            <label class="block text-xs font-semibold uppercase tracking-wide text-gedempt mb-1">Adres <span class="text-gedempt/60 font-normal">(optioneel — voor de kaart)</span></label>
            <input type="text" name="adres" value="<?= htmlspecialchars($_POST['adres'] ?? '') ?>"
                   placeholder="bijv. Rozengracht 123"
                   class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-ink">
        </div>

        <!-- Omschrijving -->
        <div>
            <label class="block text-xs font-semibold uppercase tracking-wide text-gedempt mb-1">Omschrijving</label>
            <textarea name="omschrijving" rows="3" placeholder="Korte beschrijving van de woning..."
                      class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-ink resize-none"
                      required><?= htmlspecialchars($_POST['omschrijving'] ?? '') ?></textarea>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 pt-2">
            <button type="submit"
                    class="bg-oranje hover:bg-orange-700 text-white px-6 py-2.5 rounded-lg text-sm font-semibold transition-colors">
                Woning opslaan
            </button>
            <a href="zoeken.php"
               class="border border-gray-200 hover:bg-gray-50 text-ink px-5 py-2.5 rounded-lg text-sm transition-colors text-center">
                Annuleren
            </a>
        </div>

    </form>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>