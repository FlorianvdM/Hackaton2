<?php
// ============================================================
// pages/rechten.php — Huurrechten & wetgeving
// Eerstejaars: HTML + PHP arrays, JS FAQ-accordion
// ============================================================

$paginaTitel = 'Huurrechten';
require_once __DIR__ . '/../includes/header.php';

// Rechtenkaarten data (eerstejaars: in echte versie uit database lezen)
$rechten = [
    [
        'icoon' => '🛡️',
        'titel' => 'Huurbescherming',
        'tekst' => 'Je huurcontract kan niet zomaar worden opgezegd door de verhuurder. Opzegging is alleen geldig in specifieke gevallen (eigen gebruik, slecht huurderschap). Tijdelijke contracten zijn na 2 jaar automatisch vast.',
        'link' => 'https://www.rijksoverheid.nl/onderwerpen/woning-huren/vraag-en-antwoord/welke-mogelijkheden-heb-ik-als-huurder-om-mijn-huurcontract-op-te-zeggen',
    ],
    [
        'icoon' => '🔧',
        'titel' => 'Onderhoud & gebreken',
        'tekst' => 'De verhuurder is verantwoordelijk voor groot onderhoud. Weigert hij? Meld het bij de Huurcommissie of gemeentelijke handhaving. Bij ernstige gebreken kun je huurverlaging aanvragen.',
        'link' => 'https://www.huurcommissie.nl/onderwerpen/onderhoud-en-gebreken',
    ],
    [
        'icoon' => '📈',
        'titel' => 'Huurverhoging aanvechten',
        'tekst' => 'De maximale huurverhoging voor sociale huur is wettelijk vastgesteld. In 2024: max. 5,8% voor zelfstandige woningen. Een hogere verhoging is aanvechtbaar via de Huurcommissie.',
        'link' => 'bereken.php',
    ],
    [
        'icoon' => '💰',
        'titel' => 'Borg terugkrijgen',
        'tekst' => 'De verhuurder moet de borg terugbetalen na vertrek, tenzij er aantoonbare schade is. Normale slijtage telt niet. Conflict? Stap naar de Huurcommissie of de kantonrechter.',
        'link' => 'https://www.juridischloket.nl/wonen-en-buren/huurwoning/borg-terugkrijgen/',
    ],
    [
        'icoon' => '⚖️',
        'titel' => 'Huurcommissie',
        'tekst' => 'De Huurcommissie behandelt geschillen over huurprijs, gebreken en servicekosten. Een procedure kost je slechts € 25 als huurder. Uitspraken zijn bindend voor de verhuurder.',
        'link' => 'https://www.huurcommissie.nl/',
    ],
    [
        'icoon' => '📄',
        'titel' => 'Servicekosten',
        'tekst' => 'Verhuurders mogen alleen werkelijke kosten doorberekenen (gas, water, licht, schoonmaak). Je hebt recht op een jaarlijkse afrekening. Te veel betaald? Je krijgt het terug.',
        'link' => 'https://www.rijksoverheid.nl/onderwerpen/huurprijs-en-servicekosten/servicekosten-en-nutsvoorzieningen',
    ],
];

// FAQ data
$vragen = [
    [
        'vraag' => 'Mag een verhuurder een tijdelijk contract aanbieden?',
        'antwoord' => 'Ja, maar alleen voor zelfstandige woningen en voor maximaal 2 jaar. Na 2 jaar wordt het contract automatisch omgezet naar een vast huurcontract. Voor onzelfstandige kamers geldt een maximum van 5 jaar. Daarna heeft de huurder volledige huurbescherming.',
    ],
    [
        'vraag' => 'Wat doe ik als mijn verhuurder het pand verwaarloosd?',
        'antwoord' => 'Meld gebreken eerst schriftelijk aan de verhuurder. Reageert hij niet binnen 6 weken? Dan kun je naar de Huurcommissie voor een huurverlaging, of naar de gemeentelijke toezichthouder (handhaving bouw- en woningtoezicht) voor een inspectie en eventuele bestuursdwang.',
    ],
    [
        'vraag' => 'Kan ik als starter een woning kopen?',
        'antwoord' => 'Het is moeilijk maar niet onmogelijk. Voordelen: startersvrijstelling overdrachtsbelasting (t/m € 510.000), NHG garantie, Starterslening van gemeenten. Beperkingen: hoge woningprijzen, hogere rentes. Zoek een onafhankelijk hypotheekadviseur voor jouw situatie.',
    ],
    [
        'vraag' => 'Hoe registreer ik me voor sociale huur?',
        'antwoord' => 'Registreer je zo vroeg mogelijk bij de woningcorporatie in jouw regio. In grote steden via Woningnet (Amsterdam/Utrecht) of WoonMatch (Rotterdam). Hoe eerder je je inschrijft, hoe meer inschrijftijd je opbouwt — wat je kansen vergroot. Inschrijven is kosteloos of kost een kleine jaarlijkse bijdrage.',
    ],
    [
        'vraag' => 'Wat is het puntenstelsel?',
        'antwoord' => 'Het woningwaarderingsstelsel (WWS) bepaalt de maximale huurprijs van sociale huurwoningen op basis van kwaliteitspunten. Punten worden toegekend voor oppervlak, isolatie, keuken, badkamer, buitenruimte en locatie. Heeft een woning 144 punten of minder, dan valt ze in de sociale sector.',
    ],
    [
        'vraag' => 'Mag mijn verhuurder zomaar de huur verhogen?',
        'antwoord' => 'Nee. Huurverhoging mag maximaal eenmaal per jaar. De maximale verhoging voor sociale huur is wettelijk vastgesteld (in 2024: 5,8%). Vrije sector: de huurverhoging is vrij, maar jij kunt naar de Huurcommissie als de verhoging onredelijk is. Binnen 6 weken na ontvangst van de aanzegging kun je bezwaar maken.',
    ],
];
?>

<div class="max-w-6xl mx-auto px-4 py-10">

    <p class="text-xs font-semibold uppercase tracking-widest text-oranje mb-1">Huurrechten & wetgeving</p>
    <h1 class="font-display text-3xl font-bold mb-2">Wat zijn jouw rechten?</h1>
    <p class="text-gedempt text-base max-w-lg mb-8">
        Als huurder heb je meer rechten dan veel mensen denken.
        Hier zijn de belangrijkste — inclusief wat je kunt doen als ze worden geschonden.
    </p>

    <!-- Rechtenkaarten grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-12">
        <?php foreach ($rechten as $r): ?>
            <div class="bg-white rounded-xl border-l-4 border-l-oranje border border-gray-100 p-5">
                <div class="text-2xl mb-3"><?= $r['icoon'] ?></div>
                <h3 class="font-display font-semibold text-base text-ink mb-2">
                    <?= htmlspecialchars($r['titel']) ?>
                </h3>
                <p class="text-sm text-gedempt leading-relaxed mb-3">
                    <?= htmlspecialchars($r['tekst']) ?>
                </p>
                <a href="<?= $r['link'] ?>" class="text-oranje text-xs font-semibold hover:underline">
                    → Meer informatie
                </a>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Alert: Wet betaalbare huur -->
    <div class="bg-orange-50 border border-orange-200 rounded-xl p-4 mb-8 flex gap-3 text-orange-900">
        <span class="text-xl shrink-0">⚠️</span>
        <div>
            <p class="font-semibold text-sm mb-1">Wet betaalbare huur — van kracht per 1 juli 2024</p>
            <p class="text-sm">Woningen met ≤ 186 punten vallen nu onder het gereguleerde segment, ook al werd er meer dan € 879 per maand gevraagd. Huurders kunnen hun huur laten toetsen bij de Huurcommissie.</p>
        </div>
    </div>

    <!-- FAQ -->
    <h2 class="font-display text-xl font-bold mb-4">Veelgestelde vragen</h2>
    <div class="bg-white rounded-xl border border-gray-100 divide-y divide-gray-100 mb-8" id="faq">
        <?php foreach ($vragen as $i => $v): ?>
            <div class="faq-item">
                <button onclick="wisselFaq(<?= $i ?>)"
                        class="w-full flex justify-between items-center px-5 py-4 text-left font-display font-semibold text-sm text-ink hover:text-oranje transition-colors">
                    <?= htmlspecialchars($v['vraag']) ?>
                    <span class="text-oranje text-xl ml-4 shrink-0" id="faq-icoon-<?= $i ?>">+</span>
                </button>
                <div id="faq-antwoord-<?= $i ?>" class="hidden px-5 pb-4 text-sm text-gedempt leading-relaxed">
                    <?= htmlspecialchars($v['antwoord']) ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Extra CTA's voor onderlinge linking -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <a href="bereken.php" class="bg-white border border-gray-100 rounded-xl p-5 hover:shadow-md transition-shadow group">
            <h4 class="font-display font-bold text-ink group-hover:text-oranje transition-colors mb-2">Check je huurprijs</h4>
            <p class="text-sm text-gedempt">Gebruik onze huurcheck tool om te zien of je niet te veel betaalt voor je woning.</p>
        </a>
        <a href="zoeken.php" class="bg-white border border-gray-100 rounded-xl p-5 hover:shadow-md transition-shadow group">
            <h4 class="font-display font-bold text-ink group-hover:text-oranje transition-colors mb-2">Zoek een nieuwe woning</h4>
            <p class="text-sm text-gedempt">Bekijk het actuele aanbod van sociale en vrije sector huurwoningen.</p>
        </a>
    </div>

</div>

<script>
function wisselFaq(index) {
    const antwoord = document.getElementById('faq-antwoord-' + index);
    const icoon    = document.getElementById('faq-icoon-' + index);
    const open     = !antwoord.classList.contains('hidden');
    antwoord.classList.toggle('hidden', open);
    icoon.textContent = open ? '+' : '−';
}
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>