<?php
// berita.php — Halaman Daftar Berita
// Sumber data: https://temp.ikad-developer.my.id/elektro/list-berita
// Tiap item di list punya field: judul, tanggal, gambar, link (base64), keterangan (slug)
//
// Detail berita ditampilkan via pretty URL: /berita/{slug}
// (lihat .htaccess rewrite)

$pageTitle = 'Berita — Jurusan Teknik Elektro dan Komputer';
$currentPage = 'berita';
$pageCss = ['assets/berita.css'];
include 'template/header.php';
?>

<section class="page-banner">
    <div class="container">
        <div>
            <div class="breadcrumb">
                <a href="beranda">Beranda</a> &nbsp;&rsaquo;&nbsp; Berita
            </div>
            <h1>Berita Jurusan</h1>
            <p class="lede">Kumpulan berita, pengumuman, dan aktivitas terbaru Jurusan Teknik Elektro dan Komputer.</p>
        </div>
        <div class="page-banner-meta">
            <strong>📰</strong>
            Update Terbaru
        </div>
    </div>
</section>

<section class="prodi-section" id="berita-list" style="padding-top:64px;">
    <div class="container">

        <!-- Toolbar: search + info -->
        <div class="berita-toolbar">
            <div class="berita-search">
                <span class="berita-search-icon" aria-hidden="true">⌕</span>
                <input id="beritaSearch" type="search" placeholder="Cari berita…" autocomplete="off" aria-label="Cari berita">
            </div>
            <div class="berita-meta-info">
                <span id="beritaCount">Memuat…</span>
            </div>
        </div>

        <!-- State: loading -->
        <div id="berita-loading" class="berita-state">
            <div class="spinner"></div>
            <p>Memuat daftar berita…</p>
        </div>

        <!-- State: error -->
        <div id="berita-error" class="berita-state berita-state-error" hidden>
            <div class="err-icon">!</div>
            <p>Gagal memuat berita dari server. Silakan coba lagi nanti.</p>
            <button type="button" id="beritaRetry" class="berita-retry">Coba lagi</button>
        </div>

        <!-- State: empty (setelah search) -->
        <div id="berita-empty" class="berita-state" hidden>
            <p>Tidak ada berita yang cocok dengan pencarian Anda.</p>
        </div>

        <!-- Grid berita -->
        <div id="beritaGrid" class="berita-grid" hidden></div>

        <!-- Tombol muat lebih banyak -->
        <div id="beritaMoreWrap" class="berita-more-wrap" hidden>
            <button type="button" id="beritaMore" class="berita-more-btn">Muat Lebih Banyak</button>
        </div>

    </div>
</section>

<script>
(function () {
    'use strict';

    const API_URL = 'https://temp.ikad-developer.my.id/elektro/list-berita';

    const grid      = document.getElementById('beritaGrid');
    const loadingEl = document.getElementById('berita-loading');
    const errorEl   = document.getElementById('berita-error');
    const emptyEl   = document.getElementById('berita-empty');
    const countEl   = document.getElementById('beritaCount');
    const moreWrap  = document.getElementById('beritaMoreWrap');
    const moreBtn   = document.getElementById('beritaMore');
    const retryBtn  = document.getElementById('beritaRetry');
    const searchEl  = document.getElementById('beritaSearch');

    let allItems   = [];
    let filtered   = [];
    let pageSize   = 9;
    let pageIndex  = 0;

    function escapeHtml(s) {
        return String(s).replace(/[&<>"']/g, ch => ({
            '&': '&amp;', '<': '&lt;', '>': '&gt;',
            '"': '&quot;', "'": '&#39;'
        }[ch]));
    }

    function tglIndo(tgl) {
        if (!tgl) return '';
        const ts = Date.parse(tgl);
        if (isNaN(ts)) return tgl;
        const bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                       'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        return new Date(ts).getDate() + ' ' + bulan[new Date(ts).getMonth() + 1] + ' ' + new Date(ts).getFullYear();
    }

    function cardHtml(it) {
        const img   = escapeHtml(it.gambar || '');
        const judul = escapeHtml(it.judul || '(Tanpa judul)');
        const slug  = encodeURIComponent(it.keterangan || '');
        const date  = tglIndo(it.tanggal);
        const dateHtml = date ? `<div class="berita-card-date">${date}</div>` : '';
        const href = slug ? 'detail-berita?slug=' + slug : '#';
        return [
            '<article class="berita-card">',
                '<a class="berita-card-media" href="' + href + '" aria-label="' + judul + '">',
                    '<img src="' + img + '" alt="' + judul + '" loading="lazy" onerror="this.style.display=\'none\';">',
                '</a>',
                '<div class="berita-card-body">',
                    dateHtml,
                    '<h3><a href="' + href + '">' + judul + '</a></h3>',
                    '<a class="berita-card-link" href="' + href + '">Baca selengkapnya</a>',
                '</div>',
            '</article>'
        ].join('');
    }

    function show(el) { if (el) el.hidden = false; }
    function hide(el) { if (el) el.hidden = true; }

    function applyFilter() {
        const q = (searchEl.value || '').trim().toLowerCase();
        filtered = q
            ? allItems.filter(it => (it.judul || '').toLowerCase().includes(q))
            : allItems.slice();
        pageIndex = 0;
        grid.innerHTML = '';
        if (filtered.length === 0) {
            show(emptyEl);
            hide(moreWrap);
            countEl.textContent = '0 berita';
        } else {
            hide(emptyEl);
            renderNextPage();
            countEl.textContent = filtered.length + ' berita';
        }
    }

    function renderNextPage() {
        const start = pageIndex * pageSize;
        const slice = filtered.slice(start, start + pageSize);
        if (slice.length === 0) return;
        const frag = document.createElement('div');
        frag.innerHTML = slice.map(cardHtml).join('');
        while (frag.firstChild) grid.appendChild(frag.firstChild);
        pageIndex++;
        if (pageIndex * pageSize < filtered.length) show(moreWrap);
        else hide(moreWrap);
    }

    async function load() {
        hide(grid); hide(emptyEl); hide(moreWrap);
        show(loadingEl); hide(errorEl);
        countEl.textContent = 'Memuat…';

        try {
            const res = await fetch(API_URL, { method: 'GET' });
            if (!res.ok) throw new Error('HTTP ' + res.status);
            const data = await res.json();
            if (!Array.isArray(data)) throw new Error('Format data tidak valid');

            allItems = data.filter(it => it && it.judul);
            hide(loadingEl);
            show(grid);
            applyFilter();
        } catch (err) {
            console.error('Berita load error:', err);
            hide(loadingEl);
            show(errorEl);
            countEl.textContent = '—';
        }
    }

    retryBtn.addEventListener('click', load);
    moreBtn.addEventListener('click', renderNextPage);
    searchEl.addEventListener('input', applyFilter);

    load();
})();
</script>

<?php include 'template/footer.php'; ?>