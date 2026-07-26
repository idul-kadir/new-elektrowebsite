<?php
// template/footer.php
// Include di bawah sebelum </body>
?>

<footer>
    <div class="container">
        <div class="footer-grid">
            <div>
                <h5>Jurusan Teknik Elektro &amp; Komputer</h5>
                <p>Fakultas Teknik, Universitas Negeri Gorontalo<br>Jl. Jend. Sudirman No. 6, Kota Gorontalo 96128<br>Telp: (0435) 821125</p>
            </div>
            <div>
                <h5>Program Studi</h5>
                <ul id="prodiListFooter" style="list-style:none;padding:0;margin:0;"></ul>
            </div>
            <div>
                <h5>Akademik</h5>
                <p><a href="akademik.html#kurikulum-te">Kurikulum OBE &mdash; TE</a></p>
                <p><a href="akademik.html#kurikulum-kkni">Kurikulum KKNI</a></p>
                <p><a href="akademik.html#kurikulum-tk">Kurikulum OBE &mdash; TK</a></p>
            </div>
            <div>
                <h5>Tautan</h5>
                <p><a href="https://www.ung.ac.id/" target="_blank">UNG</a></p>
                <p><a href="https://ft.ung.ac.id/" target="_blank">Fakultas Teknik</a></p>
                <p><a href="https://siat.ung.ac.id/" target="_blank">SIAT</a></p>
            </div>
        </div>
        <div class="footer-bot">
            <div>&copy; 2026 Jurusan Teknik Elektro dan Komputer &mdash; Fakultas Teknik UNG</div>
            <div>Diperbarui: 25 Juli 2026</div>
        </div>
    </div>
</footer>

<script>
const API = 'https://temp.ikad-developer.my.id/elektro';

    // VISI prodi (manual — bukan dari API)
    const VISI = {
        'teknik elektro': 'Mengembangkan Teknologi Bidang Elektro Yang Berorientasi Pada Energi Baru Terbarukan Berbasis Potensi Kawasan',
        'teknik komputer': 'Mengembangkan Teknologi Sistem Komputer Berorientasi Sistem Tertanam Yang Berdampak Pada Kemajuan Kawasan'
    };

    // ---- HERO SLIDER ----
    (function() {
        const frame = document.getElementById('heroFrame');
        const dotsWrap = document.getElementById('heroDots');
        if (!frame) return;
        fetch(API + '/list-gambar-beranda')
            .then(r => r.json())
            .then(data => {
                if (!Array.isArray(data) || !data.length) return;
                const slides = data.slice(0, 6).map((it, i) => `
                    <div class="hero-slide ${i === 0 ? 'active' : ''}">
                        <img src="${it.gambar}" alt="${it.judul}">
                        <div class="hero-caption">
                            <span class="hero-caption-tag">FOTO</span>
                            <div class="hero-caption-text">${it.judul}</div>
                        </div>
                    </div>
                `).join('');
                frame.innerHTML = slides;
                const dots = data.slice(0, 6).map((_, i) => `<div class="dot ${i === 0 ? 'on' : ''}" data-i="${i}"></div>`).join('');
                dotsWrap.innerHTML = dots;
                let idx = 0;
                const total = 6;
                const show = (n) => {
                    document.querySelectorAll('.hero-slide').forEach((s, i) => s.classList.toggle('active', i === n));
                    document.querySelectorAll('.hero-dots .dot').forEach((d, i) => d.classList.toggle('on', i === n));
                    idx = n;
                };
                const next = () => show((idx + 1) % total);
                const prev = () => show((idx - 1 + total) % total);
                document.getElementById('heroNext').onclick = next;
                document.getElementById('heroPrev').onclick = prev;
                dotsWrap.querySelectorAll('.dot').forEach(d => d.onclick = () => show(parseInt(d.dataset.i)));
                setInterval(next, 5000);
            });
    })();

    // ---- HERO STATS ----
    (function() {
        const wrap = document.getElementById('heroStats');
        if (!wrap) return;
        Promise.all([
            fetch(API + '/program-studi').then(r => r.json()),
            fetch(API + '/daftar-dosen').then(r => r.json()),
            fetch(API + '/statistik-mahasiswa').then(r => r.json()),
            fetch(API + '/data-alumni').then(r => r.json())
        ]).then(([prodi, dosen, stat]) => {
            const totalDosen = Array.isArray(dosen) ? dosen.length : 0;
            const statFilled = Array.isArray(stat) ? stat.filter(s => (s['jumlah-masuk'] || 0) > 0) : [];
            const latest = statFilled.length ? statFilled[statFilled.length - 1] : (Array.isArray(stat) && stat.length ? stat[stat.length - 1] : null);
            const mhsAktif = latest ? (latest['jumlah-masuk'] || 0) : 0;
            const totalLulus = Array.isArray(stat) ? stat.reduce((s, x) => s + (x['jumlah-lulus'] || 0), 0) : 0;
            const prodiCount = Array.isArray(prodi) ? prodi.length : 0;
            wrap.innerHTML = `
                <div class="hero-stat"><div class="hero-stat-num">${prodiCount}</div><div class="hero-stat-lbl">Program Studi</div></div>
                <div class="hero-stat"><div class="hero-stat-num">${totalDosen}</div><div class="hero-stat-lbl">Tenaga Pendidik</div></div>
                <div class="hero-stat"><div class="hero-stat-num">${mhsAktif}</div><div class="hero-stat-lbl">Mahasiswa Baru ${latest ? latest.tahun : ''}</div></div>
                <div class="hero-stat"><div class="hero-stat-num">${totalLulus}</div><div class="hero-stat-lbl">Total Alumni</div></div>
            `;
        });
    })();

    // ---- PRODI LIST (DENGAN VISI) ----
    (function() {
        const list = document.getElementById('prodiList');
        if (!list) return;
        fetch(API + '/program-studi')
            .then(r => r.json())
            .then(data => {
                console.log('[PRODI] Received:', data.length, 'items:', data.map(d => Object.keys(d)[0]));
                if (!Array.isArray(data) || !data.length) return;
                // Tampilkan semua prodi
                list.innerHTML = data.map((item, i) => {
                    const [name, info] = Object.entries(item)[0];
                    const nameKey = name.toLowerCase();
                    let visi = '';
                    for (const k in VISI) { if (nameKey.includes(k)) { visi = VISI[k]; break; } }
                    return `
                        <div class="prodi-item">
                            <div class="prodi-num">${String(i + 1).padStart(2, '0')}</div>
                            <div class="prodi-strata">Sarjana &mdash; S1</div>
                            <h3>${name.replace(/^S1\s/, '')}</h3>
                            ${visi ? `<div class="prodi-visi">${visi}</div>` : ''}
                            <div class="prodi-kaprodi">
                                <strong>${info.kaprodi || '—'}</strong>
                                ${info.keterangan || 'Ketua Program Studi'} &middot; ${info['bidang-keahlian'] || ''}
                            </div>
                        </div>
                    `;
                }).join('');
            });
    })();

    // ---- PRODI FOOTER LIST ----
    (function() {
        const list = document.getElementById('prodiListFooter');
        if (!list) return;
        fetch(API + '/program-studi')
            .then(r => r.json())
            .then(data => {
                if (!Array.isArray(data) || !data.length) return;
                list.innerHTML = data.map(item => {
                    const name = Object.keys(item)[0];
                    return `<li style="margin-bottom:8px;"><a href="prodi.html">${name.replace(/^S1\s/, '')}</a></li>`;
                }).join('');
            });
    })();

    // ---- BERITA FEATURED ----
    (function() {
        const main = document.getElementById('beritaMain');
        if (!main) return;
        fetch(API + '/list-berita')
            .then(r => r.json())
            .then(data => {
                if (!Array.isArray(data) || !data.length) return;
                const item = data[0];
                const d = new Date(item.tanggal);
                const dateStr = d.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
                document.getElementById('beritaMainImg').src = item.gambar;
                document.getElementById('beritaMainImg').alt = item.judul;
                main.querySelector('.berita-meta').textContent = dateStr + ' • Berita Utama';
                main.querySelector('h2').textContent = item.judul;
            });
    })();

    // ---- BERITA SIDE: UPDATE TERKINI (DENGAN GAMBAR) ----
    (function() {
        const side = document.getElementById('beritaSide');
        const count = document.getElementById('beritaCount');
        if (!side) return;
        fetch(API + '/list-berita')
            .then(r => r.json())
            .then(data => {
                if (!Array.isArray(data) || !data.length) return;
                const items = data.slice(1, 6);
                side.innerHTML = items.map(it => {
                    const d = new Date(it.tanggal);
                    const ds = d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
                    return `
                        <a href="#" class="berita-side-item">
                            <div class="berita-side-img"><img src="${it.gambar}" alt=""></div>
                            <div>
                                <div class="date">${ds}</div>
                                <h4>${it.judul}</h4>
                            </div>
                        </a>
                    `;
                }).join('');
                count.textContent = `${items.length} berita`;
            });
    })();

    // ---- MOBILE MENU ----
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

        // Click dropdown toggle (untuk touch + mobile)
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

        // Close menu saat klik link dropdown
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