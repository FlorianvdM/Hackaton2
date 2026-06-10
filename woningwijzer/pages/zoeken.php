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
$db = getDb();
$sql = "SELECT * FROM woningen WHERE 1=1";
$params = [];

if ($filterType !== '') {
    $sql .= " AND type = :type";
    $params[':type'] = $filterType;
}
if ($filterStad !== '') {
    $sql .= " AND stad = :stad";
    $params[':stad'] = $filterStad;
}
if ($filterCategorie !== '') {
    $sql .= " AND categorie = :categorie";
    $params[':categorie'] = $filterCategorie;
}
if ($filterBudget > 0) {
    $sql .= " AND prijs <= :budget";
    $params[':budget'] = $filterBudget;
}

$sql .= " ORDER BY aangemaakt_op DESC";
$stmt = $db->prepare($sql);
$stmt->execute($params);
$woningen = $stmt->fetchAll();
?>

<div class="max-w-6xl mx-auto px-4 py-10">

    <p class="text-xs font-semibold uppercase tracking-widest text-oranje mb-1">Woningaanbod</p>
    <h1 class="font-display text-3xl font-bold mb-6">Woningen zoeken</h1>

    <!-- Filterformulier -->
    <form method="GET" action="zoeken.php"
          class="bg-white dark:bg-gray-800 dark:text-gray-200 rounded-xl border border-gray-100 dark:border-gray-700 p-4 mb-8 flex flex-col sm:flex-row flex-wrap gap-3 items-end">

        <!-- Type -->
        <div class="flex flex-col gap-1 w-full sm:flex-1 sm:min-w-[130px]">
            <label class="text-xs font-semibold uppercase tracking-wide text-gedempt">Type</label>
            <select name="type" class="border border-gray-200 dark:border-gray-600 rounded-lg px-3 py-2 text-sm text-ink dark:text-gray-100">
                <option value="">Alle types</option>
                <option value="appartement" <?= $filterType === 'appartement' ? 'selected' : '' ?>>Appartement</option>
                <option value="woning"      <?= $filterType === 'woning' ? 'selected' : '' ?>>Eengezinswoning</option>
                <option value="studio"      <?= $filterType === 'studio' ? 'selected' : '' ?>>Studio</option>
                <option value="kamer"       <?= $filterType === 'kamer' ? 'selected' : '' ?>>Kamer</option>
            </select>
        </div>

        <!-- Stad -->
        <div class="flex flex-col gap-1 w-full sm:flex-1 sm:min-w-[130px]">
            <label class="text-xs font-semibold uppercase tracking-wide text-gedempt">Gemeente</label>
            <select name="stad" class="border border-gray-200 dark:border-gray-600 rounded-lg px-3 py-2 text-sm text-ink dark:text-gray-100">
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
        <div class="flex flex-col gap-1 w-full sm:flex-1 sm:min-w-[130px]">
            <label class="text-xs font-semibold uppercase tracking-wide text-gedempt">Huur / Koop</label>
            <select name="categorie" class="border border-gray-200 dark:border-gray-600 rounded-lg px-3 py-2 text-sm text-ink dark:text-gray-100">
                <option value="">Beide</option>
                <option value="sociaal" <?= $filterCategorie === 'sociaal' ? 'selected' : '' ?>>Huur sociaal</option>
                <option value="vrij"    <?= $filterCategorie === 'vrij' ? 'selected' : '' ?>>Huur vrij sector</option>
                <option value="koop"    <?= $filterCategorie === 'koop' ? 'selected' : '' ?>>Koop</option>
            </select>
        </div>

        <!-- Budget -->
        <div class="flex flex-col gap-1 w-full sm:flex-1 sm:min-w-[130px]">
            <label class="text-xs font-semibold uppercase tracking-wide text-gedempt">Max. budget (€)</label>
            <input type="number" name="budget" value="<?= htmlspecialchars($filterBudget ?: '') ?>"
                   placeholder="Geen max."
                   class="border border-gray-200 dark:border-gray-600 rounded-lg px-3 py-2 text-sm text-ink dark:text-gray-100"
        </div>

        <div class="flex gap-2 w-full sm:w-auto">
            <button type="submit"
                    class="flex-1 sm:flex-none bg-oranje hover:bg-orange-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition-colors">
                Zoeken
            </button>
            <a href="zoeken.php"
               class="flex-1 sm:flex-none border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 text-ink dark:text-gray-100 px-4 py-2 rounded-lg text-sm transition-colors text-center">
                Reset
            </a>
        </div>
    </form>

    <!-- Resultaten -->
    <div class="flex items-center justify-between mb-4">
        <p class="text-sm text-gedempt">
            <strong class="text-ink dark:text-gray-100"><?= count($woningen) ?></strong> woningen gevonden
        </p>

        <?php if (!empty($woningen)): ?>
        <div class="flex gap-2">
            <button onclick="wisselWeergave('grid')" id="btn-grid"
                    class="bg-ink text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors">
                ▦ Grid
            </button>
            <button onclick="wisselWeergave('kaart')" id="btn-kaart"
                    class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 text-ink dark:text-gray-100 px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors hover:bg-gray-50 dark:hover:bg-gray-700">
                🗺 Kaart
            </button>
            <a href="woning-toevoegen.php"
               class="bg-ink hover:bg-ink2 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                + Woning toevoegen
            </a>
        </div>
        <?php endif; ?>
    </div>

    <?php if (empty($woningen)): ?>
        <div class="text-center py-16 text-gedempt">
            <div class="text-5xl mb-4">🏚️</div>
            <p class="text-lg font-semibold text-ink dark:text-gray-100 mb-2">Geen woningen gevonden</p>
            <p class="text-sm">Pas de filters aan of verwijder het maximale budget.</p>
        </div>
    <?php else: ?>
        <!-- Grid-weergave -->
        <div id="view-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($woningen as $w): ?>
                <div class="bg-white dark:bg-gray-800 dark:text-gray-200 rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden hover:shadow-md transition-shadow">

                    <div class="bg-gray-100 h-36 flex items-center justify-center text-4xl">
                        <?= $w['type'] === 'kamer' ? '🛏️' : ($w['type'] === 'studio' ? '🪟' : ($w['categorie'] === 'koop' ? '🏡' : '🏢')) ?>
                    </div>

                    <div class="p-4">
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
                        <?php if ($w['categorie'] === 'sociaal'): ?>
                            <a href="rechten.php" class="text-[10px] text-oranje hover:underline ml-2">Ken je rechten →</a>
                        <?php endif; ?>

                        <h3 class="font-display font-semibold text-base mt-2 mb-1 text-ink dark:text-gray-100 capitalize">
                            <?= htmlspecialchars($w['type']) ?> — <?= ucfirst($w['stad']) ?>
                        </h3>

                        <p class="text-sm text-gedempt mb-3 leading-relaxed">
                            <?= htmlspecialchars($w['omschrijving']) ?>
                        </p>

                        <div class="flex items-center justify-between text-sm">
                            <div class="text-gedempt">
                                🛏 <?= $w['kamers'] ?> kamer<?= $w['kamers'] > 1 ? 's' : '' ?> · 📐 <?= $w['oppervlak'] ?> m²
                            </div>
                            <div class="font-display font-bold text-oranje">
                                <?= $w['categorie'] === 'koop'
                                    ? '€ ' . number_format($w['prijs'], 0, ',', '.')
                                    : '€ ' . $w['prijs'] . '/mnd' ?>
                            </div>
                        </div>

                        <div class="flex gap-2 mt-3 pt-3 border-t border-gray-100">
                            <a href="woning-detail.php?id=<?= $w['id'] ?>"
                               class="flex-1 text-center text-xs font-semibold py-1.5 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
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

        <!-- Kaart-weergave -->
        <div id="view-kaart" class="hidden rounded-xl border border-gray-100 overflow-hidden" style="height: 500px;">
            <div id="kaart-container" style="height: 100%;"></div>
        </div>
    <?php endif; ?>

</div>

<script>
var kaart = null;
var markers = [];

function wisselWeergave(mode) {
    var grid = document.getElementById('view-grid');
    var kaartView = document.getElementById('view-kaart');
    var btnGrid = document.getElementById('btn-grid');
    var btnKaart = document.getElementById('btn-kaart');

    if (mode === 'kaart') {
        grid.classList.add('hidden');
        kaartView.classList.remove('hidden');
        btnGrid.classList.remove('bg-ink', 'text-white');
        btnGrid.classList.add('bg-white', 'border', 'border-gray-200', 'text-ink');
        btnKaart.classList.remove('bg-white', 'border', 'border-gray-200', 'text-ink');
        btnKaart.classList.add('bg-ink', 'text-white');
        initKaart();
    } else {
        kaartView.classList.add('hidden');
        grid.classList.remove('hidden');
        btnKaart.classList.remove('bg-ink', 'text-white');
        btnKaart.classList.add('bg-white', 'border', 'border-gray-200', 'text-ink');
        btnGrid.classList.remove('bg-white', 'border', 'border-gray-200', 'text-ink');
        btnGrid.classList.add('bg-ink', 'text-white');
    }
}

function initKaart() {
    if (kaart) {
        kaart.invalidateSize();
        return;
    }

    kaart = L.map('kaart-container').setView([52.1, 5.3], 8);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: '&copy; OpenStreetMap'
    }).addTo(kaart);

    var woningen = <?= json_encode(array_values($woningen), JSON_UNESCAPED_UNICODE) ?>;

    woningen.forEach(function (w) {
        if (!w.lat || !w.lng) return;

        var prijs = w.categorie === 'koop'
            ? '€ ' + Number(w.prijs).toLocaleString('nl-NL')
            : '€ ' + w.prijs + '/mnd';

        var marker = L.marker([w.lat, w.lng]).addTo(kaart);
        marker.bindPopup(
            '<strong style="font-size:14px;">' + w.type.charAt(0).toUpperCase() + w.type.slice(1) + ' &mdash; ' + w.stad.charAt(0).toUpperCase() + w.stad.slice(1) + '</strong><br>' +
            w.omschrijving + '<br>' +
            '🛏 ' + w.kamers + ' kamer' + (w.kamers > 1 ? 's' : '') + ' · 📐 ' + w.oppervlak + ' m²<br>' +
            '<span style="color:#E8650A;font-weight:bold;">' + prijs + '</span><br>' +
            '<a href="woning-detail.php?id=' + w.id + '" style="font-size:12px;color:#E8650A;">→ Bekijken</a>'
        );
        markers.push(marker);
    });

    if (markers.length > 0) {
        var group = L.featureGroup(markers);
        kaart.fitBounds(group.getBounds().pad(0.1));
    } else {
        kaart.setView([52.1, 5.3], 8);
    }
}

document.addEventListener('DOMContentLoaded', function () {
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('kaart') === '1') {
        wisselWeergave('kaart');
    }
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>