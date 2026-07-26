<footer>
    <div class="container">
        <div class="footer-grid">
            <div>
                <h5>Jurusan Teknik Elektro &amp; Komputer</h5>
                <p>Fakultas Teknik, Universitas Negeri Gorontalo<br>Jl. Jend. Sudirman No. 6, Kota Gorontalo 96128<br>Telp: (0435) 821125</p>
            </div>
            <div>
                <h5>Program Studi</h5>
                <p><a href="profil.php#pv">S1 Pendidikan Vokasional Rekayasa Elektro</a></p>
                <p><a href="profil.php#te">S1 Teknik Elektro</a></p>
                <p><a href="profil.php#tk">S1 Teknik Komputer</a></p>
            </div>
            <div>
                <h5>Akademik</h5>
                <p><a href="akademik.php#kurikulum-te">Kurikulum OBE &mdash; TE</a></p>
                <p><a href="akademik.php#kurikulum-kkni">Kurikulum KKNI</a></p>
                <p><a href="akademik.php#kurikulum-tk">Kurikulum OBE &mdash; TK</a></p>
            </div>
            <div>
                <h5>Tautan</h5>
                <p><a href="https://www.ung.ac.id/" target="_blank">UNG</a></p>
                <p><a href="https://ft.ung.ac.id/" target="_blank">Fakultas Teknik</a></p>
                <p><a href="https://siat.ung.ac.id/" target="_blank">SIAT</a></p>
            </div>
        </div>
        <div class="footer-bot">
            <div>&copy; <?php echo date('Y'); ?> Jurusan Teknik Elektro dan Komputer &mdash; Fakultas Teknik UNG</div>
            <div>Diperbarui: <?php echo date('d F Y'); ?></div>
        </div>
    </div>
</footer>

<script>
    // ---- MOBILE MENU (shared) ----
    (function() {
        const btn = document.getElementById('hamburgerBtn');
        const backdrop = document.getElementById('menuBackdrop');
        if (!btn) return;

        function closeMenu() {
            document.body.classList.remove('menu-open');
            btn.setAttribute('aria-expanded', 'false');
            document.querySelectorAll('.nav-menu > li.is-open').forEach(li => li.classList.remove('is-open'));
            document.querySelectorAll('.nav-menu > li > a[aria-expanded]').forEach(a => a.setAttribute('aria-expanded', 'false'));
        }
        function openMenu() {
            document.body.classList.add('menu-open');
            btn.setAttribute('aria-expanded', 'true');
        }

        btn.addEventListener('click', () => {
            if (document.body.classList.contains('menu-open')) closeMenu();
            else openMenu();
        });
        if (backdrop) backdrop.addEventListener('click', closeMenu);

        document.querySelectorAll('.nav-menu > li > a').forEach(a => {
            const li = a.parentElement;
            if (!li.querySelector('.dropdown')) return;
            a.addEventListener('click', (e) => {
                if (window.matchMedia('(max-width: 900px)').matches) {
                    e.preventDefault();
                    const open = li.classList.toggle('is-open');
                    a.setAttribute('aria-expanded', open ? 'true' : 'false');
                }
            });
        });

        document.querySelectorAll('.nav-menu .dropdown a').forEach(a => {
            a.addEventListener('click', () => closeMenu());
        });

        document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeMenu(); });
        window.addEventListener('resize', () => {
            if (!window.matchMedia('(max-width: 900px)').matches) closeMenu();
        });
    })();
</script>

</body>
</html>
