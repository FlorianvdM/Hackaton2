<?php
$paginaTitel = 'Woning detail';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/db.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$db = getDb();
$stmt = $db->prepare("SELECT * FROM woningen WHERE id = :id");
$stmt->execute([':id' => $id]);
$woning = $stmt->fetch();
?>

<div class="max-w-4xl mx-auto px-4 py-10">

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
        <?php
        $badgeKleur = match ($woning['categorie']) {
            'sociaal' => 'bg-green-100 text-green-800',
            'vrij' => 'bg-orange-100 text-orange-800',
            'koop' => 'bg-blue-100 text-blue-800',
            default => 'bg-gray-100 text-gray-600',
        };
        $catLabel = match ($woning['categorie']) {
            'sociaal' => 'Sociale huur',
            'vrij' => 'Vrije sector',
            'koop' => 'Koop',
            default => $woning['categorie'],
        };
        ?>
        <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
            <div class="bg-gray-100 h-56 flex items-center justify-center text-6xl">
                <?= $woning['type'] === 'kamer' ? '🛏️' : ($woning['type'] === 'studio' ? '🪟' : ($woning['categorie'] === 'koop' ? '🏡' : '🏢')) ?>
            </div>
            <div class="p-6">
                <div class="flex items-center gap-2 mb-3">
                    <span class="<?= $badgeKleur ?> text-xs font-semibold px-2 py-0.5 rounded"><?= $catLabel ?></span>
                    <span class="text-xs text-gedempt capitalize"><?= $woning['type'] ?></span>
                </div>
                <h1 class="font-display text-2xl font-bold mb-1 capitalize"><?= $woning['type'] ?> — <?= ucfirst($woning['stad']) ?></h1>
                <p class="text-sm text-gedempt mb-6"><?= htmlspecialchars($woning['omschrijving']) ?></p>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-6">
                    <div class="bg-room rounded-xl p-4 text-center">
                        <p class="text-xs text-gedempt">Prijs</p>
                        <p class="font-display font-bold text-lg text-oranje">
                            <?= $woning['categorie'] === 'koop' ? '€ ' . number_format($woning['prijs'], 0, ',', '.') : '€ ' . $woning['prijs'] . '/mnd' ?>
                        </p>
                    </div>
                    <div class="bg-room rounded-xl p-4 text-center">
                        <p class="text-xs text-gedempt">Kamers</p>
                        <p class="font-display font-bold text-lg"><?= $woning['kamers'] ?></p>
                    </div>
                    <div class="bg-room rounded-xl p-4 text-center">
                        <p class="text-xs text-gedempt">Oppervlak</p>
                        <p class="font-display font-bold text-lg"><?= $woning['oppervlak'] ?> m²</p>
                    </div>
                </div>

                <?php if ($woning['categorie'] === 'sociaal'): ?>
                    <div class="bg-orange-50 border border-orange-200 rounded-xl p-4 mb-6">
                        <p class="text-sm text-orange-900">
                            💡 Dit is een sociale huurwoning. <a href="rechten.php" class="font-semibold underline">Bekijk je rechten als huurder →</a>
                        </p>
                    </div>
                <?php endif; ?>

                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="woning-bewerken.php?id=<?= $id ?>" class="sm:flex-1 text-center border border-blue-200 text-blue-700 hover:bg-blue-50 px-5 py-2.5 rounded-lg text-sm font-semibold transition-colors">Bewerken</a>
                    <a href="woning-verwijderen.php?id=<?= $id ?>" class="sm:flex-1 text-center border border-red-200 text-red-600 hover:bg-red-50 px-5 py-2.5 rounded-lg text-sm font-semibold transition-colors" onclick="return confirm('Weet je zeker dat je deze woning wilt verwijderen?')">Verwijderen</a>
                </div>
            </div>
        </div>

        <div class="mt-6 bg-white rounded-xl border border-gray-100 overflow-hidden p-6">
            <h3 class="font-display font-semibold text-base mb-4">📍 Locatie</h3>
            <div id="detail-kaart" style="height: 300px;" class="rounded-xl border border-gray-100"></div>
        </div>
    <?php endif; ?>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var woning = <?= json_encode($woning, JSON_UNESCAPED_UNICODE) ?>;
    if (!woning) return;

    var kaart = L.map('detail-kaart').setView([woning.lat, woning.lng], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: '&copy; OpenStreetMap'
    }).addTo(kaart);

    var prijs = woning.categorie === 'koop'
        ? '€ ' + Number(woning.prijs).toLocaleString('nl-NL')
        : '€ ' + woning.prijs + '/mnd';

    L.marker([woning.lat, woning.lng]).addTo(kaart)
        .bindPopup(
            '<strong>' + woning.type.charAt(0).toUpperCase() + woning.type.slice(1) + '</strong><br>' +
            'Prijs: ' + prijs + '<br>' +
            woning.omschrijving
        )
        .openPopup();
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
