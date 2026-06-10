<?php
// ============================================================
// pages/bereken.php — Berekeningstools
// Eerstejaars: HTML forms, JavaScript berekeningen
// ============================================================

$paginaTitel = 'Bereken';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="max-w-6xl mx-auto px-4 py-10">

    <p class="text-xs font-semibold uppercase tracking-widest text-oranje mb-1">Berekeningstools</p>
    <h1 class="font-display text-3xl font-bold mb-2">Wat kan jij je veroorloven?</h1>
    <p class="text-gedempt text-base max-w-lg mb-8">
        Bereken je maximale hypotheek, check of je huur redelijk is en ontdek je recht op huurtoeslag.
    </p>

    <!-- Tab navigatie -->
    <div class="flex gap-1 border-b border-gray-200 mb-8 overflow-x-auto -mx-4 px-4 scrollbar-hide" id="tabs">
        <button onclick="wisselTab('hypotheek')"
                id="tab-hypotheek"
                class="tab-knop actief-tab px-4 py-2.5 text-sm font-medium rounded-t-lg border-b-2 transition-colors shrink-0">
            🏦 Hypotheek
        </button>
        <button onclick="wisselTab('huurcheck')"
                id="tab-huurcheck"
                class="tab-knop inactief-tab px-4 py-2.5 text-sm font-medium rounded-t-lg border-b-2 transition-colors shrink-0">
            🔍 Huurcheck
        </button>
        <button onclick="wisselTab('toeslag')"
                id="tab-toeslag"
                class="tab-knop inactief-tab px-4 py-2.5 text-sm font-medium rounded-t-lg border-b-2 transition-colors shrink-0">
            💰 Huurtoeslag
        </button>
    </div>

    <!-- ======== TAB 1: Hypotheek ======== -->
    <div id="paneel-hypotheek" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl border border-gray-100 p-6">
            <h2 class="font-display font-semibold text-lg mb-4">Maximale hypotheek berekenen</h2>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-gedempt mb-1">Bruto jaarsalaris (€)</label>
                    <input type="number" id="hyp-sal" value="42000" oninput="berekenHypotheek()"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-ink">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-gedempt mb-1">Partner salaris (€) — optioneel</label>
                    <input type="number" id="hyp-sal2" value="0" oninput="berekenHypotheek()"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-ink">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-gedempt mb-1">Rentevoet (%)</label>
                    <input type="number" id="hyp-rente" value="4.3" step="0.1" oninput="berekenHypotheek()"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-ink">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-gedempt mb-1">Looptijd (jaren)</label>
                    <input type="number" id="hyp-looptijd" value="30" min="10" max="30" oninput="berekenHypotheek()"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-ink">
                </div>
            </div>

            <!-- Resultaat -->
            <div class="bg-ink rounded-xl p-4 mt-5 text-white">
                <p class="text-xs text-white/50 uppercase tracking-wide">Maximale hypotheek</p>
                <p class="font-display text-3xl font-bold text-oranje my-1" id="hyp-uitkomst">€ 176.400</p>
                <div class="flex justify-between items-end">
                    <p class="text-xs text-white/50" id="hyp-toelichting">Maandlast ca. € 876 · 4.2× jaarsalaris</p>
                    <a href="zoeken.php?categorie=koop" class="text-xs bg-white/10 hover:bg-white/20 text-white px-2 py-1 rounded transition-colors">
                        Zoek koopwoningen →
                    </a>
                </div>
            </div>
        </div>

        <div class="space-y-3">
            <h3 class="font-display font-semibold text-base">Handige aandachtspunten</h3>
            <?php
            $tips = [
                ['kleur' => 'bg-green-100 text-green-800', 'titel' => 'NHG-garantie', 'tekst' => 'Bij een hypotheek onder € 435.000 kom je mogelijk in aanmerking voor de Nationale Hypotheek Garantie. Dit verlaagt je rente met 0,4–0,6%.'],
                ['kleur' => 'bg-orange-100 text-orange-800', 'titel' => 'Eigen inbreng', 'tekst' => 'Banken financieren maximaal 100% van de woningwaarde. Bijkomende kosten (2–5%) betaal je zelf: notaris, overdrachtsbelasting, taxatie.'],
                ['kleur' => 'bg-blue-100 text-blue-800', 'titel' => 'Startersvrijstelling', 'tekst' => 'Kopers jonger dan 35 jaar betalen geen overdrachtsbelasting bij woningen onder € 510.000. Dat scheelt al snel € 10.000+.'],
                ['kleur' => 'bg-red-100 text-red-800', 'titel' => 'Schulden wegen mee', 'tekst' => 'Studentenlening, auto, creditcard — al je schulden verlagen je maximale hypotheek. Plan dit mee in je berekening.'],
            ];
            foreach ($tips as $tip):
                ?>
                <div class="bg-white rounded-xl border border-gray-100 p-4 flex gap-3">
                    <span class="<?= $tip['kleur'] ?> text-xs font-bold px-2 py-0.5 rounded h-fit shrink-0">
                        <?= $tip['titel'] ?>
                    </span>
                    <p class="text-sm text-gedempt leading-relaxed"><?= $tip['tekst'] ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- ======== TAB 2: Huurcheck ======== -->
    <div id="paneel-huurcheck" class="grid grid-cols-1 md:grid-cols-2 gap-6 hidden">
        <div class="bg-white rounded-xl border border-gray-100 p-6">
            <h2 class="font-display font-semibold text-lg mb-4">Is mijn huur redelijk?</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-gedempt mb-1">Huidige maandhuur (€)</label>
                    <input type="number" id="huur-bedrag" value="1100" oninput="berekenHuurcheck()"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-ink">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-gedempt mb-1">Oppervlakte (m²)</label>
                    <input type="number" id="huur-m2" value="65" oninput="berekenHuurcheck()"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-ink">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-gedempt mb-1">Gemeente</label>
                    <select id="huur-stad" onchange="berekenHuurcheck()"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-ink">
                        <option value="1.4">Amsterdam</option>
                        <option value="1.25">Utrecht</option>
                        <option value="1.15">Den Haag</option>
                        <option value="1.1">Rotterdam</option>
                        <option value="0.9" selected>Andere gemeente</option>
                    </select>
                </div>
            </div>
            <div class="bg-ink rounded-xl p-4 mt-5 text-white">
                <p class="text-xs text-white/50 uppercase tracking-wide">Oordeel</p>
                <p class="font-display text-3xl font-bold my-1" id="huur-oordeel">Redelijk</p>
                <div class="flex justify-between items-end">
                    <p class="text-xs text-white/50" id="huur-toelichting">Vergelijkbare woningen: €950–€1.200/mnd</p>
                    <a href="rechten.php" class="text-xs bg-white/10 hover:bg-white/20 text-white px-2 py-1 rounded transition-colors">
                        Bekijk je rechten →
                    </a>
                </div>
            </div>
        </div>

        <div class="space-y-3">
            <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 text-sm text-blue-900">
                <p class="font-semibold mb-1">💡 Huurcommissie</p>
                <p>Betaal je te veel voor een sociale huurwoning? Je kunt gratis een procedure starten. Zij beoordelen of de huur verlaagd moet worden.</p>
            </div>
            <div class="bg-orange-50 border border-orange-100 rounded-xl p-4 text-sm text-orange-900">
                <p class="font-semibold mb-1">📋 Puntenstelsel</p>
                <p>Woningen onder de liberalisatiegrens worden beoordeeld via een puntenstelsel. De maximale huurprijs hangt af van kwaliteitspunten voor oppervlak, isolatie, keuken en meer.</p>
            </div>
            <div class="bg-green-50 border border-green-100 rounded-xl p-4 text-sm text-green-900">
                <p class="font-semibold mb-1">🆕 Wet betaalbare huur (2024)</p>
                <p>Woningen met ≤ 186 punten vallen nu onder het puntenstelsel, ook al werd er meer dan € 879 gevraagd. Huurders kunnen dit aanvechten.</p>
            </div>
        </div>
    </div>

    <!-- ======== TAB 3: Huurtoeslag ======== -->
    <div id="paneel-toeslag" class="grid grid-cols-1 md:grid-cols-2 gap-6 hidden">
        <div class="bg-white rounded-xl border border-gray-100 p-6">
            <h2 class="font-display font-semibold text-lg mb-4">Huurtoeslag berekenen</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-gedempt mb-1">Maandhuur (€)</label>
                    <input type="number" id="ts-huur" value="800" oninput="berekenToeslag()"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-ink">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-gedempt mb-1">Bruto jaarinkomen (€)</label>
                    <input type="number" id="ts-ink" value="26000" oninput="berekenToeslag()"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-ink">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-gedempt mb-1">Huishoudsituatie</label>
                    <select id="ts-hh" onchange="berekenToeslag()"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-ink">
                        <option value="1">Eenpersoonshuishouden</option>
                        <option value="2">Meerpersoons huishouden</option>
                    </select>
                </div>
            </div>
            <div class="bg-ink rounded-xl p-4 mt-5 text-white">
                <p class="text-xs text-white/50 uppercase tracking-wide">Geschatte toeslag per maand</p>
                <p class="font-display text-3xl font-bold text-oranje my-1" id="ts-uitkomst">€ 142</p>
                <p class="text-xs text-white/50" id="ts-noot">Aanvragen via Mijn Belastingdienst / DigiD</p>
            </div>
        </div>

        <div class="space-y-4">
            <div class="bg-green-50 border border-green-100 rounded-xl p-4 text-sm text-green-900">
                <p class="font-semibold mb-1">✅ Direct aanvragen</p>
                <p>Huurtoeslag vraag je aan via de Belastingdienst met DigiD. Je ontvangt toeslag zolang je huur onder de grens ligt en je inkomen voldoet aan de norm.</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-100 p-4">
                <h4 class="font-semibold text-sm mb-3">Inkomensgrenzen 2024</h4>
                <table class="w-full text-sm">
                    <tr class="border-b border-gray-100">
                        <td class="py-2 text-gedempt">Eenpersoonshuishouden</td>
                        <td class="py-2 font-semibold text-right">€ 31.340</td>
                    </tr>
                    <tr class="border-b border-gray-100">
                        <td class="py-2 text-gedempt">Meerpersoons huishouden</td>
                        <td class="py-2 font-semibold text-right">€ 42.436</td>
                    </tr>
                    <tr>
                        <td class="py-2 text-gedempt">Max. huurgrens toeslag</td>
                        <td class="py-2 font-semibold text-right">€ 879,66</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</div>

<script>
// --- Tab wisselen ---
function wisselTab(naam) {
    ['hypotheek','huurcheck','toeslag'].forEach(t => {
        document.getElementById('paneel-' + t).classList.add('hidden');
        const btn = document.getElementById('tab-' + t);
        btn.classList.remove('border-oranje', 'text-ink', 'border-b-2');
        btn.classList.add('text-gedempt', 'border-transparent');
    });
    document.getElementById('paneel-' + naam).classList.remove('hidden');
    const actief = document.getElementById('tab-' + naam);
    actief.classList.remove('text-gedempt', 'border-transparent');
    actief.classList.add('border-b-2', 'border-oranje', 'text-ink');
}
wisselTab('hypotheek');

// --- Hypotheek berekening ---
function berekenHypotheek() {
    const sal    = parseFloat(document.getElementById('hyp-sal').value)     || 0;
    const sal2   = parseFloat(document.getElementById('hyp-sal2').value)    || 0;
    const rente  = parseFloat(document.getElementById('hyp-rente').value)   || 4.3;
    const jaren  = parseInt(document.getElementById('hyp-looptijd').value)  || 30;
    const totaal = sal + sal2 * 0.9;
    const max    = Math.round(totaal * 4.2);
    const mRente = rente / 100 / 12;
    const n      = jaren * 12;
    const maand  = mRente > 0
        ? Math.round(max * mRente / (1 - Math.pow(1 + mRente, -n)))
        : Math.round(max / n);
    document.getElementById('hyp-uitkomst').textContent    = '€ ' + max.toLocaleString('nl-NL');
    document.getElementById('hyp-toelichting').textContent = 'Maandlast ca. € ' + maand.toLocaleString('nl-NL') + ' · 4.2× jaarsalaris';
}

// --- Huurcheck berekening ---
function berekenHuurcheck() {
    const bedrag = parseFloat(document.getElementById('huur-bedrag').value) || 0;
    const m2     = parseFloat(document.getElementById('huur-m2').value)     || 50;
    const f      = parseFloat(document.getElementById('huur-stad').value)   || 1;
    const basis  = m2 * 11 * f;
    const laag   = Math.round(basis * 0.85);
    const hoog   = Math.round(basis * 1.15);
    let oordeel, kleur;
    if      (bedrag < laag * 0.85) { oordeel = 'Zeer gunstig';        kleur = '#1A7A4C'; }
    else if (bedrag < laag)        { oordeel = 'Gunstig';             kleur = '#1A7A4C'; }
    else if (bedrag <= hoog)       { oordeel = 'Redelijk';            kleur = '#E8650A'; }
    else if (bedrag <= hoog * 1.2) { oordeel = 'Aan de hoge kant';    kleur = '#E8650A'; }
    else                           { oordeel = 'Te hoog — aanvechten'; kleur = '#C0392B'; }
    const el = document.getElementById('huur-oordeel');
    el.textContent = oordeel;
    el.style.color = kleur;
    document.getElementById('huur-toelichting').textContent =
        'Vergelijkbare woningen: €' + laag.toLocaleString('nl-NL') + '–€' + hoog.toLocaleString('nl-NL') + '/mnd';
}

// --- Huurtoeslag berekening ---
function berekenToeslag() {
    const huur   = parseFloat(document.getElementById('ts-huur').value) || 0;
    const ink    = parseFloat(document.getElementById('ts-ink').value)  || 0;
    const hh     = parseInt(document.getElementById('ts-hh').value);
    const maxInk = hh === 1 ? 31340 : 42436;
    let bedrag = 0, noot = 'Aanvragen via Mijn Belastingdienst / DigiD';
    if (huur > 879.66) {
        noot = 'Huurgrens overschreden (> €879,66) — geen toeslag mogelijk';
    } else if (ink > maxInk) {
        noot = 'Inkomen te hoog voor huurtoeslag in 2024';
    } else {
        bedrag = Math.round(Math.max(0, 1 - ink / maxInk) * (hh === 1 ? 180 : 220));
        if (bedrag < 5) { bedrag = 0; noot = 'Geen of minimale toeslag'; }
    }
    document.getElementById('ts-uitkomst').textContent = '€ ' + bedrag.toLocaleString('nl-NL');
    document.getElementById('ts-noot').textContent     = noot;
}
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>