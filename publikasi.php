<?php
// publikasi.php — Halaman Daftar Publikasi
$pageTitle = 'Publikasi — Jurusan Teknik Elektro dan Komputer';
$currentPage = 'publikasi';
$pageCss = ['assets/kurikulum.css', 'assets/publikasi.css'];
include 'template/header.php';
?>

<!-- page banner -->
<section class="page-banner">
    <div class="container">
        <div>
            <div class="breadcrumb">
                <a href="beranda">Beranda</a> &rsaquo;&nbsp; Publikasi
            </div>
            <h1>Publikasi</h1>
            <p class="lede">Daftar publikasi ilmiah dosen dan mahasiswa Jurusan Teknik Elektro dan Komputer, Fakultas Teknik UNG.</p>
        </div>
        <div class="page-banner-meta">
            <strong id="pub-total">—</strong> Total Publikasi
        </div>
    </div>
</section>

<!-- ============================================
     SECTION 1 — STATISTIK (2 KOLOM PROPORSIONAL)
     ============================================ -->
<section class="prodi-section" style="padding-top:64px; background: var(--soft);">
    <div class="container">
        <div class="section-head section-head-split">
            <div class="section-head-left">
                <div class="section-eyebrow">Statistik</div>
            </div>
            <div class="section-head-right">
                <h2 class="section-title">Rekapitulasi Publikasi</h2>
            </div>
        </div>
        <p class="section-desc" style="margin-top:-32px;margin-bottom:32px;max-width:760px;">
            Distribusi jumlah publikasi per tahun yang dikelompokkan berdasarkan jenis: artikel, penelitian, prosiding, buku, dan HaKI.
        </p>

        <!-- loading & error -->
        <div id="stat-loading" class="loading-state">
            <div class="spinner"></div>
            <p>Memuat statistik publikasi...</p>
        </div>
        <div id="stat-error" class="error-state" style="display:none;">
            <p>Gagal memuat statistik publikasi.</p>
        </div>

        <!-- Layout 2 kolom: chart 2/3, summary 1/3 -->
        <div id="stat-grid" class="stat-grid" style="display:none;">

            <!-- Chart batang 2/3 -->
            <div class="stat-chart-card">
                <div class="stat-card-head">
                    <h3>Tren Publikasi per Tahun</h3>
                    <div class="stat-legend-inline">
                        <span><i style="background:#1E3A8A;"></i> Artikel</span>
                        <span><i style="background:#F97316;"></i> Penelitian</span>
                        <span><i style="background:#0EA5E9;"></i> Prosiding</span>
                        <span><i style="background:#8B5CF6;"></i> Buku</span>
                        <span><i style="background:#10B981;"></i> HaKI</span>
                    </div>
                </div>
                <div id="stat-chart" class="stat-chart"></div>
            </div>

            <!-- Summary 1/3 -->
            <div class="stat-summary-card">
                <h3>Ringkasan</h3>
                <div class="stat-summary-row">
                    <div class="stat-summary-label">Total Publikasi</div>
                    <div class="stat-summary-value" id="stat-grand-total">0</div>
                </div>
                <div class="stat-summary-divider"></div>
                <div id="stat-breakdown" class="stat-breakdown"></div>
                <div class="stat-summary-divider"></div>
                <div class="stat-summary-row">
                    <div class="stat-summary-label">Tahun Aktif</div>
                    <div class="stat-summary-value" id="stat-year-range">—</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
     SECTION 2 — DAFTAR PUBLIKASI (PAGINATED)
     ============================================ -->
<section class="prodi-section">
    <div class="container">
        <div class="section-head section-head-split">
            <div class="section-head-left">
                <div class="section-eyebrow">Daftar</div>
            </div>
            <div class="section-head-right">
                <h2 class="section-title">Publikasi Terbaru</h2>
            </div>
        </div>
        <p class="section-desc" style="margin-top:-32px;margin-bottom:32px;max-width:760px;">
            Pilih tahun, gunakan kotak pencarian, atau klik nama penulis untuk memfilter daftar publikasi.
        </p>

        <!-- toolbar -->
        <div class="dokumen-toolbar">
            <div class="dokumen-search">
                <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.3-4.3"></path>
                </svg>
                <input type="text" id="pub-search" placeholder="Cari judul atau nama penulis..." autocomplete="off">
            </div>
            <div id="pub-filter-tahun" class="dokumen-filter"></div>
        </div>

        <!-- meta hasil -->
        <div id="pub-result-meta" class="pub-result-meta" style="display:none;">
            Menampilkan <strong id="pub-shown">0</strong> dari <strong id="pub-filtered-total">0</strong> publikasi
        </div>

        <!-- state messages -->
        <div id="pub-loading" class="loading-state">
            <div class="spinner"></div>
            <p>Memuat publikasi...</p>
        </div>
        <div id="pub-error" class="error-state" style="display:none;">
            <p>Gagal memuat publikasi. Coba lagi nanti.</p>
        </div>
        <div id="pub-empty" class="empty-state" style="display:none;">
            <p>Tidak ada publikasi yang cocok dengan filter atau pencarian Anda.</p>
        </div>

        <!-- grid -->
        <div id="pub-grid" class="pub-grid"></div>

        <!-- load more -->
        <div id="pub-loadmore-wrap" class="pub-loadmore-wrap" style="display:none;">
            <button id="pub-loadmore" class="pub-loadmore-btn">Muat Lebih Banyak</button>
        </div>
    </div>
</section>

<script>
/* ============================================================
   Publikasi — load statistik + data publikasi dari 2 API
   ============================================================ */
(async function() {
    /* ============ STATE ============ */
    const PAGE_SIZE = 12;
    let allItems = [];
    let activeTahun = 'all';
    let searchQuery = '';
    let renderedCount = 0;

    /* ============ DOM ============ */
    const $ = (id) => document.getElementById(id);
    const grid        = $('pub-grid');
    const pubLoading  = $('pub-loading');
    const pubError    = $('pub-error');
    const pubEmpty    = $('pub-empty');
    const filterWrap  = $('pub-filter-tahun');
    const searchInput = $('pub-search');
    const totalEl     = $('pub-total');
    const resultMeta  = $('pub-result-meta');
    const shownEl     = $('pub-shown');
    const filteredEl  = $('pub-filtered-total');
    const loadmoreWrap= $('pub-loadmore-wrap');
    const loadmoreBtn = $('pub-loadmore');

    const statLoading = $('stat-loading');
    const statError   = $('stat-error');
    const statGrid    = $('stat-grid');
    const statChart   = $('stat-chart');
    const statBreakdown = $('stat-breakdown');
    const statGrand   = $('stat-grand-total');
    const statYearRange = $('stat-year-range');

    /* ============ UTIL ============ */
    const escapeHtml = (s) => String(s ?? '').replace(/[&<>"']/g, c => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
    }[c]));

    const normalizeUrl = (url) => {
        if (!url) return null;
        const match = url.match(/drive\.google\.com\/file\/d\/([a-zA-Z0-9_-]+)/);
        if (match) return `https://drive.google.com/file/d/${match[1]}/view`;
        // base URL tanpa ID → anggap tidak ada file
        if (/\/adm\/file\/?$/.test(url)) return null;
        return url;
    };

    const sortTahunDesc = (a, b) => Number(b) - Number(a);

    /* =====================================================
       1) STATISTIK — Chart 2/3 + Summary 1/3
       ===================================================== */
    async function loadStatistik() {
        try {
            const res = await fetch('https://temp.ikad-developer.my.id/elektro/statistik-publikasi');
            if (!res.ok) throw new Error(`HTTP ${res.status}`);
            const data = await res.json();
            statLoading.style.display = 'none';

            const stats = Array.isArray(data) ? data : [];
            // filter: hanya tahun dengan total > 0
            let filtered = stats.filter(s => (s.artikel + s.penelitian + s.prosiding + s.buku + s.haki) > 0);
            // BATAS: max 5 tahun terbaru
            filtered = filtered
                .sort((a, b) => Number(b.tahun) - Number(a.tahun))
                .slice(0, 5)
                .sort((a, b) => Number(a.tahun) - Number(b.tahun));
            if (filtered.length === 0) {
                statGrid.style.display = 'none';
                return;
            }
            statGrid.style.display = 'grid';

            /* ---- Total akumulasi ---- */
            const total = filtered.reduce((acc, s) => {
                acc.artikel += s.artikel; acc.penelitian += s.penelitian;
                acc.prosiding += s.prosiding; acc.buku += s.buku; acc.haki += s.haki;
                return acc;
            }, { artikel: 0, penelitian: 0, prosiding: 0, buku: 0, haki: 0 });

            const grand = total.artikel + total.penelitian + total.prosiding + total.buku + total.haki;
            statGrand.textContent = grand.toLocaleString('id-ID');

            const years = filtered.map(s => Number(s.tahun)).sort((a,b)=>a-b);
            statYearRange.textContent = years.length === 1 ? years[0] : `${years[0]}–${years[years.length-1]}`;

            /* ---- Breakdown kanan ---- */
            const bd = [
                { label: 'Artikel',    value: total.artikel,    color: '#1E3A8A' },
                { label: 'Penelitian', value: total.penelitian, color: '#F97316' },
                { label: 'Prosiding',  value: total.prosiding,  color: '#0EA5E9' },
                { label: 'Buku',       value: total.buku,       color: '#8B5CF6' },
                { label: 'HaKI',       value: total.haki,       color: '#10B981' },
            ];
            statBreakdown.innerHTML = bd.map(b => {
                const pct = grand > 0 ? Math.round((b.value / grand) * 100) : 0;
                return `
                    <div class="bd-row">
                        <div class="bd-row-head">
                            <span class="bd-label"><i style="background:${b.color};"></i> ${b.label}</span>
                            <span class="bd-value">${b.value.toLocaleString('id-ID')} · ${pct}%</span>
                        </div>
                        <div class="bd-bar"><div class="bd-bar-fill" style="width:${pct}%;background:${b.color};"></div></div>
                    </div>
                `;
            }).join('');

            /* ---- Chart batang GROUPED (max 5 tahun) ---- */
            const sortedYears = filtered;
            const maxVal = Math.max(...sortedYears.map(s => Math.max(s.artikel, s.penelitian, s.prosiding, s.buku, s.haki, 1)));
            const categories = [
                { key: 'artikel',    label: 'Artikel',    color: '#1E3A8A' },
                { key: 'penelitian', label: 'Penelitian', color: '#F97316' },
                { key: 'prosiding',  label: 'Prosiding',  color: '#0EA5E9' },
                { key: 'buku',       label: 'Buku',       color: '#8B5CF6' },
                { key: 'haki',       label: 'HaKI',       color: '#10B981' },
            ];

            statChart.innerHTML = `
                <div class="chart-area">
                    <div class="chart-bars">
                        ${sortedYears.map(s => {
                            const tot = s.artikel + s.penelitian + s.prosiding + s.buku + s.haki;
                            const bars = categories.map(cat => {
                                const v = s[cat.key] || 0;
                                const h = maxVal > 0 ? (v / maxVal) * 100 : 0;
                                return `
                                    <div class="bar-wrap" title="${cat.label} ${s.tahun}: ${v}">
                                        <div class="bar" style="height:${h}%;background:${cat.color};">
                                            ${v > 0 ? `<span class="bar-val">${v}</span>` : ''}
                                        </div>
                                    </div>
                                `;
                            }).join('');
                            return `
                                <div class="bar-group">
                                    <div class="bar-group-stack">${bars}</div>
                                    <div class="bar-year-label">${s.tahun}</div>
                                    <div class="bar-year-total">${tot} total</div>
                                </div>
                            `;
                        }).join('')}
                    </div>
                </div>
            `;

        } catch (err) {
            console.error(err);
            statLoading.style.display = 'none';
            statError.style.display = 'block';
        }
    }

    /* =====================================================
       2) DAFTAR PUBLIKASI — dengan pagination
       ===================================================== */
    function getFiltered() {
        return allItems.filter(d => {
            const matchTahun = activeTahun === 'all' || String(d.tahun) === activeTahun;
            const matchSearch = !searchQuery ||
                (d.deskripsi || '').toLowerCase().includes(searchQuery) ||
                (d['penulis-utama'] || '').toLowerCase().includes(searchQuery);
            return matchTahun && matchSearch;
        });
    }

    function renderCards() {
        const filtered = getFiltered();

        if (filtered.length === 0) {
            grid.style.display = 'none';
            pubEmpty.style.display = 'block';
            resultMeta.style.display = 'none';
            loadmoreWrap.style.display = 'none';
            return;
        }

        pubEmpty.style.display = 'none';

        // urutkan tahun DESC, lalu nomor asli
        filtered.sort((a, b) => Number(b.tahun) - Number(a.tahun));

        // tentukan slice yang akan dirender
        const slice = filtered.slice(0, renderedCount);
        grid.style.display = 'grid';
        grid.innerHTML = slice.map((d, i) => {
            const fileUrl = normalizeUrl(d.file);
            const penulis = d['penulis-utama'] && d['penulis-utama'] !== '-' ? d['penulis-utama'] : 'Tanpa penulis';
            const isLatest = i === 0;
            return `
                <article class="pub-card${isLatest ? ' pub-card-latest' : ''}">
                    ${isLatest ? '<div class="pub-latest-flag">TERBARU</div>' : ''}
                    <div class="pub-card-head">
                        <span class="pub-year">${escapeHtml(d.tahun || '-')}</span>
                    </div>
                    <h3 class="pub-title">${escapeHtml(d.deskripsi || '(Tanpa judul)')}</h3>
                    <div class="pub-author">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                        <span>${escapeHtml(penulis)}</span>
                    </div>
                    <div class="pub-footer">
                        ${fileUrl
                            ? `<a href="${escapeHtml(fileUrl)}" target="_blank" rel="noopener" class="pub-link">Lihat Dokumen ↗</a>`
                            : `<span class="pub-link-disabled">File tidak tersedia</span>`}
                    </div>
                </article>
            `;
        }).join('');

        // update meta
        resultMeta.style.display = 'block';
        shownEl.textContent = slice.length.toLocaleString('id-ID');
        filteredEl.textContent = filtered.length.toLocaleString('id-ID');

        // toggle load more
        if (slice.length < filtered.length) {
            loadmoreWrap.style.display = 'block';
        } else {
            loadmoreWrap.style.display = 'none';
        }
    }

    function render() {
        renderedCount = PAGE_SIZE;
        renderCards();
    }

    loadmoreBtn.addEventListener('click', () => {
        renderedCount += PAGE_SIZE;
        renderCards();
    });

    /* =====================================================
       MAIN — load daftar publikasi
       ===================================================== */
    try {
        const res = await fetch('https://temp.ikad-developer.my.id/elektro/data-publikasi');
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        const data = await res.json();
        pubLoading.style.display = 'none';

        allItems = Array.isArray(data) ? data : [];

        if (allItems.length === 0) {
            pubEmpty.style.display = 'block';
            totalEl.textContent = '0';
            return;
        }

        totalEl.textContent = allItems.length.toLocaleString('id-ID');

        // Bangun chip filter tahun
        const tahunSet = [...new Set(allItems.map(i => i.tahun).filter(Boolean))].sort(sortTahunDesc);
        const chips = [{ value: 'all', label: 'Semua' }, ...tahunSet.map(t => ({ value: t, label: t }))];
        filterWrap.innerHTML = chips.map(c =>
            `<button class="tahun-chip${c.value === activeTahun ? ' active' : ''}" data-tahun="${escapeHtml(c.value)}">${escapeHtml(c.label)}</button>`
        ).join('');

        filterWrap.addEventListener('click', (e) => {
            const btn = e.target.closest('.tahun-chip');
            if (!btn) return;
            activeTahun = btn.dataset.tahun;
            filterWrap.querySelectorAll('.tahun-chip').forEach(b => b.classList.toggle('active', b === btn));
            render();
        });

        searchInput.addEventListener('input', (e) => {
            searchQuery = e.target.value.trim().toLowerCase();
            render();
        });

        render();

    } catch (err) {
        console.error(err);
        pubLoading.style.display = 'none';
        pubError.style.display = 'block';
    }

    // Load statistik paralel
    loadStatistik();
})();
</script>

<?php include 'template/footer.php'; ?>