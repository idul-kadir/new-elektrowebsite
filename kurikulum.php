<?php
// kurikulum.php — Halaman Overview / Landing Kurikulum Jurusan
$pageTitle = 'Kurikulum — Jurusan Teknik Elektro dan Komputer';
$currentPage = 'kurikulum';
$pageCss = ['assets/kurikulum.css'];
include 'template/header.php';
?>

<!-- page banner -->
<section class="page-banner">
    <div class="container">
        <div>
            <div class="breadcrumb"><a href="index.php">Beranda</a> &nbsp;&rsaquo;&nbsp; Kurikulum</div>
            <h1>Kurikulum Jurusan Teknik Elektro &amp; Komputer</h1>
            <p class="lede">Kurikulum berbasis OBE (Outcome-Based Education) untuk setiap program studi sarjana di Jurusan Teknik Elektro dan Komputer, Fakultas Teknik UNG.</p>
        </div>
        <div class="page-banner-meta">
            <strong>3</strong>
            Program Studi
        </div>
    </div>
</section>

<!-- INTRO + PENJELASAN OBE -->
<section class="prodi-section" style="padding-top:64px;">
    <div class="container">
        <div class="section-head section-head-split">
            <div class="section-head-left">
                <div class="section-eyebrow">Tentang Kurikulum</div>
            </div>
            <div class="section-head-right">
                <h2 class="section-title">Pendidikan Berbasis Capaian</h2>
            </div>
        </div>
        <p class="section-desc" style="margin-top:-32px;margin-bottom:32px;max-width:760px;">
            Jurusan Teknik Elektro dan Komputer mengelola <strong>tiga program studi sarjana</strong> dengan kurikulum yang dirancang mengikuti pendekatan OBE — pembelajaran disusun berdasarkan capaian pembelajaran lulusan (CPL), profil lulusan, dan kebutuhan pemangku kepentingan.
        </p>

        <!-- INFO RINGKAS OBE -->
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:0;border-top:2px solid var(--navy);border-bottom:2px solid var(--navy);margin-bottom:48px;">
            <div style="padding:28px 24px;border-right:1px solid var(--border);">
                <div style="font-size:11px;font-weight:700;color:var(--accent-dark);letter-spacing:.1em;text-transform:uppercase;margin-bottom:8px;">01 — CPL</div>
                <h4 style="font-family:'Source Serif 4',serif;font-size:17px;color:var(--navy);margin-bottom:6px;">Capaian Pembelajaran</h4>
                <p style="font-size:13px;color:var(--text-muted);line-height:1.55;">Standar kompetensi lulusan yang disusun mengacu pada KKNI, SN-DIKTI, dan kebutuhan industri.</p>
            </div>
            <div style="padding:28px 24px;border-right:1px solid var(--border);">
                <div style="font-size:11px;font-weight:700;color:var(--accent-dark);letter-spacing:.1em;text-transform:uppercase;margin-bottom:8px;">02 — PROFIL LULUSAN</div>
                <h4 style="font-family:'Source Serif 4',serif;font-size:17px;color:var(--navy);margin-bottom:6px;">Profil Lulusan</h4>
                <p style="font-size:13px;color:var(--text-muted);line-height:1.55;">Peran profesional yang diharapkan dapat dijalankan lulusan di dunia kerja dan masyarakat.</p>
            </div>
            <div style="padding:28px 24px;">
                <div style="font-size:11px;font-weight:700;color:var(--accent-dark);letter-spacing:.1em;text-transform:uppercase;margin-bottom:8px;">03 — SEBARAN MK</div>
                <h4 style="font-family:'Source Serif 4',serif;font-size:17px;color:var(--navy);margin-bottom:6px;">Sebaran Mata Kuliah</h4>
                <p style="font-size:13px;color:var(--text-muted);line-height:1.55;">Pengorganisasian mata kuliah per semester dengan beban SKS terstruktur dan keterkaitan antar-MK.</p>
            </div>
        </div>
    </div>
</section>

<!-- DAFTAR KURIKULUM PER PRODI -->
<section class="prodi-section" style="padding-top:0;">
    <div class="container">
        <div class="section-head section-head-split">
            <div class="section-head-left">
                <div class="section-eyebrow">Pilih Program Studi</div>
            </div>
            <div class="section-head-right">
                <h2 class="section-title">Daftar Kurikulum</h2>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:24px;margin-top:8px;">

            <!-- CARD: PV REKAYASA ELEKTRO -->
            <a href="kurikulum-pv.php" style="display:block;background:#fff;border:1px solid var(--border);border-top:4px solid var(--accent);padding:32px 28px;transition:border-color .2s, box-shadow .2s, transform .2s;text-decoration:none;color:inherit;">
                <div style="font-size:11px;font-weight:700;color:var(--accent-dark);letter-spacing:.1em;text-transform:uppercase;margin-bottom:10px;">S1 PENDIDIKAN VOKASIONAL</div>
                <h3 style="font-family:'Source Serif 4',serif;font-size:22px;color:var(--navy);margin-bottom:10px;line-height:1.25;">Rekayasa Elektro</h3>
                <p style="font-size:13.5px;color:var(--text-muted);line-height:1.6;margin-bottom:18px;">Kurikulum OBE 2025 untuk program sarjana pendidikan vokasional bidang rekayasa elektro.</p>
                <div style="display:flex;justify-content:space-between;align-items:baseline;border-top:1px solid var(--border);padding-top:14px;">
                    <span style="font-size:12px;color:var(--text-muted);text-transform:uppercase;letter-spacing:.06em;">Tahun</span>
                    <span style="font-family:'Source Serif 4',serif;font-weight:700;color:var(--navy);">2025</span>
                </div>
            </a>

            <!-- CARD: TEKNIK ELEKTRO OBE -->
            <a href="kurikulum-te.php" style="display:block;background:#fff;border:1px solid var(--border);border-top:4px solid var(--accent);padding:32px 28px;transition:border-color .2s, box-shadow .2s, transform .2s;text-decoration:none;color:inherit;">
                <div style="font-size:11px;font-weight:700;color:var(--accent-dark);letter-spacing:.1em;text-transform:uppercase;margin-bottom:10px;">S1 TEKNIK ELEKTRO</div>
                <h3 style="font-family:'Source Serif 4',serif;font-size:22px;color:var(--navy);margin-bottom:10px;line-height:1.25;">Kurikulum OBE 2025</h3>
                <p style="font-size:13.5px;color:var(--text-muted);line-height:1.6;margin-bottom:18px;">Kurikulum OBE 2025 dengan konsentrasi TTL (Tenaga Listrik) dan TET (Telekomunikasi).</p>
                <div style="display:flex;justify-content:space-between;align-items:baseline;border-top:1px solid var(--border);padding-top:14px;">
                    <span style="font-size:12px;color:var(--text-muted);text-transform:uppercase;letter-spacing:.06em;">Tahun</span>
                    <span style="font-family:'Source Serif 4',serif;font-weight:700;color:var(--navy);">2025</span>
                </div>
            </a>

            <!-- CARD: TEKNIK ELEKTRO KKNI -->
            <a href="kurikulum-kkni.php" style="display:block;background:#fff;border:1px solid var(--border);border-top:4px solid var(--navy);padding:32px 28px;transition:border-color .2s, box-shadow .2s, transform .2s;text-decoration:none;color:inherit;">
                <div style="font-size:11px;font-weight:700;color:var(--accent-dark);letter-spacing:.1em;text-transform:uppercase;margin-bottom:10px;">S1 TEKNIK ELEKTRO</div>
                <h3 style="font-family:'Source Serif 4',serif;font-size:22px;color:var(--navy);margin-bottom:10px;line-height:1.25;">Kurikulum KKNI 2017</h3>
                <p style="font-size:13.5px;color:var(--text-muted);line-height:1.6;margin-bottom:18px;">Kurikulum KKNI 2017 (arsip) dengan 4 konsentrasi: STL, STK, SET, SKI.</p>
                <div style="display:flex;justify-content:space-between;align-items:baseline;border-top:1px solid var(--border);padding-top:14px;">
                    <span style="font-size:12px;color:var(--text-muted);text-transform:uppercase;letter-spacing:.06em;">Tahun</span>
                    <span style="font-family:'Source Serif 4',serif;font-weight:700;color:var(--navy);">2017</span>
                </div>
            </a>

            <!-- CARD: TEKNIK KOMPUTER OBE -->
            <a href="kurikulum-tk.php" style="display:block;background:#fff;border:1px solid var(--border);border-top:4px solid var(--accent);padding:32px 28px;transition:border-color .2s, box-shadow .2s, transform .2s;text-decoration:none;color:inherit;">
                <div style="font-size:11px;font-weight:700;color:var(--accent-dark);letter-spacing:.1em;text-transform:uppercase;margin-bottom:10px;">S1 TEKNIK KOMPUTER</div>
                <h3 style="font-family:'Source Serif 4',serif;font-size:22px;color:var(--navy);margin-bottom:10px;line-height:1.25;">Kurikulum OBE 2025</h3>
                <p style="font-size:13.5px;color:var(--text-muted);line-height:1.6;margin-bottom:18px;">Kurikulum OBE 2025 untuk program studi sarjana teknik komputer.</p>
                <div style="display:flex;justify-content:space-between;align-items:baseline;border-top:1px solid var(--border);padding-top:14px;">
                    <span style="font-size:12px;color:var(--text-muted);text-transform:uppercase;letter-spacing:.06em;">Tahun</span>
                    <span style="font-family:'Source Serif 4',serif;font-weight:700;color:var(--navy);">2025</span>
                </div>
            </a>

        </div>
    </div>
</section>

<?php include 'template/footer.php'; ?>