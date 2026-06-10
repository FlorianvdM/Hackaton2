<!-- Footer -->
    <footer class="bg-ink2 dark:bg-gray-900 text-white/65 mt-auto">
        <div class="max-w-6xl mx-auto px-4 py-12">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">

                <!-- Merk -->
                <div class="col-span-2 md:col-span-1">
                    <div class="font-display font-bold text-lg text-white mb-2">
                        Woning<span class="text-oranje">Wijzer</span>
                    </div>
                    <p class="text-sm leading-relaxed">
                        Een onafhankelijk platform dat woningzoekenden informeert,
                        helpt en verbindt. Niet commercieel, geen adverteerders.
                    </p>
                </div>

                <!-- Tools -->
                <div>
                    <h5 class="text-xs font-semibold uppercase tracking-widest text-white/90 mb-3">Tools</h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="<?= $pagesDir ?>zoeken.php"  class="hover:text-white transition-colors">Woningen zoeken</a></li>
                        <li><a href="<?= $pagesDir ?>bereken.php" class="hover:text-white transition-colors">Hypotheek berekenen</a></li>
                        <li><a href="<?= $pagesDir ?>bereken.php" class="hover:text-white transition-colors">Huurcheck</a></li>
                        <li><a href="<?= $pagesDir ?>bereken.php" class="hover:text-white transition-colors">Huurtoeslag</a></li>
                    </ul>
                </div>

                <!-- Rechten -->
                <div>
                    <h5 class="text-xs font-semibold uppercase tracking-widest text-white/90 mb-3">Rechten</h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="<?= $pagesDir ?>rechten.php" class="hover:text-white transition-colors">Huurcommissie</a></li>
                        <li><a href="<?= $pagesDir ?>rechten.php" class="hover:text-white transition-colors">Huurverhoging</a></li>
                        <li><a href="<?= $pagesDir ?>rechten.php" class="hover:text-white transition-colors">Gebreken melden</a></li>
                        <li><a href="<?= $pagesDir ?>rechten.php" class="hover:text-white transition-colors">Borg terugkrijgen</a></li>
                    </ul>
                </div>

                <!-- Info -->
                <div>
                    <h5 class="text-xs font-semibold uppercase tracking-widest text-white/90 mb-3">Informatie</h5>
                    <ul class="space-y-2 text-sm">
                        <li><a href="<?= $pagesDir ?>over-de-crisis.php" class="hover:text-white transition-colors">Over de crisis</a></li>
                        <li><a href="<?= $pagesDir ?>nieuws.php"   class="hover:text-white transition-colors">Nieuws &amp; beleid</a></li>
                        <li><a href="<?= $pagesDir ?>meldingen.php"class="hover:text-white transition-colors">Meldingen</a></li>
                        <li><a href="<?= $pagesDir ?>actie.php"    class="hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>

            </div>

            <div class="border-t border-white/10 mt-8 pt-6 flex flex-wrap justify-between gap-3 text-xs text-white/35">
                <span>© 2024 WoningWijzer Nederland — Onafhankelijk, niet-commercieel</span>
                <span>Gegevens: CBS, RVO, Ministerie van BZK, Huurcommissie</span>
            </div>
        </div>
    </footer>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // Scroll-reveal: elementen met data-reveal worden zichtbaar bij scrollen
    var revealObserver = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('revealed');
                revealObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15 });

    document.querySelectorAll('[data-reveal]').forEach(function (el) {
        revealObserver.observe(el);
    });

    // Stagger: kinderen van .animate-stagger worden een voor een zichtbaar
    var staggerObserver = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('staggered');
                staggerObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.animate-stagger').forEach(function (el) {
        staggerObserver.observe(el);
    });

    // Counter: tel op van 0 naar data-counter-waarde
    var counterObserver = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                var el = entry.target;
                var doel = parseFloat(el.getAttribute('data-counter-waarde')) || 0;
                var prefix = el.getAttribute('data-counter-prefix') || '';
                var suffix = el.getAttribute('data-counter-suffix') || '';
                var dur = parseInt(el.getAttribute('data-counter-duur')) || 1500;
                var stap = Math.max(1, Math.floor(doel / 60));
                var huidig = 0;
                var interval = setInterval(function () {
                    huidig += stap;
                    if (huidig >= doel) {
                        huidig = doel;
                        clearInterval(interval);
                    }
                    el.textContent = prefix + huidig.toLocaleString('nl-NL') + suffix;
                }, dur / 60);
                counterObserver.unobserve(el);
            }
        });
    }, { threshold: 0.3 });

    document.querySelectorAll('[data-counter-waarde]').forEach(function (el) {
        counterObserver.observe(el);
    });
});
</script>

</body>
</html>