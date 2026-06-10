<?php
$paginaTitel = 'Doe mee & actie';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/db.php';

$petitieBericht = '';
$briefBericht = '';
$nieuwsBriefBericht = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $actie = $_POST['actie'] ?? '';
    $db = getDb();

    if ($actie === 'petitie') {
        $naam = trim($_POST['naam'] ?? '');
        $email = trim($_POST['email'] ?? '');
        if ($naam !== '' && $email !== '') {
            $stmt = $db->prepare("INSERT INTO petities (naam, email) VALUES (:naam, :email)");
            $stmt->execute([':naam' => $naam, ':email' => $email]);
            $petitieBericht = 'Bedankt voor je steun!';
        } else {
            $petitieBericht = 'Vul je naam en e-mailadres in.';
        }
    } elseif ($actie === 'brief') {
        $briefNaam = trim($_POST['brief_naam'] ?? '');
        $briefGemeente = trim($_POST['brief_gemeente'] ?? '');
        $briefToevoeging = trim($_POST['brief_toevoeging'] ?? '');
        if ($briefNaam !== '' && $briefGemeente !== '') {
            $body = "Geachte volksvertegenwoordiger,\n\n"
                  . "Ik ben $briefNaam, inwoner van $briefGemeente, en ik maak mij ernstige zorgen over de woningcrisis.\n\n"
                  . "Het woningtekort loopt op, wachttijden voor sociale huur worden langer en starters worden buitengesloten. "
                  . "Ik verzoek u zich in te zetten voor:\n"
                  . "- Versnelde bouw van sociale huurwoningen\n"
                  . "- Betaalbare huur voor middeninkomens\n"
                  . "- Bescherming van huurdersrechten\n\n";
            if ($briefToevoeging !== '') {
                $body .= "Daarnaast wil ik het volgende onder de aandacht brengen:\n$briefToevoeging\n\n";
            }
            $body .= "Ik hoop op uw steun.\n\nMet vriendelijke groet,\n$briefNaam";
            $subject = rawurlencode("Woningcrisis in $briefGemeente");
            $bodyEnc = rawurlencode($body);
            header("Location: mailto:?subject=$subject&body=$bodyEnc");
            exit;
        } else {
            $briefBericht = 'Vul je naam en gemeente in.';
        }
    } elseif ($actie === 'nieuwsbrief') {
        $nieuwsEmail = trim($_POST['nieuws_email'] ?? '');
        if ($nieuwsEmail !== '') {
            try {
                $stmt = $db->prepare("INSERT INTO nieuwsbrieven (email) VALUES (:email)");
                $stmt->execute([':email' => $nieuwsEmail]);
                $nieuwsBriefBericht = 'Je bent aangemeld voor de nieuwsbrief!';
            } catch (PDOException $e) {
                $nieuwsBriefBericht = 'Dit e-mailadres is al aangemeld.';
            }
        } else {
            $nieuwsBriefBericht = 'Vul een geldig e-mailadres in.';
        }
    }
}

$db = getDb();
$aantal = $db->query("SELECT COUNT(*) AS cnt FROM petities")->fetch()['cnt'] + 12458;
$doel = 15000;
$percentage = min(100, round($aantal / $doel * 100));
?>

<div class="max-w-6xl mx-auto px-4 py-10">

    <p class="text-xs font-semibold uppercase tracking-widest text-oranje mb-1">Doe mee & actie</p>
    <h1 class="font-display text-3xl font-bold mb-2">Samen voor een betaalbare woningmarkt</h1>
    <p class="text-gedempt text-base max-w-lg mb-8">
        De woningcrisis los je niet alleen op. Doe mee, laat je stem horen en draag bij aan structurele verandering.
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">

        <!-- Petitie -->
        <div class="bg-white dark:bg-gray-800 dark:text-gray-200 rounded-xl border border-gray-100 dark:border-gray-700 p-6">
            <div class="text-3xl mb-3">📝</div>
            <h2 class="font-display font-semibold text-lg mb-2">Teken de petitie</h2>
            <p class="text-sm text-gedempt mb-4">
                De <strong>WoningWijzer-petitie</strong> roept de overheid op tot meer sociale huurwoningen,
                strengere regulering van de vrije sector en bescherming van huurders.
            </p>
            <div class="bg-oranje/5 rounded-xl p-4 mb-4 text-center">
                <span class="font-display text-4xl font-bold text-oranje" id="aantal-handtekeningen">
                    <?= number_format($aantal, 0, ',', '.') ?>
                </span>
                <p class="text-xs text-gedempt">handtekeningen van de <?= number_format($doel, 0, ',', '.') ?> benodigd</p>
                <div class="bg-gray-200 rounded-full h-2 mt-2">
                    <div class="bg-oranje rounded-full h-2 transition-all duration-500" style="width: <?= $percentage ?>%" id="progress-bar"></div>
                </div>
            </div>

            <?php if ($petitieBericht): ?>
                <div class="text-sm mb-3 <?= strpos($petitieBericht, 'Bedankt') === 0 ? 'text-green-700 bg-green-50 border border-green-200 px-3 py-2 rounded-lg' : 'text-red-600 bg-red-50 border border-red-200 px-3 py-2 rounded-lg' ?>">
                    <?= htmlspecialchars($petitieBericht) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="actie.php" class="space-y-3">
                <input type="hidden" name="actie" value="petitie">
                <input type="text" name="naam" placeholder="Je volledige naam" required
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-ink">
                <input type="email" name="email" placeholder="Je e-mailadres" required
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-ink">
                <button type="submit"
                        class="bg-oranje hover:bg-orange-700 text-white w-full px-4 py-3 rounded-lg text-sm font-semibold transition-colors">
                    ✍️ Teken nu de petitie
                </button>
            </form>
        </div>

        <!-- Schrijf je volksvertegenwoordiger -->
        <div class="bg-white dark:bg-gray-800 dark:text-gray-200 rounded-xl border border-gray-100 dark:border-gray-700 p-6">
            <div class="text-3xl mb-3">✉️</div>
            <h2 class="font-display font-semibold text-lg mb-2">Schrijf je volksvertegenwoordiger</h2>
            <p class="text-sm text-gedempt mb-4">
                Gebruik deze brief om jouw gemeenteraadslid of Tweede Kamerlid aan te schrijven
                over de woningnood in jouw regio.
            </p>

            <form method="POST" action="actie.php" class="space-y-3" id="brief-form">
                <input type="hidden" name="actie" value="brief">

                <input type="text" name="brief_naam" id="brief-naam" placeholder="Jouw naam" required
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-ink">

                <input type="text" name="brief_gemeente" id="brief-gemeente" placeholder="Jouw gemeente" required
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-ink">

                <textarea name="brief_toevoeging" id="brief-toevoeging" rows="3"
                          placeholder="Eigen toevoeging (optioneel)"
                          class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-ink resize-none"></textarea>

                <button type="submit"
                        class="bg-ink hover:bg-ink2 text-white w-full px-4 py-3 rounded-lg text-sm font-semibold transition-colors">
                    ✉️ Open in e-mail
                </button>
            </form>

            <div id="brief-voorbeeld" class="bg-gray-50 rounded-xl p-4 mt-4 text-sm text-gedempt border border-gray-100 hidden">
                <p class="font-semibold text-ink mb-1">Voorbeeldbrief:</p>
                <p id="brief-tekst" class="whitespace-pre-line"></p>
            </div>
        </div>

        <!-- Meld misstanden -->
        <div class="bg-white dark:bg-gray-800 dark:text-gray-200 rounded-xl border border-gray-100 dark:border-gray-700 p-6">
            <div class="text-3xl mb-3">🔔</div>
            <h2 class="font-display font-semibold text-lg mb-2">Meld misstanden</h2>
            <p class="text-sm text-gedempt mb-4">
                Zie je discriminatie bij huurtoewijzing, illegale praktijken of onredelijke huurverhogingen?
                Meld het bij ons — anoniem als je wilt.
            </p>
            <a href="meldingen.php" class="bg-red-500 hover:bg-red-600 text-white w-full inline-block text-center px-4 py-3 rounded-lg text-sm font-semibold transition-colors">
                🔔 Misstand melden
            </a>
        </div>

        <!-- Deel op sociale media -->
        <div class="bg-white dark:bg-gray-800 dark:text-gray-200 rounded-xl border border-gray-100 dark:border-gray-700 p-6">
            <div class="text-3xl mb-3">📢</div>
            <h2 class="font-display font-semibold text-lg mb-2">Deel en verspreid</h2>
            <p class="text-sm text-gedempt mb-4">
                Help anderen bewust te maken van de woningcrisis. Deel deze website, deel de petitie,
                en praat mee over de woningmarkt.
            </p>
            <div class="flex flex-col sm:flex-row gap-2">
                <button onclick="deelOpX()"
                        class="w-full sm:flex-1 bg-black hover:bg-gray-800 text-white px-3 py-2.5 rounded-lg text-xs font-semibold transition-colors">𝕏 Deel op X</button>
                <button onclick="deelOpFacebook()"
                        class="w-full sm:flex-1 bg-blue-600 hover:bg-blue-700 text-white px-3 py-2.5 rounded-lg text-xs font-semibold transition-colors">📘 Deel op Facebook</button>
                <button onclick="kopieerLink(this)"
                        class="w-full sm:flex-1 bg-gray-500 hover:bg-gray-600 text-white px-3 py-2.5 rounded-lg text-xs font-semibold transition-colors">🔗 Kopieer link</button>
            </div>
        </div>

    </div>

    <!-- Nieuwsbrief -->
    <div class="bg-orange-50 border border-orange-200 rounded-xl p-5 mb-8">
        <h3 class="font-display font-semibold text-base mb-2">📬 Blijf op de hoogte</h3>
        <p class="text-sm text-gedempt mb-4">Ontvang maandelijks een overzicht van het belangrijkste woningmarktnieuws in je mailbox.</p>

        <?php if ($nieuwsBriefBericht): ?>
            <div class="text-sm mb-3 <?= strpos($nieuwsBriefBericht, 'aangemeld') !== false ? 'text-green-700' : 'text-red-600' ?>">
                <?= htmlspecialchars($nieuwsBriefBericht) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="actie.php" class="flex flex-col sm:flex-row gap-2 max-w-md">
            <input type="hidden" name="actie" value="nieuwsbrief">
            <input type="email" name="nieuws_email" placeholder="Jouw e-mailadres" required
                   class="w-full sm:flex-1 border border-orange-200 rounded-lg px-3 py-2 text-sm text-ink">
            <button type="submit"
                    class="w-full sm:w-auto bg-oranje hover:bg-orange-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                Aanmelden
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <a href="over-de-crisis.php" class="bg-white dark:bg-gray-800 dark:text-gray-200 border border-gray-100 dark:border-gray-700 rounded-xl p-5 hover:shadow-md transition-shadow group">
            <h4 class="font-display font-bold text-ink group-hover:text-oranje transition-colors mb-2">🏠 Over de crisis</h4>
            <p class="text-sm text-gedempt">Lees meer over de woningcrisis in Nederland en de belangrijkste cijfers.</p>
        </a>
        <a href="nieuws.php" class="bg-white dark:bg-gray-800 dark:text-gray-200 border border-gray-100 dark:border-gray-700 rounded-xl p-5 hover:shadow-md transition-shadow group">
            <h4 class="font-display font-bold text-ink group-hover:text-oranje transition-colors mb-2">📰 Laatste nieuws</h4>
            <p class="text-sm text-gedempt">Blijf op de hoogte van de laatste ontwikkelingen op de woningmarkt.</p>
        </a>
        <a href="rechten.php" class="bg-white dark:bg-gray-800 dark:text-gray-200 border border-gray-100 dark:border-gray-700 rounded-xl p-5 hover:shadow-md transition-shadow group">
            <h4 class="font-display font-bold text-ink group-hover:text-oranje transition-colors mb-2">⚖️ Ken je rechten</h4>
            <p class="text-sm text-gedempt">Ontdek wat jouw rechten zijn als huurder en hoe je ze kunt beschermen.</p>
        </a>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const briefForm = document.getElementById('brief-form');
    if (briefForm) {
        briefForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const naam = document.getElementById('brief-naam').value.trim();
            const gemeente = document.getElementById('brief-gemeente').value.trim();
            const toevoeging = document.getElementById('brief-toevoeging').value.trim();
            if (!naam || !gemeente) return;

            let body = 'Geachte volksvertegenwoordiger,%0D%0A%0D%0A'
                + 'Ik ben ' + encodeURIComponent(naam) + ', inwoner van ' + encodeURIComponent(gemeente) + ', en ik maak mij ernstige zorgen over de woningcrisis.%0D%0A%0D%0A'
                + 'Het woningtekort loopt op, wachttijden voor sociale huur worden langer en starters worden buitengesloten. '
                + 'Ik verzoek u zich in te zetten voor:%0D%0A'
                + '- Versnelde bouw van sociale huurwoningen%0D%0A'
                + '- Betaalbare huur voor middeninkomens%0D%0A'
                + '- Bescherming van huurdersrechten%0D%0A%0D%0A';
            if (toevoeging) {
                body += 'Daarnaast wil ik het volgende onder de aandacht brengen:%0D%0A' + encodeURIComponent(toevoeging) + '%0D%0A%0D%0A';
            }
            body += 'Ik hoop op uw steun.%0D%0A%0D%0AMet vriendelijke groet,%0D%0A' + encodeURIComponent(naam);

            window.location.href = 'mailto:?subject=' + encodeURIComponent('Woningcrisis in ' + gemeente) + '&body=' + body;
        });
    }
});

function deelOpX() {
    const url = encodeURIComponent(window.location.href);
    const tekst = encodeURIComponent('Teken de petitie tegen de woningcrisis! 🏠');
    window.open('https://twitter.com/intent/tweet?text=' + tekst + '&url=' + url, '_blank', 'width=600,height=400');
}

function deelOpFacebook() {
    const url = encodeURIComponent(window.location.href);
    window.open('https://www.facebook.com/sharer/sharer.php?u=' + url, '_blank', 'width=600,height=400');
}

function kopieerLink(btn) {
    navigator.clipboard.writeText(window.location.href).then(function () {
        const orig = btn.textContent;
        btn.textContent = '✅ Gekopieerd!';
        setTimeout(function () { btn.textContent = orig; }, 2000);
    });
}
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
