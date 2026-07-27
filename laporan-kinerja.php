<?php
// laporan-kinerja.php — Halaman Laporan Kinerja
$pageTitle = 'Laporan Kinerja — Jurusan Teknik Elektro dan Komputer';
$currentPage = 'akademik';
$pageCss = ['assets/kurikulum.css', 'assets/panduan-sop.css'];
include 'template/header.php';
?>

<!-- page banner -->
<section class="page-banner">
    <div class="container">
        <div>
            <div class="breadcrumb">
                <a href="beranda">Beranda</a> &rsaquo;&nbsp;
                <a href="#">Akademik</a> &rsaquo;&nbsp; Laporan Kinerja
            </div>
            <h1>Laporan Kinerja</h1>
            <p class="lede">Dokumen laporan kinerja Jurusan Teknik Elektro dan Komputer, Fakultas Teknik UNG.</p>
        </div>
        <div class="page-banner-meta">
            <strong id="dokumen-total">—</strong> Dokumen
        </div>
    </div>
</section>

<!-- section daftar laporan -->
<section class="prodi-section" style="padding-top:64px; background: var(--soft);">
    <div class="container">
        <div class="section-head section-head-split">
            <div class="section-head-left">
                <div class="section-eyebrow">Daftar Laporan</div>
            </div>
            <div class="section-head-right">
                <h2 class="section-title">Laporan Kinerja</h2>
            </div>
        </div>
        <p class="section-desc" style="margin-top:-32px;margin-bottom:32px;max-width:760px;">
            Pilih periode atau gunakan kotak pencarian untuk menemukan laporan yang Anda butuhkan.
        </p>

        <!-- toolbar: search + filter periode -->
        <div class="dokumen-toolbar">
            <!-- search box -->
            <div class="dokumen-search">
                <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.3-4.3"></path>
                </svg>
                <input type="text" id="search-input" placeholder="Cari laporan berdasarkan judul..." autocomplete="off">
            </div>

            <!-- filter kategori periode -->
            <div id="filter-tahun" class="dokumen-filter"></div>
        </div>

        <!-- state messages -->
        <div id="dokumen-loading" class="loading-state">
            <div class="spinner"></div>
            <p>Memuat laporan...</p>
        </div>
        <div id="dokumen-error" class="error-state" style="display:none;">
            <p>Gagal memuat laporan. Coba lagi nanti.</p>
        </div>
        <div id="dokumen-empty" class="empty-state" style="display:none;">
            <p>Tidak ada laporan yang cocok dengan filter atau pencarian Anda.</p>
        </div>

        <!-- grid kartu -->
        <div id="dokumen-grid" class="dokumen-grid"></div>
    </div>
</section>

<script>
// Fetch + render laporan kinerja
(async function() {
    const grid        = document.getElementById('dokumen-grid');
    const loading     = document.getElementById('dokumen-loading');
    const errorEl     = document.getElementById('dokumen-error');
    const emptyEl     = document.getElementById('dokumen-empty');
    const filterWrap  = document.getElementById('filter-tahun');
    const searchInput = document.getElementById('search-input');
    const totalEl     = document.getElementById('dokumen-total');

    let allItems = [];
    let activePeriode = 'all';
    let searchQuery = '';

    const escapeHtml = (s) => String(s ?? '').replace(/[&<>"']/g, c => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
    }[c]));

    // Normalisasi URL Google Drive
    function normalizeUrl(url) {
        if (!url) return '#';
        const match = url.match(/drive\.google\.com\/file\/d\/([a-zA-Z0-9_-]+)/);
        if (match) return `https://drive.google.com/file/d/${match[1]}/view`;
        return url;
    }

    // Sortir periode (ascending: tahun terkecil dulu, tapi rentang ditaruh belakangan)
    function sortPeriode(a, b) {
        const getStart = (p) => {
            const m = String(p).match(/(\d{4})/);
            return m ? parseInt(m[1], 10) : 0;
        };
        const sa = getStart(a);
        const sb = getStart(b);
        if (sa !== sb) return sb - sa; // desc by start year
        return String(a).localeCompare(String(b));
    }

    try {
        const res = await fetch('https://temp.ikad-developer.my.id/elektro/laporan-kinerja');
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        const data = await res.json();

        loading.style.display = 'none';

        allItems = Array.isArray(data) ? data : [];

        if (allItems.length === 0) {
            emptyEl.style.display = 'block';
            totalEl.textContent = '0';
            return;
        }

        totalEl.textContent = allItems.length;

        // Bangun chip periode
        const periodeSet = [...new Set(allItems.map(i => i.periode || 'Lainnya'))].sort(sortPeriode);
        const chips = [{ value: 'all', label: 'Semua' }, ...periodeSet.map(p => ({ value: p, label: String(p) }))];
        filterWrap.innerHTML = chips.map(c =>
            `<button class="tahun-chip${c.value === activePeriode ? ' active' : ''}" data-periode="${escapeHtml(c.value)}">${escapeHtml(c.label)}</button>`
        ).join('');

        // event: klik filter periode
        filterWrap.addEventListener('click', (e) => {
            const btn = e.target.closest('.tahun-chip');
            if (!btn) return;
            activePeriode = btn.dataset.periode;
            filterWrap.querySelectorAll('.tahun-chip').forEach(b => b.classList.toggle('active', b === btn));
            render();
        });

        // event: ketik di search
        searchInput.addEventListener('input', (e) => {
            searchQuery = e.target.value.trim().toLowerCase();
            render();
        });

        // render kartu
        function render() {
            const filtered = allItems.filter(d => {
                const matchPeriode = activePeriode === 'all' || (d.periode || 'Lainnya') === activePeriode;
                const matchSearch = !searchQuery ||
                    (d.keterangan || '').toLowerCase().includes(searchQuery) ||
                    (d.pengunggah || '').toLowerCase().includes(searchQuery);
                return matchPeriode && matchSearch;
            });

            if (filtered.length === 0) {
                grid.style.display = 'none';
                emptyEl.style.display = 'block';
                return;
            }

            grid.style.display = 'grid';
            emptyEl.style.display = 'none';

            grid.innerHTML = filtered.map(d => `
                <a href="${escapeHtml(normalizeUrl(d.file))}" target="_blank" rel="noopener" class="dokumen-card">
                    <div class="dokumen-thumb">📊</div>
                    <span class="dokumen-badge">PDF</span>
                    <div class="dokumen-content">
                        <span class="dokumen-year">${escapeHtml(d.periode || '-')}</span>
                        <h3 class="dokumen-title">${escapeHtml(d.keterangan || '(Tanpa judul)')}</h3>
                        ${d.pengunggah ? `<p class="dokumen-desc">Diupload oleh ${escapeHtml(d.pengunggah)}</p>` : ''}
                    </div>
                    <div class="dokumen-footer">
                        <span class="dokumen-meta-label">Laporan Kinerja</span>
                        <span class="dokumen-open">Buka</span>
                    </div>
                </a>
            `).join('');
        }

        render();

    } catch (err) {
        console.error(err);
        loading.style.display = 'none';
        errorEl.style.display = 'block';
    }
})();
</script>

<?php include 'template/footer.php'; ?>