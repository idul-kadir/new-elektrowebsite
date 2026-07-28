<?php
// alumni.php — Halaman Direktori Alumni Jurusan Teknik Elektro dan Komputer
// Data diambil dari API: https://temp.ikad-developer.my.id/elektro/data-alumni

$pageTitle = 'Alumni — Jurusan Teknik Elektro dan Komputer';
$currentPage = 'alumni';
$pageCss = ['assets/kurikulum.css', 'assets/publikasi.css', 'assets/alumni.css'];
include 'template/header.php';
?>

<!-- page banner -->
<section class="page-banner">
    <div class="container">
        <div>
            <div class="breadcrumb">
                <a href="beranda">Beranda</a> &nbsp;&rsaquo;&nbsp; Alumni
            </div>
            <h1>Direktori Alumni</h1>
            <p class="lede">Daftar lulusan Jurusan Teknik Elektro dan Komputer, Universitas Negeri Gorontalo, beserta judul tugas akhir dan tahun kelulusan.</p>
        </div>
        <div class="page-banner-meta">
            <strong id="alm-total">—</strong>
            Total Alumni
        </div>
    </div>
</section>

<!-- ============================================
     SECTION 1 — STATISTIK
     ============================================ -->
<section class="prodi-section" id="alumni">
    <div class="container">
        <div class="section-head section-head-split">
            <div class="section-head-left">
                <div class="section-eyebrow">Statistik</div>
            </div>
            <div class="section-head-right">
                <h2 class="section-title">Rekapitulasi Alumni</h2>
            </div>
        </div>
        <p class="section-desc" style="margin-top:-32px;margin-bottom:32px;max-width:760px;">
            Ringkasan singkat jumlah alumni, rentang tahun kelulusan, lulusan terbaru, dan rata-rata kelulusan per tahun.
        </p>

        <!-- Stats row (4 angka) -->
        <div class="alm-stats-row">
            <div class="alm-stat">
                <span class="alm-stat-label">Total Alumni</span>
                <span class="alm-stat-value" id="alm-stat-total">—</span>
            </div>
            <div class="alm-stat">
                <span class="alm-stat-label">Tahun Aktif</span>
                <span class="alm-stat-value" id="alm-stat-years">—</span>
            </div>
            <div class="alm-stat">
                <span class="alm-stat-label">Lulusan Terbaru</span>
                <span class="alm-stat-value" id="alm-stat-latest">—</span>
            </div>
            <div class="alm-stat">
                <span class="alm-stat-label">Rata-rata / Tahun</span>
                <span class="alm-stat-value" id="alm-stat-avg">—</span>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
     SECTION 2 — DIREKTORI ALUMNI
     ============================================ -->
<section class="prodi-section">
    <div class="container">
        <div class="section-head section-head-split">
            <div class="section-head-left">
                <div class="section-eyebrow">Direktori</div>
            </div>
            <div class="section-head-right">
                <h2 class="section-title">Daftar Alumni</h2>
            </div>
        </div>
        <p class="section-desc" style="margin-top:-32px;margin-bottom:32px;max-width:760px;">
            Cari berdasarkan nama, NIM, atau kata kunci judul. Filter berdasarkan tahun lulus, atau urutkan dari yang terbaru.
        </p>

        <!-- toolbar -->
        <div class="dokumen-toolbar alm-toolbar">
            <div class="dokumen-search">
                <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.3-4.3"></path>
                </svg>
                <input type="text" id="alm-search" placeholder="Cari nama, NIM, atau judul…" autocomplete="off">
            </div>
            <div class="alm-toolbar-right">
                <div id="alm-filter-tahun" class="dokumen-filter"></div>
                <label class="alm-sort" for="alm-sort-select">
                    <span class="alm-sort-label">Urut</span>
                    <select id="alm-sort-select" aria-label="Urutkan">
                        <option value="terbaru">Terbaru</option>
                        <option value="az">A–Z</option>
                    </select>
                </label>
            </div>
        </div>

        <!-- meta hasil -->
        <div id="alm-result-meta" class="alm-result-meta" style="display:none;">
            Menampilkan <strong id="alm-shown">0</strong> dari <strong id="alm-filtered-total">0</strong> alumni
        </div>

        <!-- state messages -->
        <div id="alm-loading" class="loading-state">
            <div class="spinner"></div>
            <p>Memuat data alumni...</p>
        </div>
        <div id="alm-error" class="error-state" style="display:none;">
            <p>Gagal memuat data alumni. Coba lagi nanti.</p>
        </div>
        <div id="alm-empty" class="empty-state" style="display:none;">
            <p>Tidak ada alumni yang cocok dengan filter atau pencarian Anda.</p>
        </div>

        <!-- grid -->
        <div id="alm-grid" class="alm-grid"></div>

        <!-- load more -->
        <div id="alm-loadmore-wrap" style="display:none; margin-top:32px; text-align:center;">
            <button id="alm-loadmore" class="pub-loadmore-btn">Muat Lebih Banyak</button>
        </div>
    </div>
</section>

<script>
/* ============================================================
   Alumni — load + filter + search + sort + paginasi
   ============================================================ */
(async function() {
    /* ============ STATE ============ */
    // Endpoint base — diset sendiri di sini (meskipun `const API` juga di-global
    // oleh template/footer.php, urutan eksekusi script membuat variabel itu
    // belum tersedia di sini karena script ini jalan lebih dulu).
    const API = 'https://temp.ikad-developer.my.id/elektro';

    const PAGE_SIZE = 12;
    let allItems = [];
    let activeTahun = 'all';
    let searchQuery = '';
    let sortMode = 'terbaru'; // 'terbaru' | 'az'
    let renderedCount = 0;

    /* ============ DOM ============ */
    const $ = (id) => document.getElementById(id);
    const grid         = $('alm-grid');
    const loading      = $('alm-loading');
    const errorState   = $('alm-error');
    const empty        = $('alm-empty');
    const filterWrap   = $('alm-filter-tahun');
    const searchInput  = $('alm-search');
    const sortSelect   = $('alm-sort-select');
    const totalEl      = $('alm-total');
    const resultMeta   = $('alm-result-meta');
    const shownEl      = $('alm-shown');
    const filteredEl   = $('alm-filtered-total');
    const loadmoreWrap = $('alm-loadmore-wrap');
    const loadmoreBtn  = $('alm-loadmore');
    const statTotal    = $('alm-stat-total');
    const statYears    = $('alm-stat-years');
    const statLatest   = $('alm-stat-latest');
    const statAvg      = $('alm-stat-avg');

    /* ============ UTIL ============ */
    const escapeHtml = (s) => String(s ?? '').replace(/[&<>"']/g, c => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
    }[c]));

    // Highlight teks hasil pencarian di nama
    const highlightMatch = (text, q) => {
        const safe = escapeHtml(text);
        if (!q) return safe;
        const tokens = q.split(/\s+/).filter(Boolean).map(t => t.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'));
        if (tokens.length === 0) return safe;
        const re = new RegExp(`(${tokens.join('|')})`, 'gi');
        return safe.replace(re, '<mark>$1</mark>');
    };

    // Inisial 2 huruf dari nama untuk fallback foto
    const initials = (nama) => {
        const parts = String(nama || '').trim().split(/\s+/).filter(Boolean);
        if (parts.length === 0) return 'AL';
        if (parts.length === 1) return parts[0].slice(0, 2).toUpperCase();
        return (parts[0][0] + parts[parts.length - 1][0]).toUpperCase();
    };

    // Normalisasi path foto: relative -> absolute ke API base
    const normalizeFoto = (raw) => {
        if (!raw || typeof raw !== 'string') return null;
        const url = raw.trim();
        if (!url) return null;
        if (/^https?:\/\//i.test(url)) return url;
        // path relatif seperti "foto/alumni.jpeg" → gabung dengan base API
        if (url.startsWith('/')) return API + url;
        return API + '/' + url;
    };

    /* =====================================================
       COMPUTE STATS dari allItems
       ===================================================== */
    function computeStats(items) {
        const total = items.length;
        if (total === 0) {
            statTotal.textContent = '0';
            statYears.textContent = '—';
            statLatest.textContent = '—';
            statAvg.textContent = '—';
            return;
        }

        const tahunSet = items
            .map(i => String(i.tahun_lulus || '').trim())
            .filter(Boolean)
            .map(Number)
            .filter(n => Number.isFinite(n));
        const tahunMin = Math.min(...tahunSet);
        const tahunMax = Math.max(...tahunSet);
        const range = tahunMax - tahunMin + 1;

        const latestItem = items.find(i => String(i.tahun_lulus) === String(tahunMax));
        const latestYear = tahunMax;

        statTotal.textContent = total.toLocaleString('id-ID');
        statYears.textContent = tahunMin === tahunMax
            ? String(tahunMax)
            : `${tahunMin}–${tahunMax}`;
        statLatest.textContent = latestItem ? latestYear : '—';
        // Rata-rata dihitung hanya dari tahun yang ada di data
        const tahunUnik = new Set(tahunSet).size;
        statAvg.textContent = tahunUnik > 0
            ? Math.round(total / tahunUnik).toLocaleString('id-ID')
            : '—';
    }

    /* =====================================================
       FILTER + SORT
       ===================================================== */
    function getFiltered() {
        const q = searchQuery.toLowerCase();
        let list = allItems.filter(d => {
            const matchTahun = activeTahun === 'all' || String(d.tahun_lulus) === activeTahun;
            if (!matchTahun) return false;
            if (!q) return true;
            return (
                (d.nama || '').toLowerCase().includes(q) ||
                (d.nim || '').toLowerCase().includes(q) ||
                (d.judul || '').toLowerCase().includes(q)
            );
        });

        if (sortMode === 'az') {
            list = list.sort((a, b) =>
                (a.nama || '').localeCompare(b.nama || '', 'id', { sensitivity: 'base' })
            );
        } else {
            // terbaru: tahun desc → tanggal desc → urutan desc
            list = list.sort((a, b) => {
                const ta = Number(a.tahun_lulus) || 0;
                const tb = Number(b.tahun_lulus) || 0;
                if (tb !== ta) return tb - ta;
                const da = String(a.tanggal_lulus || '');
                const db = String(b.tanggal_lulus || '');
                if (db !== da) return db.localeCompare(da);
                return Number(b.urutan || 0) - Number(a.urutan || 0);
            });
        }
        return list;
    }

    /* =====================================================
       RENDER CARDS (append, untuk load-more)
       ===================================================== */
    function appendCards(items, offset, limit) {
        const slice = items.slice(offset, offset + limit);
        const html = slice.map(d => {
            const fotoUrl = normalizeFoto(d.profil);
            const fbText = initials(d.nama);
            const judul = (d.judul || '').trim();
            const judulHtml = judul
                ? `<p class="alm-judul">${escapeHtml(judul)}</p>`
                : `<p class="alm-judul empty">Judul tidak tersedia</p>`;
            const fotoAction = fotoUrl
                ? `<a class="alm-photo-link" href="${escapeHtml(fotoUrl)}" target="_blank" rel="noopener" aria-label="Lihat foto ${escapeHtml(d.nama || 'alumni')}">
                       <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                           <path d="M14 3h7v7"/><path d="M10 14L21 3"/><path d="M21 14v7H3V3h7"/>
                       </svg>
                       Lihat Foto
                   </a>`
                : '';
            return `
                <article class="alm-card">
                    <div class="alm-photo-wrap">
                        <img class="alm-photo" src="${escapeHtml(fotoUrl || '')}" alt="Foto ${escapeHtml(d.nama || 'alumni')}" loading="lazy"
                             onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                        <span class="alm-fallback" aria-hidden="true">${escapeHtml(fbText)}</span>
                    </div>
                    <div class="alm-body">
                        <div class="alm-meta-row">
                            <span class="alm-nim">${escapeHtml(d.nim || '-')}</span>
                            ${d.tahun_lulus ? `<span class="alm-year-badge">${escapeHtml(String(d.tahun_lulus))}</span>` : ''}
                        </div>
                        <h3 class="alm-name">${highlightMatch(d.nama || 'Tanpa nama', searchQuery)}</h3>
                        ${judulHtml}
                    </div>
                    ${fotoAction ? `<div class="alm-action">${fotoAction}</div>` : '<div class="alm-action"></div>'}
                </article>
            `;
        }).join('');
        grid.insertAdjacentHTML('beforeend', html);
    }

    function render(initial = false) {
        const filtered = getFiltered();
        if (initial) {
            grid.innerHTML = '';
            renderedCount = 0;
        }

        if (filtered.length === 0) {
            grid.style.display = 'none';
            empty.style.display = 'block';
            resultMeta.style.display = 'none';
            loadmoreWrap.style.display = 'none';
            return;
        }

        empty.style.display = 'none';

        // Tentukan slice yang akan dirender.
        // Saat initial → 1 batch pertama. Saat load-more → batch berikutnya.
        const nextCount = initial ? PAGE_SIZE : (renderedCount + PAGE_SIZE);
        appendCards(filtered, renderedCount, nextCount - renderedCount);
        renderedCount = nextCount;

        // update meta
        resultMeta.style.display = 'block';
        shownEl.textContent = Math.min(renderedCount, filtered.length).toLocaleString('id-ID');
        filteredEl.textContent = filtered.length.toLocaleString('id-ID');

        // toggle load more
        loadmoreWrap.style.display = (renderedCount < filtered.length) ? 'block' : 'none';
        grid.style.display = 'grid';
    }

    /* =====================================================
       LOAD DATA
       ===================================================== */
    try {
        const res = await fetch(API + '/data-alumni');
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        const data = await res.json();
        loading.style.display = 'none';

        allItems = Array.isArray(data) ? data : [];

        if (allItems.length === 0) {
            empty.style.display = 'block';
            totalEl.textContent = '0';
            return;
        }

        totalEl.textContent = allItems.length.toLocaleString('id-ID');
        computeStats(allItems);

        // Bangun chip tahun
        const tahunSet = [...new Set(
            allItems.map(i => String(i.tahun_lulus || '')).filter(Boolean)
        )].sort((a, b) => Number(b) - Number(a));
        const chips = [{ value: 'all', label: 'Semua' },
                       ...tahunSet.map(t => ({ value: t, label: t }))];
        filterWrap.innerHTML = chips.map(c =>
            `<button class="tahun-chip${c.value === activeTahun ? ' active' : ''}" data-tahun="${escapeHtml(c.value)}">${escapeHtml(c.label)}</button>`
        ).join('');

        filterWrap.addEventListener('click', (e) => {
            const btn = e.target.closest('.tahun-chip');
            if (!btn) return;
            activeTahun = btn.dataset.tahun;
            filterWrap.querySelectorAll('.tahun-chip').forEach(b => b.classList.toggle('active', b === btn));
            render(true);
        });

        // Search dengan debounce
        let debounce;
        searchInput.addEventListener('input', (e) => {
            clearTimeout(debounce);
            debounce = setTimeout(() => {
                searchQuery = e.target.value.trim().toLowerCase();
                render(true);
            }, 180);
        });

        // Sort
        sortSelect.addEventListener('change', (e) => {
            sortMode = e.target.value;
            render(true);
        });

        // Load more
        loadmoreBtn.addEventListener('click', () => {
            render(false);
        });

        // First render
        render(true);

    } catch (err) {
        console.error('alumni fetch error:', err);
        loading.style.display = 'none';
        errorState.style.display = 'block';
        errorState.innerHTML = `<p>Gagal memuat data alumni.</p>
            <p style="margin-top:6px; font-size:12.5px; opacity:.8;">Detail: ${escapeHtml(err && err.message ? err.message : 'unknown error')}</p>`;
    }
})();
</script>

<?php include 'template/footer.php'; ?>
