<?php
$paginaTitel = 'Over de crisis';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="max-w-6xl mx-auto px-4 py-10">

    <p class="text-xs font-semibold uppercase tracking-widest text-oranje mb-1">Over de crisis</p>
    <h1 class="font-display text-3xl font-bold mb-2">Waarom Nederland een woningcrisis heeft</h1>
    <p class="text-gedempt text-base max-w-lg mb-8">
        Al jaren is er te weinig betaalbare woonruimte. Hoe is het zover gekomen? En wat zijn de belangrijkste oorzaken?
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">

        <div class="bg-white rounded-xl border border-gray-100 p-6">
            <h2 class="font-display font-semibold text-lg mb-3">📈 Oorzaken</h2>
            <ul class="space-y-4 text-sm text-gedempt">
                <li class="flex gap-3">
                    <span class="font-bold text-oranje shrink-0">1.</span>
                    <span><strong class="text-ink">Te weinig bouwen</strong> — Sinds 2010 zijn er structureel te weinig woningen gebouwd. Doel was 100.000 per jaar, maar de realiteit lag vaak rond de 60.000–70.000.</span>
                </li>
                <li class="flex gap-3">
                    <span class="font-bold text-oranje shrink-0">2.</span>
                    <span><strong class="text-ink">Groeiende bevolking</strong> — Meer mensen, kleinere huishoudens, immigratie: de vraag naar woningen stijgt sneller dan het aanbod.</span>
                </li>
                <li class="flex gap-3">
                    <span class="font-bold text-oranje shrink-0">3.</span>
                    <span><strong class="text-ink">Stikstofcrisis</strong> — Door stikstofregels komen bouwprojecten stil te liggen. Vergunningen worden vertraagd of ingetrokken.</span>
                </li>
                <li class="flex gap-3">
                    <span class="font-bold text-oranje shrink-0">4.</span>
                    <span><strong class="text-ink">Beleggers en buy-to-let</strong> — Beleggers kochten grote aantallen woningen op, waardoor starters en middeninkomens worden buitengesloten.</span>
                </li>
                <li class="flex gap-3">
                    <span class="font-bold text-oranje shrink-0">5.</span>
                    <span><strong class="text-ink">Liberalisatie huurmarkt</strong> — Sinds 2015 is de sociale huursector fors gekrompen. Veel woningen zijn overgeheveld naar de dure vrije sector.</span>
                </li>
            </ul>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 p-6">
            <h2 class="font-display font-semibold text-lg mb-3">🔢 De cijfers</h2>
            <div class="grid grid-cols-2 gap-3">
                <?php
                $cijfers = [
                    ['getal' => '390.000', 'label' => 'Woningtekort', 'kleur' => 'text-red-600'],
                    ['getal' => '7,5 jaar', 'label' => 'Gem. wachttijd sociale huur', 'kleur' => 'text-red-600'],
                    ['getal' => '€ 1.850', 'label' => 'Gem. huur Amsterdam (vrij)', 'kleur' => 'text-oranje'],
                    ['getal' => '52%', 'label' => 'Starters komen niet aan bod', 'kleur' => 'text-red-600'],
                    ['getal' => '24%', 'label' => 'Inkomen naar huur', 'kleur' => 'text-oranje'],
                    ['getal' => '100.000', 'label' => 'Nieuwbouw nodig per jaar', 'kleur' => 'text-green-600'],
                ];
                foreach ($cijfers as $c):
                ?>
                    <div class="bg-room rounded-xl p-4 text-center">
                        <div class="font-display text-2xl font-bold <?= $c['kleur'] ?> leading-none mb-1"><?= $c['getal'] ?></div>
                        <div class="text-xs text-gedempt"><?= $c['label'] ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>

    <div class="bg-orange-50 border border-orange-200 rounded-xl p-6 mb-12">
        <h2 class="font-display font-semibold text-lg mb-3">⚡ Wat er moet gebeuren</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
            <div class="bg-white rounded-xl p-4">
                <p class="font-bold text-ink mb-1">🏗️ Versneld bouwen</p>
                <p class="text-gedempt">Meer locaties vrijmaken, bouwvergunningen versnellen en stikstofregels hervormen zodat er wél gebouwd kan worden.</p>
            </div>
            <div class="bg-white rounded-xl p-4">
                <p class="font-bold text-ink mb-1">🛑 Beleggers weren</p>
                <p class="text-gedempt">Woningen zijn voor bewoners, niet voor beleggers. Inkoop door investeerders moet aan banden worden gelegd.</p>
            </div>
            <div class="bg-white rounded-xl p-4">
                <p class="font-bold text-ink mb-1">🧑‍⚖️ Huurders beschermen</p>
                <p class="text-gedempt">De Wet betaalbare huur moet worden versterkt. Huurgeschillen moeten sneller en eenvoudiger worden behandeld.</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <a href="actie.php" class="bg-white border border-gray-100 rounded-xl p-5 hover:shadow-md transition-shadow group">
            <h4 class="font-display font-bold text-ink group-hover:text-oranje transition-colors mb-2">📢 Kom in actie</h4>
            <p class="text-sm text-gedempt">Teken de petitie, schrijf je volksvertegenwoordiger en help de crisis oplossen.</p>
        </a>
        <a href="nieuws.php" class="bg-white border border-gray-100 rounded-xl p-5 hover:shadow-md transition-shadow group">
            <h4 class="font-display font-bold text-ink group-hover:text-oranje transition-colors mb-2">📰 Laatste nieuws</h4>
            <p class="text-sm text-gedempt">Blijf op de hoogte van de laatste ontwikkelingen op de woningmarkt.</p>
        </a>
        <a href="rechten.php" class="bg-white border border-gray-100 rounded-xl p-5 hover:shadow-md transition-shadow group">
            <h4 class="font-display font-bold text-ink group-hover:text-oranje transition-colors mb-2">⚖️ Ken je rechten</h4>
            <p class="text-sm text-gedempt">Ontdek wat jouw rechten zijn als huurder en hoe je ze kunt beschermen.</p>
        </a>
    </div>

</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
