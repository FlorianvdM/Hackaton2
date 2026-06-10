<?php
$paginaTitel = 'Doe mee & actie';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="max-w-6xl mx-auto px-4 py-10">

    <p class="text-xs font-semibold uppercase tracking-widest text-oranje mb-1">Doe mee & actie</p>
    <h1 class="font-display text-3xl font-bold mb-2">Samen voor een betaalbare woningmarkt</h1>
    <p class="text-gedempt text-base max-w-lg mb-8">
        De woningcrisis los je niet alleen op. Doe mee, laat je stem horen en draag bij aan structurele verandering.
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">

        <!-- Petitie -->
        <div class="bg-white rounded-xl border border-gray-100 p-6">
            <div class="text-3xl mb-3">📝</div>
            <h2 class="font-display font-semibold text-lg mb-2">Teken de petitie</h2>
            <p class="text-sm text-gedempt mb-4">
                De <strong>WoningWijzer-petitie</strong> roept de overheid op tot meer sociale huurwoningen,
                strengere regulering van de vrije sector en bescherming van huurders.
            </p>
            <div class="bg-oranje/5 rounded-xl p-4 mb-4 text-center">
                <span class="font-display text-4xl font-bold text-oranje">12.458</span>
                <p class="text-xs text-gedempt">handtekeningen van de 15.000 benodigd</p>
                <div class="bg-gray-200 rounded-full h-2 mt-2">
                    <div class="bg-oranje rounded-full h-2" style="width: 83%"></div>
                </div>
            </div>
            <button class="bg-oranje hover:bg-orange-700 text-white w-full px-4 py-3 rounded-lg text-sm font-semibold transition-colors">
                ✍️ Teken nu de petitie
            </button>
        </div>

        <!-- Schrijf je volksvertegenwoordiger -->
        <div class="bg-white rounded-xl border border-gray-100 p-6">
            <div class="text-3xl mb-3">✉️</div>
            <h2 class="font-display font-semibold text-lg mb-2">Schrijf je volksvertegenwoordiger</h2>
            <p class="text-sm text-gedempt mb-4">
                Gebruik onze standaardbrief om jouw gemeenteraadslid of Tweede Kamerlid aan te schrijven
                over de woningnood in jouw regio.
            </p>
            <div class="bg-gray-50 rounded-xl p-4 mb-4 text-sm text-gedempt border border-gray-100">
                <p class="font-semibold text-ink mb-1">Voorbeeldbrief:</p>
                <p>"Geachte heer/mevrouw, als inwoner van [...] maak ik mij ernstige zorgen over de woningcrisis. Ik verzoek u zich in te zetten voor [...]"</p>
            </div>
            <a href="mailto:?body=Geachte%20volksvertegenwoordiger%2C" class="bg-ink hover:bg-ink2 text-white w-full inline-block text-center px-4 py-3 rounded-lg text-sm font-semibold transition-colors">
                ✉️ Open in e-mail
            </a>
        </div>

        <!-- Meld misstanden -->
        <div class="bg-white rounded-xl border border-gray-100 p-6">
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
        <div class="bg-white rounded-xl border border-gray-100 p-6">
            <div class="text-3xl mb-3">📢</div>
            <h2 class="font-display font-semibold text-lg mb-2">Deel en verspreid</h2>
            <p class="text-sm text-gedempt mb-4">
                Help anderen bewust te maken van de woningcrisis. Deel deze website, deel de petitie,
                en praat mee over de woningmarkt.
            </p>
            <div class="flex gap-2">
                <button class="flex-1 bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg text-xs font-semibold transition-colors">🐦 Deel op X</button>
                <button class="flex-1 bg-blue-700 hover:bg-blue-800 text-white px-3 py-2 rounded-lg text-xs font-semibold transition-colors">📘 Deel op Facebook</button>
                <button class="flex-1 bg-blue-400 hover:bg-blue-500 text-white px-3 py-2 rounded-lg text-xs font-semibold transition-colors">🔗 Kopieer link</button>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <a href="index.php" class="bg-white border border-gray-100 rounded-xl p-5 hover:shadow-md transition-shadow group">
            <h4 class="font-display font-bold text-ink group-hover:text-oranje transition-colors mb-2">🏠 Over de crisis</h4>
            <p class="text-sm text-gedempt">Lees meer over de woningcrisis in Nederland en de belangrijkste cijfers.</p>
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
