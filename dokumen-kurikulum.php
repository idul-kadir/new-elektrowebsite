<?php
// dokumen-kurikulum.php — Halaman Dokumen Kurikulum
$pageTitle = 'Dokumen Kurikulum — Jurusan Teknik Elektro dan Komputer';
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
                <a href="#">Akademik</a> &rsaquo;&nbsp; Dokumen Kurikulum
            </div>
            <h1>Dokumen Kurikulum</h1>
            <p class="lede">Kumpulan dokumen kurikulum program studi di Jurusan Teknik Elektro dan Komputer, Fakultas Teknik UNG.</p>
        </div>
        <div class="page-banner-meta">
            <strong id="dokumen-total">—</strong> Dokumen
        </div>
    </div>
</section>

<!-- section daftar dokumen -->
<section class="prodi-section" style="padding-top:64px; background: var(--soft);">
    <div class="container">
        <div class="section-head section-head-split">
            <div class="section-head-left">
                <div class="section-eyebrow">Daftar Dokumen</div>
            </div>
            <div class="section-head-right">
                <h2 class="section-title">Kurikulum Program Studi</h2>
            </div>
        </div>
        <p class="section-desc" style="margin-top:-32px;margin-bottom:32px;max-width:760px;">
            Pilih kategori tahun atau gunakan kotak pencarian untuk menemukan dokumen kurikulum yang Anda butuhkan.
        </p>

        <!-- toolbar: search + filter tahun -->
        <div class="dokumen-toolbar">
            <!-- search box -->
            <div class="dokumen-search">
                <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.3-4.3"></path>
                </svg>
                <input type="text" id="search-input" placeholder="Cari dokumen berdasarkan judul..." autocomplete="off">
            </div>

            <!-- filter kategori tahun -->
            <div id="filter-tahun" class="dokumen-filter"></div>
        </div>

        <!-- state messages -->
        <div id="dokumen-loading" class="loading-state">
            <div class="spinner"></div>
            <p>Memuat dokumen...</p>
        </div>
        <div id="dokumen-error" class="error-state" style="display:none;">
            <p>Gagal memuat dokumen. Coba lagi nanti.</p>
        </div>
        <div id="dokumen-empty" class="empty-state" style="display:none;">
            <p>Tidak ada dokumen yang cocok dengan filter atau pencarian Anda.</p>
        </div>

        <!-- grid kartu -->
        <div id="dokumen-grid" class="dokumen-grid"></div>
    </div>
</section>

<script>
// Fetch + render dokumen Kurikulum
(async function() {
    const grid        = document.getElementById('dokumen-grid');
    const loading     = document.getElementById('dokumen-loading');
    const errorEl     = document.getElementById('dokumen-error');
    const emptyEl     = document.getElementById('dokumen-empty');
    const filterWrap  = document.getElementById('filter-tahun');
    const searchInput = document.getElementById('search-input');
    const totalEl     = document.getElementById('dokumen-total');

    let allItems = [];
    let activeTahun = 'all';
    let searchQuery = '';

    const escapeHtml = (s) => String(s ?? '').replace(/[&<>"']/g, c => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
    }[c]));

    try {
        const res = await fetch('https://temp.ikad-developer.my.id/elektro/dokumen-akademik');
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        const data = await res.json();

        loading.style.display = 'none';

        // filter kategori Kurikulum
        allItems = Array.isArray(data) ? data.filter(d => d.kategori === 'Kurikulum') : [];

        if (allItems.length === 0) {
            emptyEl.style.display = 'block';
            totalEl.textContent = '0';
            return;
        }

        totalEl.textContent = allItems.length;

        // bangun chip tahun (urut desc)
        const tahunSet = [...new Set(allItems.map(i => i.tahun))].sort((a, b) => Number(b) - Number(a));
        const chips = [{ tahun: 'all', label: 'Semua' }, ...tahunSet.map(t => ({ tahun: t, label: t.toString() }))];
        filterWrap.innerHTML = chips.map(c =>
            `<button class="tahun-chip${c.tahun === activeTahun ? ' active' : ''}" data-tahun="${c.tahun}">${c.label}</button>`
        ).join('');

        // event: klik filter tahun
        filterWrap.addEventListener('click', (e) => {
            const btn = e.target.closest('.tahun-chip');
            if (!btn) return;
            activeTahun = btn.dataset.tahun;
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
                const matchTahun = activeTahun === 'all' || d.tahun == activeTahun;
                const matchSearch = !searchQuery || (d.keterangan || '').toLowerCase().includes(searchQuery);
                return matchTahun && matchSearch;
            });

            if (filtered.length === 0) {
                grid.style.display = 'none';
                emptyEl.style.display = 'block';
                return;
            }

            grid.style.display = 'grid';
            emptyEl.style.display = 'none';

            grid.innerHTML = filtered.map(d => `
                <a href="${escapeHtml(d.file)}" target="_blank" rel="noopener" class="dokumen-card">
                    <div class="dokumen-thumb">📄</div>
                    <span class="dokumen-badge">PDF</span>
                    <div class="dokumen-content">
                        <span class="dokumen-year">${escapeHtml(d.tahun)}</span>
                        <h3 class="dokumen-title">${escapeHtml(d.keterangan)}</h3>
                        <p class="dokumen-desc">${escapeHtml(d.kategori)}</p>
                    </div>
                    <div class="dokumen-footer">
                        <span class="dokumen-meta-label">${escapeHtml(d.kategori)}</span>
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