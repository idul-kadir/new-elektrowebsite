<?php
$pageTitle = 'Tenaga Pendidik — Jurusan Teknik Elektro dan Komputer';
$pageDesc = 'Daftar dosen tenaga pendidik Jurusan Teknik Elektro dan Komputer UNG.';
$currentPage = 'dosen';
$pageCss = ['assets/dosen.css'];
include 'header.php';
?>

<!-- page banner -->
<section class="page-banner">
    <div class="container">
        <div>
            <div class="breadcrumb"><a href="index.php">Beranda</a> &nbsp;&rsaquo;&nbsp; <a href="profil.php">Profil</a> &nbsp;&rsaquo;&nbsp; Tenaga Pendidik</div>
            <h1>Tenaga Pendidik</h1>
            <p class="lede">Daftar dosen Jurusan Teknik Elektro dan Komputer, Fakultas Teknik, Universitas Negeri Gorontalo.</p>
        </div>
        <div class="page-banner-meta">
            <strong id="dosenCount">—</strong>
            Tenaga Pendidik
        </div>
    </div>
</section>

<!-- TENAGA PENDIDIK -->
<section id="dosen" style="background: var(--soft);">
    <div class="container">
        <div class="section-head">
            <div class="section-eyebrow">Tenaga Pendidik</div>
            <h2 class="section-title">Dosen Jurusan</h2>
            <p class="section-desc">Sumber data: <a href="https://temp.ikad-developer.my.id/elektro/daftar-dosen" target="_blank" rel="noopener" style="color:var(--accent);">Sistem Informasi Jurusan (SIATEK)</a>.</p>
        </div>
        <div class="dosen-grid" id="dosenGrid">
            <div class="dosen-card" style="grid-column: 1 / -1; padding: 40px; color: var(--text-muted); text-align: center;">Memuat data tenaga pendidik...</div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

<script>
    const API = 'https://temp.ikad-developer.my.id/elektro';

    // ---- TENAGA PENDIDIK ----
    (function() {
        const grid = document.getElementById('dosenGrid');
        const countEl = document.getElementById('dosenCount');
        if (!grid) return;
        fetch(API + '/daftar-dosen')
            .then(r => r.json())
            .then(data => {
                if (!Array.isArray(data) || !data.length) return;
                if (countEl) countEl.textContent = data.length;
                const cards = data.map(p => {
                    const nama = (p.nama || '').trim();
                    const parts = nama.split(/[\s,]+/).filter(s => s && !/^[A-Z]\.?$|ST|MT|S\.Pd|M\.Eng|S\.Kom|M\.Kom|S\.Si|M\.Si|Ph\.D|CDSEA|ASEAN|IPU|Eng/i.test(s));
                    const initials = (parts[0] ? parts[0][0] : '') + (parts[1] ? parts[1][0] : '');
                    const fbText = initials.toUpperCase() || '—';
                    const foto = p.profil ? `<img class="dosen-foto" src="${p.profil}" alt="${nama}" loading="lazy" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">` : '';
                    const fb = `<div class="dosen-foto-fallback">${fbText}</div>`;
                    const scholar = p.scholar ? `<a href="${p.scholar}" target="_blank" rel="noopener" class="dosen-scholar" title="Google Scholar" aria-label="Google Scholar"><svg viewBox="0 0 24 24" width="14" height="14" fill="currentColor"><path d="M5.242 13.769L0 9.5 12 0l12 9.5-5.242 4.269C17.548 11.249 14.978 9.5 12 9.5c-2.977 0-5.548 1.748-6.758 4.269zM12 10a7 7 0 1 0 0 14 7 7 0 0 0 0-14z"/></svg></a>` : '';
                    return `
                        <div class="dosen-card">
                            <div class="dosen-foto-wrap">
                                ${foto}
                                ${fb}
                            </div>
                            <div class="dosen-body">
                                <div class="dosen-nama">${nama}</div>
                                ${p['bidang keahlian'] ? `<div class="dosen-bidang">${p['bidang keahlian']}</div>` : ''}
                                ${scholar}
                            </div>
                        </div>
                    `;
                }).join('');
                grid.innerHTML = cards;
            })
            .catch(() => {
                grid.innerHTML = '<div class="dosen-card" style="grid-column: 1 / -1; padding:32px;color:#c00;">Gagal memuat data tenaga pendidik.</div>';
            });
    })();
</script>
