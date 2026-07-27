<?php
// template/header.php
// Include di atas setiap halaman PHP

// Deteksi halaman aktif otomatis dari PHP_SELF.
// Strip .php agar aktif baik diakses via /beranda maupun /beranda.php.
// Juga bisa di-override via $currentPage = 'xxx' di halaman pemanggil.
$page = basename($_SERVER['PHP_SELF']);
if (substr($page, -4) === '.php') $page = substr($page, 0, -4);

// /beranda -> index.php: paksa currentPage='beranda' agar menu Beranda tetap aktif.
$reqUri = isset($_SERVER['REQUEST_URI']) ? parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) : '';
if ($page === 'index' || $reqUri === '/beranda' || $reqUri === '/beranda/') {
    $page = 'beranda';
}

$currentPage = isset($currentPage) ? $currentPage : $page;
$pageTitle = isset($pageTitle) ? $pageTitle : 'Jurusan Teknik Elektro dan Komputer - Universitas Negeri Gorontalo';

// Helper kecil untuk menandai <li> aktif pada menu
if (!function_exists('isActive')) {
    function isActive($key) {
        global $currentPage;
        // Halaman 'dosen' juga membuat menu 'profil' aktif
        if ($key === 'profil' && $currentPage === 'dosen') return ' class="active"';
        return $currentPage === $key ? ' class="active"' : '';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="icon" href="assets/logo.jpg" type="image/jpeg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Serif+4:opsz,wght@8..60,400;8..60,600;8..60,700;8..60,800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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
        .nav-menu > li > a.dropdown-trigger::after { content: "▾"; margin-left: 6px; font-size: 10px; opacity: 0.6; }
        .nav-menu > li:hover > a.dropdown-trigger::after, .nav-menu > li.active > a.dropdown-trigger::after { opacity: 1; }
        .dropdown { position: absolute; top: 100%; left: 0; background: #fff; border: 1px solid var(--border); border-top: 3px solid var(--accent); min-width: 240px; padding: 8px 0; opacity: 0; visibility: hidden; transform: translateY(8px); transition: all .18s; z-index: 99; }
        .nav-menu > li:hover .dropdown { opacity: 1; visibility: visible; transform: translateY(0); }
        .dropdown a { display: block; padding: 9px 18px; font-size: 13.5px; color: var(--text); }
        .dropdown a:hover { background: var(--soft); color: var(--accent-dark); }
        .dd-sep { height: 1px; background: var(--border); margin: 6px 0; }
        .dd-label { display: block; padding: 8px 18px 4px; font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: .08em; }
        .dd-group { padding: 6px 0; }
        .dd-header { display: block; padding: 6px 18px 4px; font-size: 11.5px; font-weight: 700; color: var(--navy); text-transform: uppercase; letter-spacing: .06em; }
        .dd-group a { padding-left: 18px; padding-right: 18px; }
        /* Dropdown khusus Kurikulum (lebih lebar karena isi nested) */
        .nav-menu > li:has(.dd-group) .dropdown { min-width: 320px; }

        /* ============ HERO SECTION (REVISI) ============ */
        .hero { background: var(--soft); padding: 56px 0 0; border-bottom: 1px solid var(--border); }
        .hero-grid { display: grid; grid-template-columns: 1.05fr 1fr; gap: 64px; align-items: start; margin-bottom: 48px; }

        .hero-eyebrow { font-size: 12px; font-weight: 600; letter-spacing: .15em; color: var(--accent-dark); text-transform: uppercase; display: flex; align-items: center; gap: 12px; margin-bottom: 18px; }
        .hero-eyebrow::before { content: ""; width: 32px; height: 2px; background: var(--accent); }
        .hero-title { font-family: 'Source Serif 4', serif; font-size: 50px; font-weight: 700; color: var(--navy); line-height: 1.1; letter-spacing: -1.5px; margin-bottom: 22px; }
        .hero-title em { font-style: italic; color: var(--accent-dark); }
        .hero-lead { font-size: 16.5px; color: var(--text-muted); max-width: 520px; margin-bottom: 28px; }

        .hero-cta { display: flex; gap: 12px; margin-bottom: 36px; }
        .btn { display: inline-flex; align-items: center; padding: 12px 22px; font-size: 14px; font-weight: 600; border: 1px solid; cursor: pointer; }
        .btn-primary { background: var(--navy); color: #fff; border-color: var(--navy); }
        .btn-primary:hover { background: var(--navy-deep); }
        .btn-outline { background: transparent; color: var(--navy); border-color: var(--navy); }
        .btn-outline:hover { background: var(--navy); color: #fff; }

        .hero-stats { display: grid; grid-template-columns: repeat(4, 1fr); border-top: 1px solid var(--border); }
        .hero-stat { padding: 22px 0; border-right: 1px solid var(--border); }
        .hero-stat:last-child { border-right: 0; padding-right: 0; }
        .hero-stat:not(:first-child) { padding-left: 22px; }
        .hero-stat-num { font-family: 'Source Serif 4', serif; font-size: 30px; font-weight: 700; color: var(--navy); line-height: 1; }
        .hero-stat-lbl { font-size: 12px; color: var(--text-muted); text-transform: uppercase; letter-spacing: .06em; margin-top: 6px; }

        /* HERO IMAGE STAGE (KOTAK FOTO) */
        .hero-stage { position: relative; }
        .hero-frame { position: relative; height: 480px; background: var(--navy); overflow: hidden; }
        .hero-slide { position: absolute; inset: 0; opacity: 0; transition: opacity .8s; }
        .hero-slide.active { opacity: 1; }
        .hero-slide img { width: 100%; height: 100%; object-fit: cover; }
        .hero-slide::after { content: ""; position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,27,61,0.85) 0%, rgba(0,27,61,0.3) 50%, transparent 100%); }
        .hero-caption { position: absolute; left: 0; right: 0; bottom: 0; padding: 24px 28px; color: #fff; z-index: 2; }
        .hero-caption-tag { display: inline-block; background: var(--accent); color: var(--navy-deep); font-size: 10.5px; font-weight: 700; letter-spacing: .12em; padding: 4px 10px; text-transform: uppercase; margin-bottom: 10px; }
        .hero-caption-text { font-family: 'Source Serif 4', serif; font-size: 20px; line-height: 1.3; font-weight: 600; max-width: 90%; }
        .hero-nav { position: absolute; top: 50%; transform: translateY(-50%); width: 100%; display: flex; justify-content: space-between; padding: 0 14px; z-index: 3; }
        .hero-nav button { width: 38px; height: 38px; background: rgba(255,255,255,0.92); border: 0; font-size: 16px; cursor: pointer; color: var(--navy); font-weight: 700; }
        .hero-nav button:hover { background: var(--accent); }
        .hero-dots { position: absolute; bottom: 14px; right: 18px; display: flex; gap: 6px; z-index: 3; }
        .hero-dots .dot { width: 22px; height: 3px; background: rgba(255,255,255,0.5); cursor: pointer; }
        .hero-dots .dot.on { background: var(--accent); }

        /* ============ SECTION DEFAULTS ============ */
        section { padding: 80px 0; }
        .section-eyebrow { font-size: 12px; font-weight: 600; letter-spacing: .15em; color: var(--accent-dark); text-transform: uppercase; margin-bottom: 12px; display: flex; align-items: center; gap: 12px; }
        .section-eyebrow::before { content: ""; width: 24px; height: 2px; background: var(--accent); }
        .section-title { font-family: 'Source Serif 4', serif; font-size: 36px; font-weight: 700; color: var(--navy); line-height: 1.2; margin-bottom: 14px; }
        .section-desc { font-size: 15.5px; color: var(--text-muted); max-width: 720px; }
        .section-head { display: flex; justify-content: space-between; align-items: flex-end; gap: 32px; margin-bottom: 48px; flex-wrap: wrap; }
        .section-head .desc { flex: 1; min-width: 300px; }

        /* ============ PRODI SECTION ============ */
        .prodi { background: var(--bg); }
        .prodi-list { display: grid; grid-template-columns: repeat(3, 1fr); gap: 0; border-top: 2px solid var(--navy); border-bottom: 2px solid var(--navy); }
        .prodi-item { padding: 36px 32px 32px; border-right: 1px solid var(--border); position: relative; }
        .prodi-item:last-child { border-right: 0; }
        .prodi-num { font-family: 'Source Serif 4', serif; font-size: 36px; font-weight: 700; color: var(--accent); line-height: 1; margin-bottom: 12px; }
        .prodi-strata { font-size: 11px; font-weight: 600; color: var(--text-muted); letter-spacing: .1em; text-transform: uppercase; margin-bottom: 6px; }
        .prodi-item h3 { font-family: 'Source Serif 4', serif; font-size: 22px; font-weight: 700; color: var(--navy); line-height: 1.2; margin-bottom: 14px; }
        .prodi-visi { font-size: 13.5px; line-height: 1.55; color: var(--text); padding: 14px 0; border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); margin-bottom: 14px; font-style: italic; }
        .prodi-visi::before { content: "Visi: "; font-style: normal; font-weight: 600; color: var(--accent-dark); font-size: 11px; letter-spacing: .08em; text-transform: uppercase; display: block; margin-bottom: 4px; }
        .prodi-kaprodi { font-size: 12.5px; color: var(--text-muted); }
        .prodi-kaprodi strong { display: block; color: var(--navy); font-size: 13.5px; margin-bottom: 2px; }

        /* ============ BERITA SECTION (REVISI TOTAL) ============ */
        .berita { background: var(--soft); }
        .berita-grid { display: grid; grid-template-columns: 1.1fr 1fr; gap: 40px; align-items: start; }
        .berita-main { background: #fff; border: 1px solid var(--border); }
        .berita-main-img { aspect-ratio: 16/10; overflow: hidden; background: var(--soft); }
        .berita-main-img img { width: 100%; height: 100%; object-fit: cover; }
        .berita-main-body { padding: 28px 32px 32px; }
        .berita-main-tag { display: inline-block; background: var(--navy); color: var(--accent); font-size: 10.5px; font-weight: 700; letter-spacing: .12em; padding: 4px 10px; text-transform: uppercase; margin-bottom: 14px; }
        .berita-meta { font-size: 12px; color: var(--text-muted); margin-bottom: 10px; text-transform: uppercase; letter-spacing: .06em; }
        .berita-main h2 { font-family: 'Source Serif 4', serif; font-size: 28px; line-height: 1.25; color: var(--navy); margin-bottom: 14px; font-weight: 700; }
        .berita-main p { font-size: 14.5px; color: var(--text-muted); }
        .berita-main-link { display: inline-block; margin-top: 18px; font-size: 13px; font-weight: 600; color: var(--accent-dark); border-bottom: 2px solid var(--accent); padding-bottom: 2px; }

        /* SIDE: UPDATE TERKINI (LAYOUT BENER) */
        .berita-side { background: #fff; border: 1px solid var(--border); }
        .berita-side-head { padding: 18px 24px; border-bottom: 2px solid var(--navy); display: flex; align-items: center; justify-content: space-between; }
        .berita-side-head h3 { font-family: 'Source Serif 4', serif; font-size: 20px; color: var(--navy); }
        .berita-side-head .sub { font-size: 11.5px; color: var(--accent-dark); font-weight: 600; letter-spacing: .08em; text-transform: uppercase; }
        .berita-side-list { padding: 0; }
        .berita-side-item { display: grid; grid-template-columns: 96px 1fr; gap: 18px; padding: 18px 24px; border-bottom: 1px solid var(--border); align-items: start; transition: background .15s; }
        .berita-side-item:last-child { border-bottom: 0; }
        .berita-side-item:hover { background: var(--soft); }
        .berita-side-img { aspect-ratio: 1; background: var(--soft); overflow: hidden; flex-shrink: 0; }
        .berita-side-img img { width: 100%; height: 100%; object-fit: cover; }
        .berita-side-item .date { font-size: 11px; color: var(--accent-dark); font-weight: 600; letter-spacing: .08em; text-transform: uppercase; margin-bottom: 4px; }
        .berita-side-item h4 { font-family: 'Source Serif 4', serif; font-size: 15px; line-height: 1.35; color: var(--text); font-weight: 600; }
        .berita-side-item:hover h4 { color: var(--navy); }

        /* ============ LABORATORIUM SECTION (REVISI: GAMBAR + KONEKTOR) ============ */
        .lab { background: var(--bg); }
        .lab-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 0; border-top: 2px solid var(--navy); border-bottom: 2px solid var(--navy); }
        .lab-item { padding: 0; border-right: 1px solid var(--border); border-bottom: 1px solid var(--border); position: relative; }
        .lab-item:nth-child(3n) { border-right: 0; }
        .lab-item:nth-last-child(-n+3) { border-bottom: 0; }
        .lab-img { aspect-ratio: 4/3; overflow: hidden; background: var(--soft); }
        .lab-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
        .lab-item:hover .lab-img img { transform: scale(1.05); }
        .lab-body { padding: 18px 22px 22px; }
        .lab-code { font-family: 'Source Serif 4', serif; font-size: 11px; font-weight: 700; color: var(--accent-dark); letter-spacing: .15em; }
        .lab-body h3 { font-family: 'Source Serif 4', serif; font-size: 17px; color: var(--navy); margin: 4px 0 6px; font-weight: 700; }
        .lab-body p { font-size: 12.5px; color: var(--text-muted); line-height: 1.5; }

        /* ============ FOOTER ============ */
        footer { background: var(--navy-deep); color: rgba(255,255,255,0.75); padding: 56px 0 28px; font-size: 13.5px; }
        footer h5 { font-family: 'Source Serif 4', serif; font-size: 15px; color: #fff; margin-bottom: 16px; }
        footer a { color: rgba(255,255,255,0.75); }
        footer a:hover { color: var(--accent); }
        .footer-grid { display: grid; grid-template-columns: 1.4fr 1fr 1fr 1fr; gap: 48px; margin-bottom: 40px; }
        .footer-bot { border-top: 1px solid rgba(255,255,255,0.12); padding-top: 22px; display: flex; justify-content: space-between; font-size: 12px; color: rgba(255,255,255,0.55); }

        @media (max-width: 900px) {
            .hero-grid { grid-template-columns: 1fr; }
            .hero-title { font-size: 36px; }
            .hero-stats { grid-template-columns: repeat(2, 1fr); }
            .hero-stat { border-bottom: 1px solid var(--border); }
            .berita-grid { grid-template-columns: 1fr; }
            .prodi-list, .lab-grid { grid-template-columns: 1fr; }
            .prodi-item, .lab-item { border-right: 0; border-bottom: 1px solid var(--border); }
            .footer-grid { grid-template-columns: 1fr 1fr; }
            .section-title { font-size: 28px; }
        }
    
        /* ============ HAMBURGER (mobile) ============ */
        .hamburger { display: none; background: none; border: 0; padding: 8px; cursor: pointer; color: var(--navy); }
        .hamburger svg { display: block; }
        body.menu-open { overflow: hidden; }
        .backdrop { display: none; position: fixed; inset: 0; background: rgba(15, 30, 71, 0.4); z-index: 99; }
        body.menu-open .backdrop { display: block; }

        /* ============ RESPONSIVE ============ */
        @media (max-width: 1100px) {
            .container { padding: 0 24px; }
            .header .container { height: 76px; }
            .brand-text h1 { font-size: 17px; }
            .brand-text span { font-size: 11.5px; }
            .nav-menu > li > a { padding: 10px 10px; font-size: 13.5px; }
            .hero-title { font-size: 38px; }
            .section-title { font-size: 30px; }
        }
        @media (max-width: 1100px) {
            .hamburger { display: flex; align-items: center; justify-content: center; margin-left: auto; }
            .header .container { height: 70px; }
            .brand-text h1 { font-size: 15.5px; }
            .brand-text span { display: none; }
            .brand-logo { width: 48px; height: 48px; }
            .nav-menu {
                position: fixed;
                top: 0; right: 0;
                width: min(340px, 86vw);
                height: 100vh;
                background: #fff;
                flex-direction: column;
                align-items: stretch;
                padding: 80px 0 24px;
                margin: 0;
                gap: 0;
                box-shadow: -2px 0 16px rgba(15, 30, 71, 0.10);
                transform: translateX(100%);
                transition: transform .25s ease;
                z-index: 100;
                overflow-y: auto;
            }
            body.menu-open .nav-menu { transform: translateX(0); }
            .nav-menu > li { width: 100%; }
            .nav-menu > li > a {
                padding: 14px 22px;
                font-size: 15px;
                border-bottom: 1px solid var(--border);
            }
            .nav-menu > li.active > a {
                color: var(--accent-dark);
                background: var(--soft);
                border-left: 3px solid var(--accent);
                padding-left: 19px;
            }
            .dropdown {
                position: static;
                opacity: 1;
                visibility: visible;
                transform: none;
                border: 0;
                border-top: 0;
                min-width: 0;
                width: 100%;
                background: var(--soft);
                padding: 0;
                max-height: 0;
                overflow: hidden;
                transition: max-height .25s ease;
            }
            .nav-menu > li.is-open .dropdown { max-height: 800px; }
            .dropdown a { padding: 11px 22px 11px 32px; font-size: 14px; border-bottom: 1px solid #eee; }
            .dd-sep { display: none; }
            .dd-header { padding: 10px 22px 4px 32px; font-size: 11px; }
            .dd-group a { padding-left: 32px; padding-right: 22px; }
            .nav-menu > li:has(.dd-group) .dropdown { min-width: 0; }
            .hero { padding: 40px 0 0; }
            .hero-grid { grid-template-columns: 1fr; gap: 32px; }
            .hero-title { font-size: 30px; }
            .hero-stats { grid-template-columns: repeat(2, 1fr); }
            .hero-stat { border-bottom: 1px solid var(--border); }
            .section-title { font-size: 26px; }
            .berita-grid { grid-template-columns: 1fr; }
            .prodi-list, .lab-grid { grid-template-columns: 1fr; }
            .prodi-item, .lab-item { border-right: 0; border-bottom: 1px solid var(--border); }
            .footer-grid { grid-template-columns: 1fr; gap: 28px; }
            .page-banner .container { flex-direction: column; align-items: flex-start; }
            .page-banner-meta { text-align: left; }
        }
        @media (max-width: 640px) {
            .container { padding: 0 20px; }
            .utility-bar { font-size: 11.5px; padding: 9px 0; }
            .utility-bar .container > div:last-child a { margin-left: 12px; }
            .utility-bar .container > div:last-child { display: none; }
            .hero-title { font-size: 26px; }
            .hero-lead { font-size: 15px; }
            .hero-cta { flex-direction: column; }
            .hero-cta .btn { width: 100%; }
            .section-head-split { flex-direction: column; align-items: flex-start; }
            .section-head-split .section-head-right { text-align: left; }
            .pimpinan-grid { grid-template-columns: repeat(2, 1fr); gap: 14px; }
            .pimpinan-card { padding: 18px 12px; }
            .pimpinan-foto-wrap { width: 80px; height: 80px; }
            .pimpinan-nama { font-size: 14px; }
            .dosen-grid { grid-template-columns: repeat(2, 1fr); gap: 16px; }
            .dosen-card { padding: 0; border-radius: 8px; }
            .dosen-foto-wrap { aspect-ratio: 3 / 4; }
            .dosen-body { padding: 16px 18px 18px; }
            .dosen-nama { font-size: 15px; }
            .footer-bot { flex-direction: column; gap: 8px; text-align: center; }
        }
        @media (max-width: 420px) {
            .brand-text h1 { font-size: 14px; }
            .pimpinan-grid { grid-template-columns: 1fr; }
            .dosen-grid { grid-template-columns: 1fr; gap: 14px; }
        }
    </style>
    <?php if (!empty($pageCss) && is_array($pageCss)): foreach ($pageCss as $css): ?>
    <link rel="stylesheet" href="<?php echo htmlspecialchars($css); ?>">
    <?php endforeach; endif; ?>
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
                <li<?php echo isActive('beranda'); ?>><a href="beranda">Beranda</a></li>
                <li<?php echo isActive('profil'); ?>>
                    <a href="#" class="dropdown-trigger">Profil</a>
                    <div class="dropdown">
                        <a href="profil">Tentang Jurusan</a>
                        <a href="dosen">Tenaga Pendidik</a>
                    </div>
                </li>
                <li<?php echo isActive('kurikulum'); ?>>
                    <a href="#" class="dropdown-trigger">Kurikulum</a>
                    <div class="dropdown">
                        <div class="dd-group">
                            <div class="dd-header">S1 Pendidikan Vokasional Rekayasa Elektro</div>
                            <a href="kurikulum-obe-pvre">Kurikulum OBE 2025</a>
                        </div>
                        <div class="dd-sep"></div>
                        <div class="dd-group">
                            <div class="dd-header">S1 Teknik Elektro</div>
                            <a href="kurikulum-obe-teknik-elektro">Kurikulum OBE 2025</a>
                            <a href="kurikulum-kkni">Kurikulum KKNI 2017</a>
                        </div>
                        <div class="dd-sep"></div>
                        <div class="dd-group">
                            <div class="dd-header">S1 Teknik Komputer</div>
                            <a href="kurikulum-obe-teknik-komputer">Kurikulum OBE 2025</a>
                        </div>
                    </div>
                </li>
                <li<?php echo isActive('akademik'); ?>>
                    <a href="#" class="dropdown-trigger">Akademik</a>
                    <div class="dropdown">
                        <a href="panduan-sop">Panduan dan SOP</a>
                        <a href="dokumen-penjamin-mutu">Dokumen Penjamin Mutu</a>
                        <a href="dokumen-kurikulum">Dokumen Kurikulum</a>
                        <a href="dokumen-akreditas">Dokumen Akreditasi</a>
                        <a href="laporan-kinerja">Laporan Kinerja</a>
                    </div>
                </li>
                <li><a href="#">Mahasiswa</a></li>
                <li<?php echo isActive('publikasi'); ?>><a href="publikasi">Publikasi</a></li>
                <li><a href="#">Fasilitas</a></li>
                <li><a href="#">Alumni</a></li>
                <li><a href="#">Berita</a></li>
            </ul>
        </nav>
        <button class="hamburger" id="hamburgerBtn" aria-label="Buka menu" aria-expanded="false" aria-controls="primary-nav">
            <svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                <line x1="4" y1="7" x2="20" y2="7"/>
                <line x1="4" y1="12" x2="20" y2="12"/>
                <line x1="4" y1="17" x2="20" y2="17"/>
            </svg>
        </button>
        <div class="backdrop" id="menuBackdrop"></div>
    </div>
</header>