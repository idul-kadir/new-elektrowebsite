# Blueprint Redesain Situs elektro.ft.ung.ac.id
## Jurusan Teknik Elektro dan Komputer — Universitas Negeri Gorontalo

---

## 1. Ringkasan Eksekutif

Situs `elektro.ft.ung.ac.id` adalah situs publik Jurusan Teknik Elektro dan Komputer, Fakultas Teknik, Universitas Negeri Gorontalo (UNG). Situs dibangun dengan template Bootstrap/Digicore. Situs saat ini mengalami masalah serius pada **routing URL** (banyak link menu tidak terhubung ke halaman yang benar), **konten outdated** (footer copyright 2022, struktur organisasi kemahasiswaan 2016), **halaman Visi & Misi 404**, serta **struktur navigasi yang membingungkan** (menu Kurikulum link-nya mengarah ke beranda). Konten akademik sangat kaya (kurikulum detail per prodi, 24+ dokumen SOP, 50+ publikasi ilmiah) namun tidak terorganisir dengan baik.

---

## 2. Audiens & Tujuan

| Segmen | Deskripsi | Tujuan |
|---|---|---|
| **Calon Mahasiswa** | Siswa SMA/SMK pencari info jurusan | Info prodi, kurikulum, cara daftar |
| **Mahasiswa Aktif** | S1 PV Rekayasa Elektro, Teknik Elektro, Teknik Komputer | Akses akademik, SOP, jadwal, berita |
| **Dosen** | ~24 dosen | Profil, publikasi, fokus riset |
| **Alumni** | Lulusan 2014–2026 | Database alumni, networking |
| **Peneliti/Eksternal** | Akademisi, mitra industri | Publikasi ilmiah, jurnal, kolaborasi |
| **Stakeholder** | PLN, FORTEI, akreditasi | Dokumen akreditasi, laporan kinerja |

---

## 3. Struktur Informasi As-Is

### 3.1 Menu Navigasi Utama

| Menu | Submenu | Link Asli | Status |
|---|---|---|---|
| **Beranda** | — | `/` atau `/beranda` | ✅ OK |
| **Profil** ▾ | Sejarah | `/sejarah` | ✅ OK (daftar ketua jurusan 2001–sekarang) |
| | Visi & Misi | `/visi-misi.php` | ❌ **404 Not Found** |
| | Struktur Organisasi | `/struktur-organisasi` | ✅ OK (7 orang + bidang keahlian) |
| | Tenaga Pendidik | `/dosen` | ✅ OK (3 halaman, ~24 dosen, JS-rendered) |
| **Kurikulum** ▾ | **S1 Pendidikan Vokasional Rekayasa Elektro** | | |
| | ↳ Kurikulum 2025 | `/` (beranda!) | ❌ **Link salah ke beranda** |
| | **S1 Teknik Elektro** | | |
| | ↳ Kurikulum 2025 (OBE) | `/kurikulum-obe-te` | ✅ OK (lengkap: visi keilmuan, CPL, profil lulusan, sebaran mata kuliah per semester) |
| | ↳ Kurikulum 2017 (KKNI) | `/kurikulum-kkni` | ✅ OK (lengkap: visi, misi, pengelola, deskripsi kurikulum, sebaran MK per semester) |
| | **S1 Teknik Komputer** | | |
| | ↳ Kurikulum 2025 (OBE) | `/kurikulum-obe-tk` | ✅ OK (lengkap: visi keilmuan, TPPS, CPL, profil lulusan, sebaran MK per semester) |
| **Akademik** ▾ | Dokumen Panduan dan SOP | `/dokumen-panduan-sop` | ✅ OK (24 file PDF) |
| | Dokumen Dan Penjamin Mutu | `/dokumen-penjamin-mutu` | ✅ OK (5 file PDF) |
| | Dokumen Kurikulum | `/dokumen-kurikulum` | ✅ OK (5 file PDF) |
| | Dokumen Akreditas | `/dokumen-akreditas` | ✅ OK (C1-C9 + Visi Misi + Unduh) |
| | Laporan Kinerja | `/laporan-kinerja` | ✅ OK (6 periode: 2019-2024, Google Drive) |
| **Mahasiswa** | — | `/mahasiswa` | ✅ OK (kegiatan, struktur org, statistik — JS-rendered, 3 halaman) |
| **Publikasi** | — | `/publikasi-ilmiah` | ✅ OK (~50 publikasi, 5 halaman — JS-rendered) |
| **Fasilitas** | — | `/fasilitas` | ✅ OK (6 lab + perpustakaan) |
| **Alumni** | — | `/data-alumni` | ✅ OK (filter tahun 2014-2026 — JS-rendered) |
| **Berita** | — | `/berita` | ✅ OK (~20+ berita, 5 halaman — JS-rendered) |

### 3.2 Halaman Kurikulum — Detail Konten

#### S1 Teknik Elektro — Kurikulum OBE (`/kurikulum-obe-te`)
- **Visi Keilmuan Program Studi**
- **Tujuan Pendidikan Program Studi (TPPS)**
- **Pengelola Program Studi** (dengan link Google Scholar)
- **Profil Lulusan** (PL-1 sampai PL-4): Perekayasa, Perencana, Analisis, Konsultan, Manager, Entrepreneur
- **Capaian Pembelajaran Lulusan** (CPL-1 sampai CPL-11)
- **Sebaran Mata Kuliah** per semester (tabel lengkap: kode MK, nama, SKS)
  - Semester 1: Fisika 1, Kimia Elektro, Agama, Bahasa Indonesia, Kalkulus 1, Probabilitas, Pemrograman Dasar, Prak Pemrograman (20 SKS)
  - Semester 2: Tata Tulis Laporan, Kalkulus 2, Fisika 2, Rangkaian Listrik 1, Ilmu Bahan Listrik, Pengukuran & Instrumentasi
  - ...dan seterusnya

#### S1 Teknik Elektro — Kurikulum KKNI (`/kurikulum-kkni`)
- **Visi & Misi** Program Studi
- **Pengelola Program Studi**: Ifan Wiranto, ST., MT. (Control Engineering & AI)
- **Deskripsi Kurikulum**: Berjalan sejak SK DIKTI No: 2363/D/T/2008, evaluasi 2011, peninjauan KKNI 2016
- **Daftar Matakuliah hasil rekognisi dan konversi MBKM**
- **Sebaran Mata Kuliah** per semester:
  - Semester 1: Fisika Listrik (4), Matematika Teknik (3), Probabilitas (3), Pemrograman Dasar (4), Agama (2), Tata Tulis (2), Kimia Elektro (3) = 21 SKS
  - Semester 2: Aljabar Linier (3), Matematika Lanjut (3), Ilmu Bahan Listrik (3), Pengukuran & Instrumentasi (4), Elektronika Dasar (4), Pancasila (2), Bahasa Indonesia (2) = 21 SKS
  - Semester 3: Rangkaian Listrik (3), Matematika Diskrit (3), Telekomunikasi Dasar (4), Isyarat & Sistem (4), Teknik Digital & Mikroprosesor (4), Kewarganegaraan (2)
- ...dan seterusnya

#### S1 Teknik Komputer — Kurikulum OBE (`/kurikulum-obe-tk`)
- **Visi Keilmuan Program Studi**
- **Tujuan Pendidikan Program Studi (TPPS)**
- **Koordinator Program Studi** (dengan link Google Scholar)
- **Profil Lulusan** (PL01-PL04): Embedded systems, sistem komputer, kepemimpinan, enterpreneur
- **Capaian Pembelajaran Lulusan** (CPL-1 sampai CPL-11)
- **Sebaran Mata Kuliah** per semester:
  - Semester 1: Agama, B. Indonesia, Fisika 1, Kalkulus 1, Dasar Pemrograman 1, Prak Pemrograman, Statistik & Probabilitas, Teknologi Informasi (20 SKS)
  - Semester 2: Desain Basisdata (2x), Kalkulus 2, Pancasila, Prak Basisdata, Tata Tulis Laporan, Komputasi Linear
  - ...dan seterusnya

#### S1 Pendidikan Vokasional Rekayasa Elektro — Kurikulum 2025
- **Link di menu mengarah ke `/` (beranda) — URL belum dibuat**
- Perlu dikonfirmasi: apakah halaman ini sudah ada di server?

### 3.3 Link Footer

| Nama | URL | Status |
|---|---|---|
| Universitas Negeri Gorontalo | https://www.ung.ac.id/ | ✅ OK |
| SIAT (Sistem Informasi Akademik) | https://siat.ung.ac.id/ | ✅ OK |
| Fakultas Teknik UNG | https://ft.ung.ac.id/ | ✅ OK |
| Jurnal Teknik Elektro & Komputer (JJEEE) | https://ejurnal.ung.ac.id/index.php/jjeee/index | ✅ OK |
| Virtual Laboratorium Teknik Elektro | http://labtte.ft.ung.ac.id/login | ⚠️ HTTP |
| Virtual Laboratorium Instalasi Listrik | http://labtte.ft.ung.ac.id/ | ⚠️ HTTP |
| ELDIMAS Jurnal Pengabdian Masyarakat | http://eldimas.elektro.ft.ung.ac.id/ | ⚠️ HTTP |
| Facebook JTEK | https://www.facebook.com/teknikelektroung | ✅ OK |

---

## 4. Masalah Teridentifikasi

### 4.1 Routing & Broken Links (KRITIS)

| # | Masalah | Detail | Prioritas |
|---|---|---|---|
| 1 | **Halaman Visi & Misi 404** | `/visi-misi.php` tidak ada | 🔴 KRITIS |
| 2 | **Menu Kurikulum PV Rekayasa Elektro** | Link "Kurikulum 2025" di bawah PV Rekayasa Elektro mengarah ke `/` (beranda) | 🔴 KRITIS |
| 3 | **Link menu "Kurikulum" utama** | Mengarah ke `#` (anchor kosong) | 🟡 MENENGAH |
| 4 | **Link menu "Profil" utama** | Mengarah ke `#` (anchor kosong) | 🟡 MENENGAH |
| 5 | **Link menu "Akademik" utama** | Mengarah ke `#` (anchor kosong) | 🟡 MENENGAH |
| 6 | **Halaman berita detail timeout** | `baca-berita.php?url=...` tidak bisa diakses | 🟡 MENENGAH |
| 7 | **Halaman 404 sangat plain** | Cuma heading "Not Found", tanpa navigasi | 🟢 RENDAH |

### 4.2 Konten Outdated

| # | Masalah | Detail | Prioritas |
|---|---|---|---|
| 1 | **Footer copyright 2022** | "2022 Teknik Elektro. All Right Reserved" | 🔴 KRITIS |
| 2 | **Struktur Organisasi Kemahasiswaan 2016** | Data masih periode 2016 (Fahrizal, Arif Nur, Abdul Rasyid, Rafi, Andi, Irsyad, Fitran) — 9 tahun lalu | 🔴 KRITIS |
| 3 | **Pengumuman outdated di beranda** | SIATEK 18 Agustus 2023 dan SKP 31 Januari 2023 masih tampil | 🟡 MENENGAH |
| 4 | **Nama duplikat di Struktur Organisasi** | Syahrir Abdussamad muncul 2x | 🟢 RENDAH |
| 5 | **Dokumen SOP tanpa label** | 24 file PDF cuma ikon tanpa nama/deskripsi | 🟡 MENENGAH |

### 4.3 Masalah SEO & Teknis

| # | Masalah | Detail | Prioritas |
|---|---|---|---|
| 1 | **Konten JS-rendered tidak ter-index** | Tenaga Pendidik, Mahasiswa, Publikasi, Alumni, Berita semua render via JS | 🔴 KRITIS |
| 2 | **Tidak ada sitemap.xml** | — | 🟡 MENENGAH |
| 3 | **HTTP pada virtual lab** | 3 link masih HTTP, bukan HTTPS | 🟡 MENENGAH |
| 4 | **Title page tidak konsisten** | Ada "Teknik Elektro", "Teknik Elektro dan Komputer", "Teknik Elektro - Berita" | 🟢 RENDAH |
| 5 | **Digicore attribution visible** | Link digicore.web.id tetap ada di HTML | 🟢 RENDAH |

### 4.4 Masalah Desain & UX

| # | Masalah | Detail | Prioritas |
|---|---|---|---|
| 1 | **Navigasi header duplikasi** | Di beberapa halaman muncul navigasi ganda (header + sidebar) | 🔴 KRITIS |
| 2 | **Desain visual generik** | Template Bootstrap default, font Inter — tidak ada identitas unik | 🟡 MENENGAH |
| 3 | **Hero carousel tanpa deskripsi** | 10 slide tanpa penjelasan visual | 🟡 MENENGAH |
| 4 | **Fasilitas tanpa gambar/detail** | 6 fasilitas hanya nama tanpa foto | 🟡 MENENGAH |
| 5 | **Tidak ada skip-to-content** | Tidak ada aksesibilitas keyboard navigation | 🟡 MENENGAH |

---

## 5. Blueprint To-Be

### 5.1 Sitemap Baru

```
https://elektro.ft.ung.ac.id/
├── Beranda
│   ├── Hero Carousel (slider kegiatan terbaru)
│   ├── Sekilas Tentang JTEK (video profil + deskripsi)
│   ├── Berita Terbaru (3 terakhir)
│   ├── Agenda Jurusan
│   ├── Statistik Singkat (dosen, mahasiswa, alumni, publikasi)
│   └── Publikasi Terbaru
├── Profil
│   ├── Sejarah (daftar ketua jurusan 2001-sekarang)
│   ├── Visi, Misi, Tujuan & Strategi ← HARUS DIBUAT
│   ├── Struktur Organisasi (bagan + kontak)
│   └── Tenaga Pendidik (grid card: foto, nama, bidang keahlian, riset, Google Scholar)
├── Program Studi
│   ├── S1 Pendidikan Vokasional Rekayasa Elektro
│   │   ├── Profil Prodi
│   │   ├── Kurikulum 2025 (OBE) ← LINK MASIH SALAH (/ → beranda)
│   │   └── Dosen Pengampu
│   ├── S1 Teknik Elektro
│   │   ├── Profil Prodi
│   │   ├── Kurikulum 2025 (OBE) — /kurikulum-obe-te ✓
│   │   ├── Kurikulum 2017 (KKNI) — /kurikulum-kkni ✓
│   │   └── Dosen Pengampu
│   └── S1 Teknik Komputer
│       ├── Profil Prodi
│       ├── Kurikulum 2025 (OBE) — /kurikulum-obe-tk ✓
│       └── Dosen Pengampu
├── Akademik
│   ├── Dokumen Panduan & SOP (24 dokumen dengan label)
│   ├── Dokumen Penjamin Mutu (5 dokumen)
│   ├── Dokumen Kurikulum (5 dokumen)
│   ├── Dokumen Akreditasi (C1-C9 + Visi Misi)
│   └── Laporan Kinerja (2019-2024)
├── Mahasiswa
│   ├── Kegiatan Mahasiswa
│   ├── Struktur Organisasi Kemahasiswaan ← UPDATE DATA 2016
│   ├── Statistik Mahasiswa
│   ├── Statistik Prestasi
│   └── Statistik MBKM
├── Publikasi Ilmiah
│   ├── Daftar Publikasi (filter tahun/penulis)
│   ├── Statistik Publikasi
│   └── Link ke Jurnal Online (JJEEE)
├── Fasilitas
│   ├── Laboratorium Tegangan Tinggi
│   ├── Laboratorium Elektronika dan Telekomunikasi
│   ├── Laboratorium Dasar Tenaga Listrik
│   ├── Perpustakaan Jurusan
│   ├── Laboratorium Teknik Kendali
��   └── Laboratorium Komputer
├── Alumni
│   ├── Database Alumni (filter: tahun lulus 2014-2026)
│   ├── Cerita Sukses Alumni
│   └── Jaringan Alumni
├── Berita & Acara
│   ├── Daftar Berita (grid card + thumbnail)
│   ├── Kategori Berita
│   ├── Agenda Jurusan
│   └── Arsip Berita
└── Kontak
    ├── Alamat Lengkap
    ├── Google Maps
    ├── Nomor Telepon/Email
    └── Media Sosial (Facebook)
```

### 5.2 Design Tokens (Rekomendasi)

| Token | Nilai | Keterangan |
|---|---|---|
| Primary Color | `#003366` | Navy UNG |
| Secondary Color | `#E8B931` | Gold/Kuning UNG |
| Accent Color | `#0066CC` | Link & CTA |
| Font | `Inter` / `Poppins` | Body & headings |
| Border Radius | `8px` | Card, button |
| Grid | 12-column responsive | Mobile-first |

### 5.3 Wireframe Beranda

```
┌─────────────────────────────────────────────┐
│ [Logo JTEK] [NAV: Profil | Prodi | Akademik │ ← Sticky header
│            [Mahasiswa | Publikasi | Fasilitas│
│            [Alumni | Berita | Kontak]        │
├───────────────────────────���─────────────────┤
│          HERO SECTION (carousel/slider)      │
│     [Foto kegiatan + overlay teks]           │
├─────────────────────────────────────────────┤
│ SEKILAS TENTANG JTEK                        │
│ [Video Profil] [Tentang singkat]             │
│ [Daftar Ketua Jurusan - tabel]              │
├─────────────────────────────────────────────┤
│ PROGRAM STUDI                                │
│ [Card: PV Rekayasa Elektro]                 │
│ [Card: Teknik Elektro] [Card: Teknik Komputer]│
├─────────────────────────────────────────────┤
│ BERITA TERBARU                               │
│ [Card 1] [Card 2] [Card 3]                   │
│ [Lihat Semua →]                              │
├─────────────────────────────────────────────┤
│ STATISTIK                                    │
│ [Dosen: 24+] [Mahasiswa: XXX]               │
│ [Alumni: XXX] [Publikasi: XX+]              │
├─────────────────────────────────────────────┤
│ FOOTER                                       │
│ [Logo] [Alamat] [Kontak] [Sosmed]           │
│ [Quick Links] [Virtual Lab] [Jurnal]        │
│ © 2025 Teknik Elektro & Komputer UNG         │
└─────────────────────────────────────────────┘
```

---

## 6. Komponen Global

### 6.1 Header/Navigation
- **Sticky header** dengan logo JTEK kiri, navigasi kanan
- **Dropdown menu** responsif (mobile: hamburger)
- **Search bar** untuk pencarian konten
- **Breadcrumb** navigasi di setiap halaman dalam

### 6.2 Footer
- **Kolom 1**: Logo + alamat + kontak
- **Kolom 2**: Quick Links (Beranda, Profil, Prodi, Akademik)
- **Kolom 3**: Layanan (Virtual Lab, Jurnal, SIAT)
- **Kolom 4**: Media Sosial (Facebook)
- **Copyright bar**: © 2025 Teknik Elektro & Komputer UNG

### 6.3 Kontak
- **Alamat**: Jl. Prof. Dr.Ing. B.J. Habibie, Moutong – Tilongkabila, Kab Bone Bolango, Gorontalo 96554
- **Facebook**: https://www.facebook.com/teknikelektroung
- **Google Maps** embed

---

## 7. Konten yang Perlu Dikoreksi

| # | Halaman | Masalah | Aksi |
|---|---|---|---|
| 1 | Footer | Copyright 2022 | Update ke 2025 |
| 2 | Profil → Visi & Misi | Halaman 404 | Buat halaman baru `/visi-misi` |
| 3 | Kurikulum → PV Rekayasa Elektro | Link ke beranda | Fix URL ke halaman kurikulum PV |
| 4 | Mahasiswa → Struktur Organisasi | Data 2016 | Update data terkini |
| 5 | Beranda → Informasi | Pengumuman 2023 | Hapus/arshipkan |
| 6 | Struktur Organisasi | Syahrir Abdussamad duplikat | Hapus duplikat |
| 7 | Akademik → SOP | 24 dokumen tanpa label | Tambah nama/deskripsi |
| 8 | Footer | 3 link HTTP | Upgrade ke HTTPS |

---

## 8. User Flow

### 8.1 Calon Mahasiswa
```
Google → Landing Page → Program Studi → Pilih Prodi → Lihat Kurikulum → Info Pendaftaran
```

### 8.2 Mahasiswa Aktif
```
Landing Page → Akademik → SOP/Mutu → Unduh Dokumen
```

### 8.3 Peneliti/Eksternal
```
Google → Publikasi Ilmiah → Detail Publikasi → Download/DOI
```

### 8.4 Alumni
```
Landing Page → Alumni → Filter Tahun → Cari Nama → Profil
```

---

## 9. KPI & Metrik Keberhasilan

### 9.1 Core Web Vitals
| Metrik | Target |
|---|---|
| LCP | < 2.5 detik |
| FID | < 100 ms |
| CLS | < 0.1 |

### 9.2 SEO Metrics
| Metrik | Target |
|---|---|
| Google Index | 100% halaman ter-index |
| Organic Traffic | +50% dalam 6 bulan |
| Bounce Rate | < 40% |
| Keyword Ranking | Top 10 "teknik elektro gorontalo" |

### 9.3 UX Metrics
| Metrik | Target |
|---|---|
| Pages/Session | > 3 |
| Accessibility Score | 90+ (Lighthouse) |
| Mobile Friendly | 100% |
| Broken Links | 0 |

---

## 10. Roadmap Pelaksanaan

### Tahap 1: Audit & Perencanaan (Minggu 1-2)
- [ ] Finalisasi sitemap dan wireframe
- [ ] Pengumpulan materi (foto, video, dokumen)
- [ ] Persetujuan blueprint

### Tahap 2: Desain Visual (Minggu 3-5)
- [ ] Mockup halaman beranda (3 opsi)
- [ ] Mockup halaman dalam
- [ ] Design system (colors, typography, components)
- [ ] Review dan revisi

### Tahap 3: Development (Minggu 6-12)
- [ ] Setup CMS (WordPress/Custom Laravel)
- [ ] Implementasi desain ke template
- [ ] Migrasi konten (berita, dokumen, data dosen)
- [ ] Fix routing dan broken links
- [ ] Buat halaman Visi & Misi
- [ ] Fix link Kurikulum PV Rekayasa Elektro
- [ ] SEO optimization (meta, sitemap, structured data)
- [ ] SSL/HTTPS untuk semua subdomain

### Tahap 4: Testing & QA (Minggu 13-14)
- [ ] Cross-browser testing
- [ ] Mobile responsiveness
- [ ] Accessibility audit (WCAG 2.1 AA)
- [ ] Performance testing (Lighthouse)
- [ ] Broken link check
- [ ] UAT oleh pihak jurusan

### Tahap 5: Launch & Monitoring (Minggu 15+)
- [ ] Deploy production
- [ ] Submit sitemap ke Google Search Console
- [ ] Monitoring 30 hari
- [ ] Training admin jurusan
- [ ] Dokumentasi & handover

---

## 11. Pertanyaan Klarifikasi

1. **CMS Platform**: Tetap template Digicore atau migrasi ke WordPress/Laravel?
2. **Hosting**: Tetap server sama atau migrasi?
3. **Domain**: Tetap `elektro.ft.ung.ac.id` atau domain sendiri?
4. **Data Visi & Misi**: Sudah tersedia? (halaman saat ini 404)
5. **Data Kurikulum PV Rekayasa Elektro**: Apakah sudah ada halamannya di server? Link menu mengarah ke beranda.
6. **Data Dosen**: 24+ dosen sudah lengkap? Perlu verifikasi bio, fokus riset, foto?
7. **Data Alumni**: Database dari tahun 2014-2026 perlu dimigrasi?
8. **Struktur Organisasi Kemahasiswaan**: Data 2016 perlu update — ada data terbaru?
9. **Virtual Laboratory**: Link HTTP perlu upgrade HTTPS?
10. **ELDIMAS**: Link HTTP perlu upgrade HTTPS?
11. **Budget**: Ada budget untuk desain profesional?
12. **Timeline**: Ada deadline tertentu (akreditasi, penerimaan mahasiswa baru)?

---

*Blueprint dibuat berdasarkan eksplorasi menyeluruh situs elektro.ft.ung.ac.id pada 25 Juli 2025.*
*Sumber: HTML source analysis, browser inspection, curl HTTP status checks.*
