<?php
// index.php - Halaman Beranda Jurusan Teknik Elektro dan Komputer
$pageTitle = "Beranda - Jurusan Teknik Elektro dan Komputer";
include 'template/header.php';
?>

<!-- HERO (REVISI: hapus kotak virtual lab & program studi dari kanan) -->
<section class="hero">
    <div class="container">
        <div class="hero-grid">
            <div>
                <div class="hero-eyebrow">Jurusan Teknik Elektro &amp; Komputer</div>
                <h1 class="hero-title">Membangun <em>Insan Teknik</em> Yang Berdaya Saing Global</h1>
                <p class="hero-lead">Program studi sarjana yang mengintegrasikan pendidikan, penelitian, dan pengabdian di bidang elektro dan komputer — untuk kawasan Indonesia Timur.</p>
                <div class="hero-cta">
                    <a href="profil.php" class="btn btn-primary">Tentang Jurusan</a>
                    <a href="prodi.html" class="btn btn-outline">Program Studi</a>
                </div>
            </div>
            <div class="hero-stage">
                <div class="hero-frame" id="heroFrame">
                    <!-- slides injected by JS -->
                </div>
                <div class="hero-nav">
                    <button id="heroPrev" aria-label="Sebelumnya">&#10094;</button>
                    <button id="heroNext" aria-label="Berikutnya">&#10095;</button>
                </div>
                <div class="hero-dots" id="heroDots"></div>
            </div>
        </div>
        <div class="hero-stats" id="heroStats">
            <div class="hero-stat"><div class="hero-stat-num">—</div><div class="hero-stat-lbl">Memuat...</div></div>
        </div>
    </div>
</section>

<!-- PRODI (REVISI: TAMBAH VISI) -->
<section class="prodi">
    <div class="container">
        <div class="section-head">
            <div class="desc">
                <div class="section-eyebrow">Program Studi</div>
                <h2 class="section-title">Program Studi Sarjana</h2>
                <p class="section-desc">Kurikulum berbasis OBE dan KKNI, dengan dosen berpengalaman dan fasilitas laboratorium yang lengkap.</p>
            </div>
        </div>
        <div class="prodi-list" id="prodiList">
            <div class="prodi-item"><div class="prodi-num">—</div><h3>Memuat data program studi...</h3></div>
        </div>
    </div>
</section>

<!-- BERITA (REVISI: GAMBAR DI SIDE UPDATE TERKINI) -->
<section class="berita">
    <div class="container">
        <div class="section-head">
            <div class="desc">
                <div class="section-eyebrow">Berita &amp; Informasi</div>
                <h2 class="section-title">Kabar Jurusan</h2>
                <p class="section-desc">Update kegiatan, prestasi, dan pengumuman terbaru dari Jurusan Teknik Elektro dan Komputer.</p>
            </div>
        </div>
        <div class="berita-grid">
            <article class="berita-main" id="beritaMain">
                <div class="berita-main-img">
                    <img src="" alt="Berita utama" id="beritaMainImg">
                </div>
                <div class="berita-main-body">
                    <span class="berita-main-tag">Berita Utama</span>
                    <div class="berita-meta">Memuat...</div>
                    <h2>Sedang mengambil data berita utama...</h2>
                    <p>Silakan cek jaringan Anda.</p>
                    <a href="berita.html" class="berita-main-link">Baca selengkapnya &rarr;</a>
                </div>
            </article>
            <div class="berita-side">
                <div class="berita-side-head">
                    <h3>Update Terkini</h3>
                    <span class="sub" id="beritaCount">—</span>
                </div>
                <div class="berita-side-list" id="beritaSide">
                    <div class="berita-side-item">
                        <div class="berita-side-img" style="background:var(--soft);"></div>
                        <div>
                            <div class="date">Memuat...</div>
                            <h4>Sedang mengambil data berita...</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- LABORATORIUM (REVISI: GAMBAR DARI WEB ASLI, KONEKTOR ANTAR LAB) -->
<section class="lab">
    <div class="container">
        <div class="section-head">
            <div class="desc">
                <div class="section-eyebrow">Fasilitas</div>
                <h2 class="section-title">Laboratorium &amp; Ruang Praktikum</h2>
                <p class="section-desc">Enam laboratorium dengan peralatan terapan untuk mendukung kegiatan praktikum, penelitian, dan pengabdian.</p>
            </div>
        </div>
        <div class="lab-grid">
            <div class="lab-item">
                <div class="lab-img"><img src="assets/lab-tenaga-listrik.jpg" alt="Laboratorium Dasar Teknik Tenaga Listrik"></div>
                <div class="lab-body">
                    <div class="lab-code">LAB / 01</div>
                    <h3>Dasar Teknik Tenaga Listrik</h3>
                    <p>Praktikum dasar kelistrikan, pengukuran, dan mesin listrik.</p>
                </div>
            </div>
            <div class="lab-item">
                <div class="lab-img"><img src="assets/lab-elektronika.jpg" alt="Laboratorium Elektronika"></div>
                <div class="lab-body">
                    <div class="lab-code">LAB / 02</div>
                    <h3>Elektronika</h3>
                    <p>Rangkaian analog, digital, mikroprosesor, dan sistem tertanam.</p>
                </div>
            </div>
            <div class="lab-item">
                <div class="lab-img"><img src="assets/lab-kontrol.jpg" alt="Laboratorium Sistem Kontrol"></div>
                <div class="lab-body">
                    <div class="lab-code">LAB / 03</div>
                    <h3>Sistem Kontrol</h3>
                    <p>Kendali otomatis, PLC, dan instrumentasi industri.</p>
                </div>
            </div>
            <div class="lab-item">
                <div class="lab-img"><img src="assets/lab-komputer.jpg" alt="Laboratorium Komputer"></div>
                <div class="lab-body">
                    <div class="lab-code">LAB / 04</div>
                    <h3>Komputer</h3>
                    <p>Pemrograman, jaringan, basisdata, dan kecerdasan buatan.</p>
                </div>
            </div>
            <div class="lab-item">
                <div class="lab-img"><img src="assets/lab-bahasa.jpg" alt="Laboratorium Bahasa"></div>
                <div class="lab-body">
                    <div class="lab-code">LAB / 05</div>
                    <h3>Bahasa</h3>
                    <p>Pengembangan kemampuan bahasa Inggris dan komunikasi teknis.</p>
                </div>
            </div>
            <div class="lab-item">
                <div class="lab-img" style="background:linear-gradient(135deg,var(--navy) 0%, var(--navy-deep) 100%); display:flex;align-items:center;justify-content:center;color:var(--accent);font-family:'Source Serif 4', serif;font-size:14px;font-weight:600;letter-spacing:.1em;">FASILITAS</div>
                <div class="lab-body">
                    <div class="lab-code">FASILITAS / 06</div>
                    <h3>Ruang Baca &amp; Diskusi</h3>
                    <p>Ruang bersama untuk diskusi, belajar mandiri, dan konsultasi akademik mahasiswa.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include "template/footer.php"; ?>
