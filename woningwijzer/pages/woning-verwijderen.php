<?php
$paginaTitel = 'Woning verwijderen';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/db.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$verwijderd = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id > 0) {
    $verwijderd = true;
}
?>

<div class="max-w-2xl mx-auto px-4 py-10">

    <a href="zoeken.php" class="text-sm text-gedempt hover:text-ink mb-6 inline-flex items-center gap-1">
        ← Terug naar overzicht
    </a>

    <?php if ($verwijderd): ?>
        <div class="bg-green-50 border border-green-200 text-green-800 rounded-xl p-6 text-center">
            <div class="text-5xl mb-4">🗑️</div>
            <h1 class="font-display text-2xl font-bold mb-2">Woning verwijderd</h1>
            <p class="text-sm mb-4">De woning is succesvol verwijderd uit het systeem.</p>
            <a href="zoeken.php" class="bg-oranje hover:bg-orange-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition-colors inline-block">
                ← Terug naar overzicht
            </a>
        </div>
    <?php else: ?>
        <div class="bg-white rounded-xl border border-gray-100 p-6 text-center">
            <div class="text-5xl mb-4">⚠️</div>
            <h1 class="font-display text-2xl font-bold mb-2">Weet je het zeker?</h1>
            <p class="text-gedempt mb-6">Je staat op het punt woning <strong>#<?= $id ?></strong> te verwijderen. Dit kan niet ongedaan worden gemaakt.</p>
            <form method="POST" action="woning-verwijderen.php?id=<?= $id ?>" class="flex gap-3 justify-center">
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2.5 rounded-lg text-sm font-semibold transition-colors">
                    Ja, verwijderen
                </button>
                <a href="zoeken.php" class="border border-gray-200 hover:bg-gray-50 text-ink px-5 py-2.5 rounded-lg text-sm transition-colors">Annuleren</a>
            </form>
        </div>
    <?php endif; ?>

</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
