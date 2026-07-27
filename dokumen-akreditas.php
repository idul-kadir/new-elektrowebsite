<?php
// dokumen-akreditas.php — Halaman Dokumen Akreditasi
$pageTitle = 'Dokumen Akreditasi — Jurusan Teknik Elektro dan Komputer';
$currentPage = 'akademik';
$pageCss = ['assets/kurikulum.css', 'assets/akreditas.css'];
include 'template/header.php';
?>

<!-- page banner -->
<section class="page-banner">
    <div class="container">
        <div>
            <div class="breadcrumb">
                <a href="beranda">Beranda</a> &rsaquo;&nbsp;
                <a href="#">Akademik</a> &rsaquo;&nbsp; Dokumen Akreditasi
            </div>
            <h1>Dokumen Akreditasi</h1>
            <p class="lede">Dokumen akreditasi Jurusan Teknik Elektro dan Komputer yang dipetakan berdasarkan 9 komponen kriteria (C1–C9).</p>
        </div>
        <div class="page-banner-meta">
            <strong id="akred-total">—</strong> Dokumen
        </div>
    </div>
</section>

<!-- section accordion C1-C9 -->
<section class="prodi-section" style="padding-top:64px; background: var(--soft);">
    <div class="container">
        <div class="section-head section-head-split">
            <div class="section-head-left">
                <div class="section-eyebrow">9 Kriteria</div>
            </div>
            <div class="section-head-right">
                <h2 class="section-title">Pemetaan Dokumen Akreditasi</h2>
            </div>
        </div>
        <p class="section-desc" style="margin-top:-32px;margin-bottom:32px;max-width:760px;">
            Klik kategori untuk membuka/menutup daftar dokumen. Gunakan kotak pencarian untuk mencari dokumen di seluruh kategori.
        </p>

        <!-- toolbar search + filter jenis -->
        <div class="dokumen-toolbar">
            <div class="dokumen-search">
                <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.3-4.3"></path>
                </svg>
                <input type="text" id="search-input" placeholder="Cari dokumen..." autocomplete="off">
            </div>
            <div id="filter-jenis" class="dokumen-filter"></div>
        </div>

        <!-- state messages -->
        <div id="akred-loading" class="loading-state">
            <div class="spinner"></div>
            <p>Memuat dokumen akreditasi...</p>
        </div>
        <div id="akred-error" class="error-state" style="display:none;">
            <p>Gagal memuat dokumen. Coba lagi nanti.</p>
        </div>
        <div id="akred-empty" class="empty-state" style="display:none;">
            <p>Tidak ada dokumen yang cocok dengan pencarian Anda.</p>
        </div>

        <!-- accordion kategori -->
        <div id="akred-accordion" class="akred-accordion"></div>
    </div>
</section>

<script>
// Fetch + render dokumen akreditasi C1-C9
(async function() {
    const accordion   = document.getElementById('akred-accordion');
    const loading     = document.getElementById('akred-loading');
    const errorEl     = document.getElementById('akred-error');
    const emptyEl     = document.getElementById('akred-empty');
    const filterWrap  = document.getElementById('filter-jenis');
    const searchInput = document.getElementById('search-input');
    const totalEl     = document.getElementById('akred-total');

    let allItems = [];
    let activeJenis = 'all';
    let searchQuery = '';

    // Daftar 9 kategori berurutan
    const CATEGORIES = [
        { code: 'c1', label: 'Visi, Misi, Tujuan, dan Strategi' },
        { code: 'c2', label: 'Tata Pamong, Tata Kelola, dan Kerjasama' },
        { code: 'c3', label: 'Mahasiswa' },
        { code: 'c4', label: 'Sumber Daya Manusia' },
        { code: 'c5', label: 'Keuangan, Sarana, dan Prasarana' },
        { code: 'c6', label: 'Pendidikan' },
        { code: 'c7', label: 'Penelitian' },
        { code: 'c8', label: 'Pengabdian kepada Masyarakat' },
        { code: 'c9', label: 'Luaran dan Capaian Tridharma' },
    ];

    const escapeHtml = (s) => String(s ?? '').replace(/[&<>"']/g, c => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
    }[c]));

    // Konversi URL Google Drive ke format preview yang lebih bersih
    function normalizeUrl(url) {
        if (!url) return '#';
        const match = url.match(/drive\.google\.com\/file\/d\/([a-zA-Z0-9_-]+)/);
        if (match) {
            return `https://drive.google.com/file/d/${match[1]}/view`;
        }
        return url;
    }

    try {
        const res = await fetch('https://temp.ikad-developer.my.id/elektro/dokumen-akreditas');
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

        // Bangun filter jenis (SK, Dokumen, Berita Acara, Lainnya)
        const jenisSet = [...new Set(allItems.map(i => i.jenis || 'Lainnya'))].sort();
        const jenisChips = [{ value: 'all', label: 'Semua Jenis' }, ...jenisSet.map(j => ({ value: j, label: j }))];
        filterWrap.innerHTML = jenisChips.map(c =>
            `<button class="tahun-chip${c.value === activeJenis ? ' active' : ''}" data-jenis="${escapeHtml(c.value)}">${escapeHtml(c.label)}</button>`
        ).join('');

        filterWrap.addEventListener('click', (e) => {
            const btn = e.target.closest('.tahun-chip');
            if (!btn) return;
            activeJenis = btn.dataset.jenis;
            filterWrap.querySelectorAll('.tahun-chip').forEach(b => b.classList.toggle('active', b === btn));
            render();
        });

        searchInput.addEventListener('input', (e) => {
            searchQuery = e.target.value.trim().toLowerCase();
            render();
        });

        function render() {
            accordion.innerHTML = '';

            let totalShown = 0;

            CATEGORIES.forEach((cat, idx) => {
                const items = allItems.filter(d => {
                    const matchKategori = (d.kategori || '').toLowerCase() === cat.code;
                    const matchJenis = activeJenis === 'all' || (d.jenis || 'Lainnya') === activeJenis;
                    const matchSearch = !searchQuery ||
                        (d.nama || '').toLowerCase().includes(searchQuery) ||
                        (d.keterangan || '').toLowerCase().includes(searchQuery);
                    return matchKategori && matchJenis && matchSearch;
                });

                totalShown += items.length;

                // sembunyikan kategori kosong jika ada filter aktif
                const isHiddenByFilter = (activeJenis !== 'all' || searchQuery) && items.length === 0;

                if (isHiddenByFilter) return;

                const isOpen = false; // semua kategori tertutup saat pertama load

                const catCard = document.createElement('div');
                catCard.className = 'akred-cat';
                catCard.dataset.open = isOpen ? 'true' : 'false';

                catCard.innerHTML = `
                    <button class="akred-cat-head" type="button" aria-expanded="${isOpen}">
                        <span class="akred-cat-code">${escapeHtml(cat.code.toUpperCase())}</span>
                        <span class="akred-cat-label">${escapeHtml(cat.label)}</span>
                        <span class="akred-cat-count">${items.length}</span>
                        <span class="akred-cat-toggle" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round">
                                <path d="M6 9l6 6 6-6"/>
                            </svg>
                        </span>
                    </button>
                    <div class="akred-cat-body" ${isOpen ? '' : 'hidden'}>
                        ${items.length === 0
                            ? '<p class="akred-cat-empty">Tidak ada dokumen pada kategori ini.</p>'
                            : `<ul class="akred-list">${items.map(d => `
                                <li class="akred-item">
                                    <a href="${escapeHtml(normalizeUrl(d.file))}" target="_blank" rel="noopener" class="akred-link">
                                        <div class="akred-item-main">
                                            <span class="akred-jenis-badge akred-jenis-${escapeHtml((d.jenis || 'Lainnya').toLowerCase().replace(/\s+/g, '-'))}">${escapeHtml(d.jenis || 'Lainnya')}</span>
                                            <h4 class="akred-item-title">${escapeHtml(d.nama || '(Tanpa judul)')}</h4>
                                            ${d.keterangan && d.keterangan !== d.nama ? `<p class="akred-item-desc">${escapeHtml(d.keterangan)}</p>` : ''}
                                        </div>
                                        <div class="akred-item-meta">
                                            <span class="akred-tahun">${escapeHtml(d.tahun || '-')}</span>
                                            <span class="akred-open">Buka ↗</span>
                                        </div>
                                    </a>
                                </li>`).join('')}</ul>`
                        }
                    </div>
                `;
                accordion.appendChild(catCard);
            });

            // toggle accordion
            accordion.querySelectorAll('.akred-cat-head').forEach(btn => {
                btn.addEventListener('click', () => {
                    const cat = btn.closest('.akred-cat');
                    const body = cat.querySelector('.akred-cat-body');
                    const isOpen = cat.dataset.open === 'true';
                    cat.dataset.open = (!isOpen).toString();
                    btn.setAttribute('aria-expanded', String(!isOpen));
                    if (isOpen) {
                        body.setAttribute('hidden', '');
                    } else {
                        body.removeAttribute('hidden');
                    }
                });
            });

            // tampilkan empty jika tidak ada hasil sama sekali
            if (totalShown === 0) {
                emptyEl.style.display = 'block';
                accordion.style.display = 'none';
            } else {
                emptyEl.style.display = 'none';
                accordion.style.display = 'block';
            }
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