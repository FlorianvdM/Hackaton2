<?php
// ============================================================
// index.php — Homepage WoningWijzer
// Eerstejaars: HTML structuur, Tailwind CSS, JS interactiviteit
// ============================================================

require_once '../includes/db.php'; // database connectie

$paginaTitel = 'Home';
include 'includes/header.php';


?>

<!-- HERO -->
<section class="bg-ink text-white relative overflow-hidden py-24 px-4">
    <!-- Decoratieve achtergrond-glow -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-oranje/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-4xl mx-auto text-center relative z-10">

        <span class="inline-block bg-oranje/20 text-oranje text-xs font-semibold uppercase tracking-widest px-3 py-1 rounded mb-6">
            Woningcrisis in Nederland
        </span>

        <h1 class="font-display text-4xl md:text-5xl font-bold leading-tight mb-6">
            Er zijn <span class="text-oranje" id="tekort-teller">390.000</span> woningen tekort.<br>
            Wij helpen je verder.
        </h1>

        <p class="text-white/60 text-lg max-w-xl mx-auto mb-10">
            Vind een woning, ken je rechten, bereken je mogelijkheden
            — en draag bij aan structurele oplossingen.
        </p>

        <!-- Statistieken tellers -->
        <div class="flex flex-wrap justify-center gap-4 mb-12">
            <?php
            // Statistieken data — eerstejaars: lees dit later uit de database (READ)
            $statistieken = [
                ['getal' => '390.000', 'label' => 'Woningtekort'],
                ['getal' => '7,5 jr', 'label' => 'Gem. wachttijd sociaal'],
                ['getal' => '€ 1.850', 'label' => 'Gem. vrije huur Amsterdam'],
                ['getal' => '24%', 'label' => 'Inkomen kwijt aan huur'],
            ];
            foreach ($statistieken as $stat):
                ?>
                <div class="bg-white/6 border border-white/10 rounded-xl px-6 py-4 min-w-[150px]">
                    <span class="font-display text-3xl font-bold text-oranje block leading-none mb-1">
                        <?= htmlspecialchars($stat['getal']) ?>
                    </span>
                    <span class="text-xs text-white/50 uppercase tracking-wide">
                        <?= htmlspecialchars($stat['label']) ?>
                    </span>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Snelzoek -->
        <form action="/pages/zoeken.php" method="GET"
              class="bg-white rounded-xl p-3 flex flex-wrap gap-2 max-w-2xl mx-auto">

            <select name="type" class="flex-1 min-w-[120px] border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-ink">
                <option value="">Type woning</option>
                <option value="appartement">Appartement</option>
                <option value="woning">Eengezinswoning</option>
                <option value="studio">Studio</option>
                <option value="kamer">Kamer</option>
            </select>

            <select name="stad" class="flex-1 min-w-[120px] border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-ink">
                <option value="">Gemeente</option>
                <option value="amsterdam">Amsterdam</option>
                <option value="rotterdam">Rotterdam</option>
                <option value="utrecht">Utrecht</option>
                <option value="denhaag">Den Haag</option>
                <option value="eindhoven">Eindhoven</option>
                <option value="groningen">Groningen</option>
            </select>

            <select name="categorie" class="flex-1 min-w-[120px] border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-ink">
                <option value="">Huur / Koop</option>
                <option value="sociaal">Huur sociaal</option>
                <option value="vrij">Huur vrij sector</option>
                <option value="koop">Koop</option>
            </select>

            <input type="number" name="budget" placeholder="Max. budget (€)" min="0"
                   class="flex-1 min-w-[130px] border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-ink">

            <button type="submit"
                    class="bg-oranje hover:bg-orange-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition-colors whitespace-nowrap">
                🔍 Zoeken
            </button>
        </form>

    </div>
</section>

<!-- STATISTIEKEN BLOK -->
<section class="py-16 px-4">
    <div class="max-w-6xl mx-auto">

        <p class="text-xs font-semibold uppercase tracking-widest text-oranje mb-1">De crisis in cijfers</p>
        <h2 class="font-display text-3xl font-bold mb-2">Hoe erg is het echt?</h2>
        <p class="text-gedempt text-base max-w-lg mb-8">
            De feiten spreken voor zich. Nederland heeft structureel te weinig woningen — en de druk neemt toe.
        </p>

        <!-- Stat kaarten -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-3 mb-10">
            <?php
            $stats = [
                ['getal' => '390.000', 'label' => 'Woningen tekort (2024)', 'kleur' => 'text-red-600'],
                ['getal' => '7,5 jr', 'label' => 'Gem. wachttijd sociale huur', 'kleur' => 'text-red-600'],
                ['getal' => '+18%', 'label' => 'Huurprijsstijging 3 jaar', 'kleur' => 'text-oranje'],
                ['getal' => '52%', 'label' => 'Starters buiten de boot', 'kleur' => 'text-oranje'],
                ['getal' => '100.000', 'label' => 'Nieuwbouw gepland/jaar', 'kleur' => 'text-green-600'],
            ];
            foreach ($stats as $s):
                ?>
                <div class="bg-white rounded-xl p-4 border border-gray-100">
                    <div class="font-display text-2xl font-bold <?= $s['kleur'] ?> mb-1 leading-none">
                        <?= htmlspecialchars($s['getal']) ?>
                    </div>
                    <div class="text-xs text-gedempt"><?= htmlspecialchars($s['label']) ?></div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Navigatiekaarten naar pagina's -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            <?php
            $kaarten = [
                [
                    'icoon' => '🔍',
                    'titel' => 'Woning zoeken',
                    'tekst' => 'Filter op type, gemeente, huur of koop en budget. Overzicht van alle beschikbare woningen.',
                    'link' => '/pages/zoeken.php',
                    'kleur' => 'bg-blue-50',
                ],
                [
                    'icoon' => '🧮',
                    'titel' => 'Hypotheek & huurcheck',
                    'tekst' => 'Bereken je maximale hypotheek, check of je huur redelijk is en ontdek je recht op huurtoeslag.',
                    'link' => '/pages/rekenen.php',
                    'kleur' => 'bg-green-50',
                ],
                [
                    'icoon' => '⚖️',
                    'titel' => 'Ken je rechten',
                    'tekst' => 'Als huurder heb je meer rechten dan je denkt. Lees alles over huurbescherming en huurcommissie.',
                    'link' => '/pages/rechten.php',
                    'kleur' => 'bg-orange-50',
                ],
                [
                    'icoon' => '📰',
                    'titel' => 'Nieuws & beleid',
                    'tekst' => 'Blijf op de hoogte van de laatste wetswijzigingen, beleid en ontwikkelingen op de woningmarkt.',
                    'link' => '/pages/nieuws.php',
                    'kleur' => 'bg-purple-50',
                ],
                [
                    'icoon' => '📢',
                    'titel' => 'Doe mee & actie',
                    'tekst' => 'Teken de petitie, schrijf je volksvertegenwoordiger en meld misstanden op de woningmarkt.',
                    'link' => '/pages/actie.php',
                    'kleur' => 'bg-red-50',
                ],
                [
                    'icoon' => '🔔',
                    'titel' => 'Meldingen',
                    'tekst' => 'Beheer je meldingen van misstanden, discriminatie of illegale praktijken. CRUD-overzicht.',
                    'link' => '/pages/meldingen.php',
                    'kleur' => 'bg-yellow-50',
                ],
            ];
            foreach ($kaarten as $k):
                ?>
                <a href="<?= $k['link'] ?>"
                   class="<?= $k['kleur'] ?> rounded-xl p-5 border border-gray-100 hover:shadow-md transition-shadow group block">
                    <div class="text-3xl mb-3"><?= $k['icoon'] ?></div>
                    <h3 class="font-display font-semibold text-base text-ink mb-2 group-hover:text-oranje transition-colors">
                        <?= htmlspecialchars($k['titel']) ?>
                    </h3>
                    <p class="text-sm text-gedempt leading-relaxed"><?= htmlspecialchars($k['tekst']) ?></p>
                </a>
            <?php endforeach; ?>
        </div>

    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>