<?php
// fasilitas.php — Halaman Fasilitas Jurusan Teknik Elektro dan Komputer
// Konten paragraf deskripsi disalin dari sumber:
// https://elektro.ft.ung.ac.id/fasilitas
// Daftar kegiatan diturunkan dari paragraf sumber (bukan poin verbatim).

$pageTitle = 'Fasilitas — Jurusan Teknik Elektro dan Komputer';
$currentPage = 'fasilitas';
$pageCss = ['assets/fasilitas.css'];
include 'template/header.php';

// Data setiap fasilitas: judul, gambar, kategori (LAB/UNIT), kode urut,
// paragraf deskripsi (salinan dari sumber), dan daftar kegiatan (turunan dari sumber).
$facilities = [
    [
        'no'        => 1,
        'name'      => 'Laboratorium Tegangan Tinggi',
        'image'     => 'assets/resmi-labtt.png',
        'imageAlt'  => 'Laboratorium Tegangan Tinggi',
        'category'  => 'LAB',
        'featured'  => true,
        'desc'      => 'Kegiatan-kegiatan yang diselenggarakan oleh laboratorium ini meliputi pengujian sistem isolasi tegangan tinggi, pengujian peralatan tegangan tinggi, baik untuk pelaksanaan praktika maupun penelitian dan pengabdian pada masyarakat.',
        'activities'=> [
            'Pengujian sistem isolasi tegangan tinggi',
            'Pengujian peralatan tegangan tinggi',
            'Pelaksanaan praktika',
            'Penelitian & pengabdian kepada masyarakat',
        ],
    ],
    [
        'no'        => 2,
        'name'      => 'Laboratorium Elektronika dan Telekomunikasi',
        'image'     => 'assets/resmi-lab-elektronika.jpg',
        'imageAlt'  => 'Laboratorium Elektronika dan Telekomunikasi',
        'category'  => 'LAB',
        'featured'  => false,
        'desc'      => 'Laboratorium elektronika dan telekomunikasi adalah fasilitas pendidikan yang dirancang untuk memfasilitasi para mahasiswa dalam mempelajari konsep-konsep dasar dan praktik-praktik yang berkaitan dengan bidang elektronika dan telekomunikasi. Fungsi utama laboratorium ini adalah untuk memberikan pengalaman langsung kepada mahasiswa dalam merancang, menguji, dan menganalisis sirkuit elektronik dan peralatan telekomunikasi.',
        'activities'=> [
            'Mempelajari konsep dasar elektronika & telekomunikasi',
            'Merancang sirkuit elektronik',
            'Menguji sirkuit elektronik',
            'Menganalisis sirkuit elektronik',
            'Menganalisis peralatan telekomunikasi',
        ],
    ],
    [
        'no'        => 3,
        'name'      => 'Laboratorium Dasar Tenaga Listrik',
        'image'     => 'assets/resmi-lab-dasar-tenaga-listrik.jpeg',
        'imageAlt'  => 'Laboratorium Dasar Tenaga Listrik',
        'category'  => 'LAB',
        'featured'  => false,
        'desc'      => 'Laboratorium ini dilengkapi dengan berbagai peralatan dan instrumen yang digunakan untuk mengukur, mengontrol, dan memanipulasi energi listrik. Di laboratorium ini, mahasiswa dan peneliti dapat melakukan berbagai eksperimen, seperti menguji efisiensi transformator, mengukur daya listrik, dan merancang sistem tenaga listrik.',
        'activities'=> [
            'Mengukur, mengontrol & memanipulasi energi listrik',
            'Menguji efisiensi transformator',
            'Mengukur daya listrik',
            'Merancang sistem tenaga listrik',
        ],
    ],
    [
        'no'        => 4,
        'name'      => 'Perpustakaan Jurusan',
        'image'     => 'assets/resmi-perpus.png',
        'imageAlt'  => 'Perpustakaan Jurusan',
        'category'  => 'UNIT',
        'featured'  => false,
        'desc'      => 'Perpustakaan jurusan adalah fasilitas pendidikan yang dirancang untuk memfasilitasi mahasiswa dan staf pengajar dalam memperoleh sumber daya yang berkaitan dengan bidang studi tertentu. Setiap jurusan biasanya memiliki perpustakaan sendiri yang terdiri dari kumpulan buku, jurnal, artikel, dan sumber daya lainnya yang spesifik untuk bidang studi tersebut.',
        'activities'=> [
            'Koleksi buku bidang studi',
            'Koleksi jurnal',
            'Koleksi artikel',
            'Sumber daya spesifik bidang studi',
            'Memperoleh sumber daya untuk mahasiswa & staf pengajar',
        ],
    ],
    [
        'no'        => 5,
        'name'      => 'Laboratorium Teknik Kendali',
        'image'     => 'assets/resmi-lab-kontrol.jpeg',
        'imageAlt'  => 'Laboratorium Teknik Kendali',
        'category'  => 'LAB',
        'featured'  => false,
        'desc'      => 'Fasilitas pendidikan yang dirancang untuk membantu mahasiswa dan staf pengajar dalam mempelajari, menguji, dan menganalisis sistem kendali. Laboratorium ini dilengkapi dengan berbagai macam peralatan dan software yang digunakan untuk mempelajari konsep-konsep dasar dalam pengendalian sistem, seperti transfer function, PID control, dan state space.',
        'activities'=> [
            'Mempelajari sistem kendali',
            'Menguji sistem kendali',
            'Menganalisis sistem kendali',
            'Transfer function',
            'PID control',
            'State space',
        ],
    ],
    [
        'no'        => 6,
        'name'      => 'Laboratorium Komputer',
        'image'     => 'assets/resmi-labkom.png',
        'imageAlt'  => 'Laboratorium Komputer',
        'category'  => 'LAB',
        'featured'  => false,
        'desc'      => 'Fasilitas pendidikan yang dirancang untuk membantu mahasiswa dan staf pengajar dalam mempelajari, mengembangkan, dan menguji perangkat lunak serta perangkat keras komputer. Laboratorium ini dilengkapi dengan berbagai macam komputer, server, printer, dan perangkat lunak yang digunakan untuk memfasilitasi praktikum, proyek, dan riset di bidang teknologi informasi.',
        'activities'=> [
            'Mempelajari perangkat lunak & keras komputer',
            'Mengembangkan perangkat lunak & keras komputer',
            'Menguji perangkat lunak & keras komputer',
            'Memfasilitasi praktikum',
            'Memfasilitasi proyek',
            'Memfasilitasi riset teknologi informasi',
        ],
    ],
];

$totalFacilities = count($facilities);
?>

<!-- page banner -->
<section class="page-banner">
    <div class="container">
        <div>
            <div class="breadcrumb">
                <a href="beranda">Beranda</a> &nbsp;&rsaquo;&nbsp; Fasilitas
            </div>
            <h1>Fasilitas Jurusan</h1>
            <p class="lede">Sarana laboratorium dan unit pendukung kegiatan akademik di Jurusan Teknik Elektro dan Komputer, Universitas Negeri Gorontalo.</p>
        </div>
        <div class="page-banner-meta">
            <strong><?php echo $totalFacilities; ?></strong>
            Fasilitas Jurusan
        </div>
    </div>
</section>

<!-- ============================================
     DAFTAR FASILITAS
     Sumber: https://elektro.ft.ung.ac.id/fasilitas
     Paragraf deskripsi disalin dari sumber.
     Daftar kegiatan diturunkan dari paragraf sumber
     untuk menonjolkan lingkup kerja tiap fasilitas.
     ============================================ -->
<section class="lab" id="fasilitas">
    <div class="container">

        <!-- Section heading (pola split: eyebrow kiri, title kanan, deskripsi full-width di bawah) -->
        <div class="section-head section-head-split">
            <div class="section-head-left">
                <div class="section-eyebrow">Daftar Fasilitas</div>
            </div>
            <div class="section-head-right">
                <h2 class="section-title">Laboratorium &amp; Unit Pendukung</h2>
            </div>
        </div>
        <p class="section-desc" style="margin-top:-32px;margin-bottom:32px;max-width:760px;">
            Seluruh fasilitas aktif Jurusan Teknik Elektro dan Komputer yang digunakan untuk kegiatan praktikum, penelitian, dan pengabdian kepada masyarakat.
        </p>

        <!-- ============================================
             FEATURED CARD LIST (semua fasilitas)
             ============================================ -->
        <?php foreach ($facilities as $f): ?>
            <article class="fas-featured" id="fas-<?php echo $f['no']; ?>">
                <div class="fas-featured-media">
                    <img src="<?php echo htmlspecialchars($f['image']); ?>" alt="<?php echo htmlspecialchars($f['imageAlt']); ?>">
                    <?php if (!empty($f['featured'])): ?>
                        <span class="fas-badge fas-badge-featured">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="currentColor" aria-hidden="true"><path d="M12 2l2.39 7.36H22l-6.18 4.49L18.21 22 12 17.27 5.79 22l2.39-8.15L2 9.36h7.61z"/></svg>
                            Unggulan
                        </span>
                    <?php endif; ?>
                </div>
                <div class="fas-featured-body">
                    <div class="fas-meta">
                        <span class="fas-badge fas-badge-<?php echo strtolower($f['category']); ?>"><?php echo htmlspecialchars($f['category']); ?></span>
                        <span class="fas-code">/ <?php echo str_pad((string)$f['no'], 2, '0', STR_PAD_LEFT); ?></span>
                    </div>
                    <h3><?php echo htmlspecialchars($f['name']); ?></h3>
                    <p><?php echo htmlspecialchars($f['desc']); ?></p>

                    <?php if (!empty($f['activities'])): ?>
                        <ul class="fas-featured-list" aria-label="Ruang lingkup kegiatan">
                            <?php foreach ($f['activities'] as $a): ?>
                                <li>
                                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M20 6L9 17l-5-5"/></svg>
                                    <?php echo htmlspecialchars($a); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </article>
        <?php endforeach; ?>

    </div>
</section>

<?php include 'template/footer.php'; ?>
