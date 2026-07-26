<?php
$pageTitle = 'Jurusan Teknik Elektro dan Komputer';
$pageDesc = 'Jurusan Teknik Elektro dan Komputer, Fakultas Teknik, Universitas Negeri Gorontalo.';
$currentPage = 'index';
$pageCss = ['assets/index.css'];
include 'header.php';
?>

<!-- HERO -->
<section class="hero">
    <div class="container">
        <div class="hero-grid">
            <div>
                <div class="hero-eyebrow">Jurusan Teknik Elektro &amp; Komputer</div>
                <h1 class="hero-title">Membangun <em>Insan Teknik</em> Yang Berdaya Saing Global</h1>
                <p class="hero-lead">Program studi sarjana yang mengintegrasikan pendidikan, penelitian, dan pengabdian di bidang elektro dan komputer — untuk kawasan Indonesia Timur.</p>
                <div class="hero-cta">
                    <a href="profil.php" class="btn btn-primary">Tentang Jurusan</a>
                    <a href="prodi.php" class="btn btn-outline">Program Studi</a>
                </div>
            </div>
            <div class="hero-stage">
                <div class="hero-frame" id="heroFrame"></div>
                <div class="hero-nav">
                    <button id="heroPrev">&#8592;</button>
                    <button id="heroNext">&#8594;</button>
                </div>
                <div class="hero-dots" id="heroDots"></div>
            </div>
        </div>
        <div class="hero-stats" id="heroStats">
            <div class="hero-stat"><div class="hero-stat-num">—</div><div class="hero-stat-lbl">Memuat...</div></div>
        </div>
    </div>
</section>

<!-- PRODI -->
<section class="prodi">
    <div class="container">
        <div class="section-head">
            <div class="desc">
                <div class="section-eyebrow">Program Studi</div>
                <h2 class="section-title">Program Studi Sarjana</h2>
                <p class="section-desc">Kurikulum berbasis OBE dan KKNI, dengan dosen berpengalaman dan fasilitas laboratorium yang lengkap.</p>
            </div>
        </div>
        <div class="prodi-list" id="prodiList">
            <div class="prodi-item"><div class="prodi-num">—</div><h3>Memuat data program studi...</h3></div>
        </div>
    </div>
</section>

<!-- BERITA -->
<section class="berita">
    <div class="container">
        <div class="section-head">
            <div class="desc">
                <div class="section-eyebrow">Berita &amp; Informasi</div>
                <h2 class="section-title">Kabar Jurusan</h2>
                <p class="section-desc">Update kegiatan, prestasi, dan pengumuman terbaru dari Jurusan Teknik Elektro dan Komputer.</p>
            </div>
        </div>
        <div class="berita-grid">
            <article class="berita-main" id="beritaMain">
                <div class="berita-main-img">
                    <img src="" alt="Berita utama" id="beritaMainImg">
                </div>
                <div class="berita-main-body">
                    <span class="berita-main-tag">Berita Utama</span>
                    <div class="berita-meta">Memuat...</div>
                    <h2>Sedang mengambil data berita utama...</h2>
                    <p>Silakan cek jaringan Anda.</p>
                    <a href="berita.php" class="berita-main-link">Baca selengkapnya &rarr;</a>
                </div>
            </article>
            <div class="berita-side">
                <div class="berita-side-head">
                    <h3>Update Terkini</h3>
                    <span class="sub" id="beritaCount">—</span>
                </div>
                <div class="berita-side-list" id="beritaSide">
                    <div class="berita-side-item">
                        <div class="berita-side-img" style="background:var(--soft);"></div>
                        <div>
                            <div class="date">Memuat...</div>
                            <h4>Sedang mengambil data berita...</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- LABORATORIUM -->
<section class="lab">
    <div class="container">
        <div class="section-head">
            <div class="desc">
                <div class="section-eyebrow">Fasilitas</div>
                <h2 class="section-title">Laboratorium &amp; Ruang Praktikum</h2>
                <p class="section-desc">Enam laboratorium dengan peralatan terapan untuk mendukung kegiatan praktikum, penelitian, dan pengabdian.</p>
            </div>
        </div>
        <div class="lab-grid">
            <div class="lab-item">
                <div class="lab-img"><img src="assets/lab-tenaga-listrik.jpg" alt="Laboratorium Tegangan Tinggi"></div>
                <div class="lab-body">
                    <div class="lab-code">LAB / 01</div>
                    <h3>Tegangan Tinggi</h3>
                    <p>Pengujian sistem isolasi tegangan tinggi, pengujian peralatan tegangan tinggi untuk praktika, penelitian, dan pengabdian masyarakat.</p>
                </div>
            </div>
            <div class="lab-item">
                <div class="lab-img"><img src="assets/lab-elektronika.jpg" alt="Laboratorium Elektronika dan Telekomunikasi"></div>
                <div class="lab-body">
                    <div class="lab-code">LAB / 02</div>
                    <h3>Elektronika dan Telekomunikasi</h3>
                    <p>Merancang, menguji, dan menganalisis sirkuit elektronik dan peralatan telekomunikasi secara langsung.</p>
                </div>
            </div>
            <div class="lab-item">
                <div class="lab-img"><img src="assets/lab-tenaga-listrik.jpg" alt="Laboratorium Dasar Tenaga Listrik"></div>
                <div class="lab-body">
                    <div class="lab-code">LAB / 03</div>
                    <h3>Dasar Tenaga Listrik</h3>
                    <p>Mengukur, mengontrol, dan memanipulasi energi listrik — efisiensi transformator, daya listrik, dan sistem tenaga.</p>
                </div>
            </div>
            <div class="lab-item">
                <div class="lab-img"><img src="assets/lab-komputer.jpg" alt="Perpustakaan Jurusan"></div>
                <div class="lab-body">
                    <div class="lab-code">FASILITAS / 04</div>
                    <h3>Perpustakaan Jurusan</h3>
                    <p>Sumber daya buku, jurnal, artikel, dan materi spesifik bidang teknik elektro dan komputer.</p>
                </div>
            </div>
            <div class="lab-item">
                <div class="lab-img"><img src="assets/lab-kontrol.jpg" alt="Laboratorium Teknik Kendali"></div>
                <div class="lab-body">
                    <div class="lab-code">LAB / 05</div>
                    <h3>Teknik Kendali</h3>
                    <p>Mempelajari dan menganalisis sistem kendali — transfer function, PID control, dan state space dengan peralatan terapan.</p>
                </div>
            </div>
            <div class="lab-item">
                <div class="lab-img"><img src="assets/lab-komputer.jpg" alt="Laboratorium Komputer"></div>
                <div class="lab-body">
                    <div class="lab-code">LAB / 06</div>
                    <h3>Komputer</h3>
                    <p>Praktikum, proyek, dan riset perangkat lunak serta perangkat keras — dilengkapi komputer, server, printer, dan software.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

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
                if (!Array.isArray(data) || !data.length) return;
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
</script>
