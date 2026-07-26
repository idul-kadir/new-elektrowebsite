<?php
// header.php
$page = basename($_SERVER['PHP_SELF'], '.php');
$pageCss = [];
$cssFile = __DIR__ . '/assets/' . $page . '.css';
if (file_exists($cssFile)) {
    $pageCss[] = 'assets/' . $page . '.css';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jurusan Teknik Elektro dan Komputer - Universitas Negeri Gorontalo</title>
    <link rel="icon" href="assets/logo.jpg" type="image/jpeg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Source+Serif+4:ital,wght@0,400;0,600;0,700;1,600&display=swap" rel="stylesheet">
    <?php if (!empty($pageCss)): foreach ($pageCss as $item): ?>
    <link rel="stylesheet" href="<?= htmlspecialchars($item) ?>">
    <?php endforeach; endif; ?>
    <style>
:root {
            --navy: #1E3A8A;
            --navy-deep: #0F1E47;
            --navy-light: #3B82F6;
            --accent: #F97316;
            --accent-dark: #C2410C;
            --text: #1A1A1A;
            --text-muted: #555555;
            --bg: #ffffff;
            --soft: #F9FAFB;
            --border: #E5E7EB;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', -apple-system, sans-serif; color: var(--text); background: var(--bg); line-height: 1.6; -webkit-font-smoothing: antialiased; }
        a { text-decoration: none; color: inherit; }
        img { display: block; max-width: 100%; }
        .container { max-width: 1280px; margin: 0 auto; padding: 0 32px; }

        /* ============ UTILITY BAR ============ */
        .utility-bar { background: var(--navy-deep); color: rgba(255,255,255,0.85); font-size: 12.5px; padding: 11px 0; }
        .utility-bar .container { display: flex; justify-content: space-between; align-items: center; }
        .utility-bar a { color: rgba(255,255,255,0.85); margin-left: 22px; font-weight: 500; }
        .utility-bar a:hover { color: var(--accent); }

        /* ============ HEADER NAVBAR ============ */
        .header { background: var(--bg); border-bottom: 3px solid var(--accent); position: sticky; top: 0; z-index: 100; }
        .header .container { display: flex; align-items: center; justify-content: space-between; height: 88px; }
        .brand { display: flex; align-items: center; gap: 16px; }
        .brand-logo { width: 60px; height: 60px; flex-shrink: 0; }
        .brand-logo img { width: 100%; height: 100%; object-fit: contain; }
        .brand-text h1 { font-family: 'Source Serif 4', serif; font-size: 19px; font-weight: 700; color: var(--navy); line-height: 1.2; letter-spacing: -0.2px; }
        .brand-text span { font-size: 12px; color: var(--text-muted); font-weight: 500; display: block; margin-top: 3px; }

        .nav-menu { list-style: none; display: flex; gap: 4px; }
        .nav-menu > li { position: relative; }
        .nav-menu > li > a { display: block; padding: 10px 14px; font-size: 14px; font-weight: 500; color: var(--text); }
        .nav-menu > li > a:hover, .nav-menu > li:hover > a, .nav-menu > li.active > a { color: var(--accent-dark); }
        .dropdown { position: absolute; top: 100%; left: 0; background: #fff; border: 1px solid var(--border); border-top: 3px solid var(--accent); min-width: 240px; padding: 8px 0; opacity: 0; visibility: hidden; transform: translateY(8px); transition: all .18s; z-index: 99; }
        .nav-menu > li:hover .dropdown { opacity: 1; visibility: visible; transform: translateY(0); }
        .dropdown a { display: block; padding: 9px 18px; font-size: 13.5px; color: var(--text); }
        .dropdown a:hover { background: var(--soft); color: var(--accent-dark); }
        .dd-sep { height: 1px; background: var(--border); margin: 6px 12px; }
        .dd-label { display: block; padding: 8px 18px 4px; font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: .08em; }
        .dd-group { padding: 4px 0; }
        .dd-header { display: block; padding: 8px 18px 4px; font-size: 11.5px; font-weight: 700; color: var(--navy); text-transform: uppercase; letter-spacing: .06em; }
        .dd-group a { padding-left: 18px; padding-right: 18px; }
        /* Dropdown khusus Kurikulum (lebih lebar karena isi nested) */
        .nav-menu > li:has(.dd-group) .dropdown { min-width: 280px; }

        /* ============ HERO SECTION (REVISI) ============ */
    </style>
</head>
<body>
<div class="utility-bar">
    <div class="container">
        <div><i style="color:var(--accent);">●</i> &nbsp; Universitas Negeri Gorontalo</div>
        <div>
            <a href="https://www.ung.ac.id/" target="_blank">UNG</a>
            <a href="https://ft.ung.ac.id/" target="_blank">Fakultas Teknik</a>
            <a href="https://siat.ung.ac.id/" target="_blank">SIAT</a>
        </div>
    </div>
</div>

<header class="header">
    <div class="container">
        <div class="brand">
            <div class="brand-logo"><img src="assets/logo.jpg" alt="Logo Jurusan"></div>
            <div class="brand-text">
                <h1>Jurusan Teknik Elektro &amp; Komputer</h1>
                <span>Fakultas Teknik &bull; Universitas Negeri Gorontalo</span>
            </div>
        </div>
        <nav>
            <ul class="nav-menu" id="primary-nav">
                <li class="active"><a href="index.php">Beranda</a></li>
                <li>
                    <a href="profil.php">Profil</a>
                    <div class="dropdown">
                        <a href="profil.php#sejarah">Sejarah</a>
                        <a href="profil.php#visi-misi">Visi &amp; Misi</a>
                        <a href="profil.php#struktur">Struktur Organisasi</a>
                        <a href="dosen.php">Tenaga Pendidik</a>
                    </div>
                </li>
                <li>
                    <a href="kurikulum.php">Kurikulum</a>
                    <div class="dropdown">
                        <div class="dd-group">
                            <div class="dd-header">S1 Pendidikan Vokasional Rekayasa Elektro</div>
                            <a href="kurikulum.php#pv-2025">Kurikulum 2025</a>
                        </div>
                        <div class="dd-sep"></div>
                        <div class="dd-group">
                            <div class="dd-header">S1 Teknik Elektro</div>
                            <a href="kurikulum.php#te-2025">Kurikulum 2025</a>
                            <a href="kurikulum.php#te-2017">Kurikulum 2017</a>
                        </div>
                        <div class="dd-sep"></div>
                        <div class="dd-group">
                            <div class="dd-header">S1 Teknik Komputer</div>
                            <a href="kurikulum.php#tk-2025">Kurikulum 2025</a>
                        </div>
                    </div>
                </li>
                <li>
                    <a href="akademik.php">Akademik</a>
                    <div class="dropdown">
                        <a href="akademik.php#panduan-sop">Dokumen Panduan dan SOP</a>
                        <a href="akademik.php#penjamin-mutu">Dokumen Dan Penjamin Mutu</a>
                        <a href="akademik.php#dokumen-kurikulum">Dokumen Kurikulum</a>
                        <a href="akademik.php#akreditas">Dokumen Akreditas</a>
                        <a href="akademik.php#laporan-kinerja">Laporan Kinerja</a>
                    </div>
                </li>
                <li><a href="mahasiswa.php">Mahasiswa</a></li>
                <li><a href="publikasi.php">Publikasi</a></li>
                <li><a href="fasilitas.php">Fasilitas</a></li>
                <li><a href="alumni.php">Alumni</a></li>
                <li><a href="berita.php">Berita</a></li>
            </ul>
        </nav>
            <button class="hamburger" id="hamburgerBtn" aria-label="Buka menu" aria-expanded="false" aria-controls="primary-nav">
                <svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                    <line x1="4" y1="7" x2="20" y2="7"/>
                    <line x1="4" y1="12" x2="20" y2="12"/>
                    <line x1="4" y1="17" x2="20" y2="17"/>
                </svg>
            </button>
