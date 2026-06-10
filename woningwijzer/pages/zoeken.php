<?php
// ============================================================
// pages/zoeken.php — Woningen zoeken & filteren
// Eerstejaars: HTML form, PHP GET filter, MySQL READ (SELECT)
// ============================================================

$paginaTitel = 'Woningen zoeken';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/db.php';

// --- Filterwaarden ophalen uit URL (GET) ---
$filterType = $_GET['type'] ?? '';
$filterStad = $_GET['stad'] ?? '';
$filterCategorie = $_GET['categorie'] ?? '';
$filterBudget = !empty($_GET['budget']) ? (int) $_GET['budget'] : 0;

// --- Woningen ophalen uit database (READ) ---
// Eerstejaars taak: schrijf deze SELECT query

/*
 * ECHT VOORBEELD MET DATABASE:
 *
 * $db  = getDb();
 * $sql = "SELECT * FROM woningen WHERE 1=1";
 * $params = [];
 *
 * if ($filterType !== '') {
 *     $sql .= " AND type = :type";
 *     $params[':type'] = $filterType;
 * }
 * if ($filterStad !== '') {
 *     $sql .= " AND stad = :stad";
 *     $params[':stad'] = $filterStad;
 * }
 * if ($filterCategorie !== '') {
 *     $sql .= " AND categorie = :categorie";
 *     $params[':categorie'] = $filterCategorie;
 * }
 * if ($filterBudget > 0) {
 *     $sql .= " AND prijs <= :budget";
 *     $params[':budget'] = $filterBudget;
 * }
 *
 * $sql .= " ORDER BY aangemaakt_op DESC";
 * $stmt = $db->prepare($sql);
 * $stmt->execute($params);
 * $woningen = $stmt->fetchAll();
 */

// Demo-data (vervangt database zolang die niet is ingericht)
$alleWoningen = [
    ['id' => 1, 'type' => 'appartement', 'stad' => 'amsterdam', 'categorie' => 'vrij', 'prijs' => 1650, 'kamers' => 2, 'oppervlak' => 58, 'omschrijving' => 'Licht appartement in de Jordaan met balkon.'],
    ['id' => 2, 'type' => 'woning', 'stad' => 'rotterdam', 'categorie' => 'koop', 'prijs' => 285000, 'kamers' => 4, 'oppervlak' => 102, 'omschrijving' => 'Ruime rijtjeswoning met tuin in Kralingen.'],
    ['id' => 3, 'type' => 'studio', 'stad' => 'utrecht', 'categorie' => 'vrij', 'prijs' => 1100, 'kamers' => 1, 'oppervlak' => 32, 'omschrijving' => 'Moderne studio nabij Centraal Station.'],
    ['id' => 4, 'type' => 'appartement', 'stad' => 'denhaag', 'categorie' => 'sociaal', 'prijs' => 760, 'kamers' => 3, 'oppervlak' => 75, 'omschrijving' => 'Sociale huurwoning, inschrijftijd vereist.'],
    ['id' => 5, 'type' => 'kamer', 'stad' => 'groningen', 'categorie' => 'vrij', 'prijs' => 620, 'kamers' => 1, 'oppervlak' => 18, 'omschrijving' => 'Gemeubileerde kamer in studentenhuis centrum.'],
    ['id' => 6, 'type' => 'woning', 'stad' => 'eindhoven', 'categorie' => 'koop', 'prijs' => 340000, 'kamers' => 5, 'oppervlak' => 130, 'omschrijving' => 'Vrijstaande woning met garage en grote tuin.'],
    ['id' => 7, 'type' => 'appartement', 'stad' => 'amsterdam', 'categorie' => 'koop', 'prijs' => 425000, 'kamers' => 2, 'oppervlak' => 64, 'omschrijving' => 'Instapklaar appartement in De Pijp.'],
    ['id' => 8, 'type' => 'studio', 'stad' => 'rotterdam', 'categorie' => 'vrij', 'prijs' => 950, 'kamers' => 1, 'oppervlak' => 28, 'omschrijving' => 'Gezellige studio met uitzicht op de Maas.'],
];

// Filter toepassen op demo-data
$woningen = array_filter($alleWoningen, function ($w) use ($filterType, $filterStad, $filterCategorie, $filterBudget) {
    if ($filterType !== '' && $w['type'] !== $filterType)
        return false;
    if ($filterStad !== '' && $w['stad'] !== $filterStad)
        return false;
    if ($filterCategorie !== '' && $w['categorie'] !== $filterCategorie)
        return false;
    if ($filterBudget > 0 && $w['prijs'] > $filterBudget)
        return false;
    return true;
});
?>

<div class="max-w-6xl mx-auto px-4 py-10">

    <p class="text-xs font-semibold uppercase tracking-widest text-oranje mb-1">Woningaanbod</p>
    <h1 class="font-display text-3xl font-bold mb-6">Woningen zoeken</h1>

    <!-- Filterformulier -->
    <form method="GET" action="zoeken.php"
          class="bg-white rounded-xl border border-gray-100 p-4 mb-8 flex flex-wrap gap-3 items-end">

        <!-- Type -->
        <div class="flex flex-col gap-1 flex-1 min-w-[130px]">
            <label class="text-xs font-semibold uppercase tracking-wide text-gedempt">Type</label>
            <select name="type" class="border border-gray-200 rounded-lg px-3 py-2 text-sm text-ink">
                <option value="">Alle types</option>
                <option value="appartement" <?= $filterType === 'appartement' ? 'selected' : '' ?>>Appartement</option>
                <option value="woning"      <?= $filterType === 'woning' ? 'selected' : '' ?>>Eengezinswoning</option>
                <option value="studio"      <?= $filterType === 'studio' ? 'selected' : '' ?>>Studio</option>
                <option value="kamer"       <?= $filterType === 'kamer' ? 'selected' : '' ?>>Kamer</option>
            </select>
        </div>

        <!-- Stad -->
        <div class="flex flex-col gap-1 flex-1 min-w-[130px]">
            <label class="text-xs font-semibold uppercase tracking-wide text-gedempt">Gemeente</label>
            <select name="stad" class="border border-gray-200 rounded-lg px-3 py-2 text-sm text-ink">
                <option value="">Alle gemeenten</option>
                <option value="amsterdam"  <?= $filterStad === 'amsterdam' ? 'selected' : '' ?>>Amsterdam</option>
                <option value="rotterdam"  <?= $filterStad === 'rotterdam' ? 'selected' : '' ?>>Rotterdam</option>
                <option value="utrecht"    <?= $filterStad === 'utrecht' ? 'selected' : '' ?>>Utrecht</option>
                <option value="denhaag"    <?= $filterStad === 'denhaag' ? 'selected' : '' ?>>Den Haag</option>
                <option value="eindhoven"  <?= $filterStad === 'eindhoven' ? 'selected' : '' ?>>Eindhoven</option>
                <option value="groningen"  <?= $filterStad === 'groningen' ? 'selected' : '' ?>>Groningen</option>
            </select>
        </div>

        <!-- Categorie -->
        <div class="flex flex-col gap-1 flex-1 min-w-[130px]">
            <label class="text-xs font-semibold uppercase tracking-wide text-gedempt">Huur / Koop</label>
            <select name="categorie" class="border border-gray-200 rounded-lg px-3 py-2 text-sm text-ink">
                <option value="">Beide</option>
                <option value="sociaal" <?= $filterCategorie === 'sociaal' ? 'selected' : '' ?>>Huur sociaal</option>
                <option value="vrij"    <?= $filterCategorie === 'vrij' ? 'selected' : '' ?>>Huur vrij sector</option>
                <option value="koop"    <?= $filterCategorie === 'koop' ? 'selected' : '' ?>>Koop</option>
            </select>
        </div>

        <!-- Budget -->
        <div class="flex flex-col gap-1 flex-1 min-w-[130px]">
            <label class="text-xs font-semibold uppercase tracking-wide text-gedempt">Max. budget (€)</label>
            <input type="number" name="budget" value="<?= htmlspecialchars($filterBudget ?: '') ?>"
                   placeholder="Geen max."
                   class="border border-gray-200 rounded-lg px-3 py-2 text-sm text-ink">
        </div>

        <div class="flex gap-2">
            <button type="submit"
                    class="bg-oranje hover:bg-orange-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition-colors">
                Zoeken
            </button>
            <a href="zoeken.php"
               class="border border-gray-200 hover:bg-gray-50 text-ink px-4 py-2 rounded-lg text-sm transition-colors">
                Reset
            </a>
        </div>
    </form>

    <!-- Resultaten -->
    <div class="flex items-center justify-between mb-4">
        <p class="text-sm text-gedempt">
            <strong class="text-ink"><?= count($woningen) ?></strong> woningen gevonden
        </p>
        <!-- CREATE knop — alleen zichtbaar voor beheerders in echte versie -->
        <a href="woning-toevoegen.php"
           class="bg-ink hover:bg-ink2 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
            + Woning toevoegen
        </a>
    </div>

    <?php if (empty($woningen)): ?>
        <div class="text-center py-16 text-gedempt">
            <div class="text-5xl mb-4">🏚️</div>
            <p class="text-lg font-semibold text-ink mb-2">Geen woningen gevonden</p>
            <p class="text-sm">Pas de filters aan of verwijder het maximale budget.</p>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($woningen as $w): ?>
                <div class="bg-white rounded-xl border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">

                    <!-- Afbeeldingvlak (placeholder) -->
                    <div class="bg-gray-100 h-36 flex items-center justify-center text-4xl">
                        <?= $w['type'] === 'kamer' ? '🛏️' : ($w['type'] === 'studio' ? '🪟' : ($w['categorie'] === 'koop' ? '🏡' : '🏢')) ?>
                    </div>

                    <div class="p-4">
                        <!-- Badge: categorie -->
                        <?php
                        $badgeKleur = match ($w['categorie']) {
                            'sociaal' => 'bg-green-100 text-green-800',
                            'vrij' => 'bg-orange-100 text-orange-800',
                            'koop' => 'bg-blue-100 text-blue-800',
                            default => 'bg-gray-100 text-gray-600',
                        };
                        $catLabel = match ($w['categorie']) {
                            'sociaal' => 'Sociale huur',
                            'vrij' => 'Vrije sector',
                            'koop' => 'Koop',
                            default => $w['categorie'],
                        };
                        ?>
                        <span class="<?= $badgeKleur ?> text-xs font-semibold px-2 py-0.5 rounded">
                            <?= $catLabel ?>
                        </span>

                        <h3 class="font-display font-semibold text-base mt-2 mb-1 text-ink capitalize">
                            <?= htmlspecialchars($w['type']) ?> — <?= ucfirst($w['stad']) ?>
                        </h3>

                        <p class="text-sm text-gedempt mb-3 leading-relaxed">
                            <?= htmlspecialchars($w['omschrijving']) ?>
                        </p>

                        <div class="flex items-center justify-between text-sm">
                            <div class="text-gedempt">
                                🛏 <?= $w['kamers'] ?> kamer<?= $w['kamers'] > 1 ? 's' : '' ?> &nbsp;·&nbsp;
                                📐 <?= $w['oppervlak'] ?> m²
                            </div>
                            <div class="font-display font-bold text-oranje">
                                <?= $w['categorie'] === 'koop'
                                    ? '€ ' . number_format($w['prijs'], 0, ',', '.')
                                    : '€ ' . $w['prijs'] . '/mnd' ?>
                            </div>
                        </div>

                        <!-- Actieknoppen: CRUD (Update / Delete) -->
                        <div class="flex gap-2 mt-3 pt-3 border-t border-gray-100">
                            <a href="woning-detail.php?id=<?= $w['id'] ?>"
                               class="flex-1 text-center text-xs font-semibold py-1.5 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                Bekijken
                            </a>
                            <a href="woning-bewerken.php?id=<?= $w['id'] ?>"
                               class="flex-1 text-center text-xs font-semibold py-1.5 border border-blue-200 text-blue-700 rounded-lg hover:bg-blue-50 transition-colors">
                                Bewerken
                            </a>
                            <a href="woning-verwijderen.php?id=<?= $w['id'] ?>"
                               class="flex-1 text-center text-xs font-semibold py-1.5 border border-red-200 text-red-600 rounded-lg hover:bg-red-50 transition-colors"
                               onclick="return confirm('Weet je zeker dat je deze woning wilt verwijderen?')">
                                Verwijderen
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>