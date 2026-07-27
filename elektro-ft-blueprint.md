# BLUEPRINT REDESAIN — Teknik Elektro & Komputer UNG

**Tanggal eksplorasi:** 2026-07-24
**URL target:** https://elektro.ft.ung.ac.id
**Institusi:** Jurusan Teknik Elektro & Komputer, Fakultas Teknik, Universitas Negeri Gorontalo
**Alamat:** Jl. Prof. Dr.Ing. B.J. Habibie, Moutong – Tilongkabila, Kab. Bone Bolango, Gorontalo 96554

---

## 1. RINGKASAN EKSEKUTIF

Website saat ini adalah situs informasi statis-institusional yang dibangun dengan **template CMS lama** (kemungkinan besar WordPress + tema klasik). Tampilan fungsional dan terorganisir, namun terasa **ketinggalan zaman**:

- Font sistem default, **tanpa Google Font modern**
- Layout kaku, repetitif, **tanpa micro-interaction**
- Hero slider gambar tanpa caption jelas
- **404 pada menu Alumni & Publikasi langsung** (link di header salah routing)
- Footer **copyright 2022** (outdated)
- **Informasi 2023 masih live** tanpa tanda arsip
- Tidak ada state management data yang baik: banyak section "Memuat data…" lambat

**Kesimpulan:** situs perlu **rebuild total frontend** dengan framework modern, struktur informasi dikoreksi, dan aksesibilitas ditingkatkan.

---

## 2. AUDIENS & TUJUAN

### Audiens primer
1. **Calon mahasiswa** — eksplorasi prodi, kurikulum, fasilitas, prestasi
2. **Mahasiswa aktif** — cek jadwal, berita, kegiatan, akses dokumen
3. **Orang tua / wali** — verifikasi mutu, akreditasi, dosen
4. **Dosen & tendik** — akses dokumen internal, publikasi, SOP
5. **Alumni** — jejaring, lowongan, data kelulusan
6. **Mitra industri & masyarakat umum** — profil, kontak, kerja sama

### Tujuan redesain
1. Tampilan **profesional & modern** sesuai standar situs kampus negeri 2025
2. **Navigasi jelas & bebas 404** — perbaikan struktur routing
3. **Konten dinamis update** — informasi 2023-2025 dipilah/ditandai
4. **Aksesibilitas** — readable untuk audience tua
5. **Mobile-first** — banyak calon mahasiswa akses via HP

---

## 3. STRUKTUR INFORMASI SAAT INI (As-Is)

### 3.1 Menu utama (9 item)
| Menu | URL / Submenu | Status |
|---|---|---|
| Beranda | `/` (root) | ✅ Aktif |
| **Profil** | dropdown: Sejarah, Struktur Organisasi, Tenaga Pendidik | ✅ |
| **Kurikulum** | dropdown: Kurikulum 2025 (TE), Kurikulum 2025 (TK), Kurikulum 2017 (KKNI) | ✅ |
| **Akademik** | dropdown: Dokumen Panduan & SOP, Penjamin Mutu, Dokumen Kurikulum, Akreditasi, Laporan Kinerja | ✅ |
| Mahasiswa | `/mahasiswa` | ✅ |
| Publikasi | `/publikasi-ilmiah` (header pakai `/publikasi` → **404**) | ⚠️ **ROUTING SALAH** |
| Fasilitas | `/fasilitas` | ✅ |
| Alumni | `/data-alumni` (header pakai `/alumni` → **404**) | ⚠️ **ROUTING SALAH** |
| Berita | `/berita` (hampir kosong, hanya judul) | ✅ tp konten minim |

### 3.2 Halaman yang sudah dieksplorasi
| Halaman | Konten utama | Catatan |
|---|---|---|
| **Beranda** (`/`) | Hero slider 10 slide (kegiatan), YouTube profil, 3 berita, 3 agenda + info + publikasi, 3 kegiatan, 3 lab | Terlalu padat, scrolling panjang |
| **Sejarah** (`/sejarah`) | Tabel 8 Ketua Jurusan (2001-sekarang) | Sederhana, tabel Bootstrap |
| **Struktur Organisasi** (`/struktur-organisasi`) | 8 card nama + Bidang Keahlian + Google Scholar link | Duplikat Syahrir Abdussamad, 1 card tidak ada foto |
| **Tenaga Pendidik** (`/dosen`) | Halaman paginasi 3, list card | Card tidak muncul di snapshot (kemungkinan JS render lambat) |
| **Kurikulum OBE TE** (`/kurikulum-obe-te`) | Visi, TPPS, Pengelola, 4 Profil Lulusan, 11 CPL, sebaran MK 8 semester (tabel) | **Halaman terkaya** — sumber data utama |
| **Dokumen Panduan & SOP** | 24 link ikon (PDF/DOC) tanpa label teks | Label hilang, cuma ikon |
| **Mahasiswa** (`/mahasiswa`) | Kegiatan + Struktur Org Kemahasiswaan (periode 2016) + chart Statistik Mahasiswa/Prestasi/MBKM + Berita | Data 2016 outdated |
| **Fasilitas** (`/fasilitas`) | 6 lab + perpustakaan (heading only, tanpa gambar/deskripsi) | **Sangat minim**, card tanpa konten |
| **Publikasi** (`/publikasi-ilmiah`) | List judul paper + author + tahun (paginasi 5) + chart statistik publikasi | Plain list, tidak ada kategori |
| **Alumni** (`/data-alumni`) | Search + filter tahun lulus (2014-2026) + list | State "Memuat data…" lama, filter jalan tapi list kosong di snapshot |
| **Berita** (`/berita`) | Judul section + Agenda + Publikasi + 3 berita | **Hampir kosong**, hanya 3 card |
| **404 Not Found** | Plain heading | Tanpa layout |

### 3.3 Komponen UI yang teridentifikasi
- Header: logo + judul + nav horizontal 9 item + submenu accordion
- Hero slider: 10 slide, navigasi dot + prev/next, caption overlay
- YouTube embed: video profil
- Card berita: gambar + tanggal + judul + "Baca Selengkapnya"
- Card kegiatan: gambar + judul + "Baca Selengkapnya"
- Card laboratorium: hanya heading (tanpa gambar/deskripsi)
- Tabel: struktur ketua, profil lulusan, CPL, sebaran MK
- Chart: "Statistik Mahasiswa", "Statistik Prestasi", "Statistik MBKM", "Statistik Publikasi" (5 chart button) — render via library JS
- Pagination: numeric + Previous/Next
- Footer 3 kolom: Links / Contact / (kosong)
- Iframe Google Maps di footer

---

## 4. MASALAH YANG DITEMUKAN

### 4.1 Struktur / Routing
1. **Header menu Alumni** link ke `/alumni` → **404** (harusnya `/data-alumni`)
2. **Header menu Publikasi** link ke `/publikasi` → **404** (harusnya `/publikasi-ilmiah`)
3. Submenu Profil/Sejarah/Struktur/Dosen semua di-flat, tidak konsisten (campur `/profil/x` vs `/x`)

### 4.2 Konten
1. **Footer copyright "2022"** — tidak di-update
2. **Informasi 2023** masih tampil sebagai "berita/informasi terbaru" tanpa filter arsip
3. **Struktur Organisasi Kemahasiswaan** periode **2016** (9 tahun lalu) — tidak ada periode lain
4. **Fasilitas** — heading tanpa deskripsi, gambar, atau data pendukung
5. **Dokumen Panduan & SOP** — 24 link **tanpa label** (cuma ikon)
6. **Berita** — hampir kosong, tidak ada daftar kronologis atau filter kategori
7. **Halaman 404** — plain, tidak ada navigasi kembali atau sitemap
8. **Profil Lulusan (Kurikulum)** duplikat entry: Syahrir Abdussamad muncul 2x di struktur

### 4.3 Visual / Tipografi
1. **Font sistem default** (Arial/Helvetica fallback) — tidak ada Google Font
2. **Warna monoton** navy + putih + sedikit merah — tanpa hirarki aksen
3. **Card tanpa hover effect** / bayangan / elevasi
4. **Tombol CTA repetitif** "Baca Selengkapnya" / "Selengkapnya" — variasi minimal
5. **Hero slider** caption tipografi generik, kontrol minim
6. **Info tipografi kaku** di section "Informasi" wall-of-text tanpa breathing space
7. **Footer** — kolom ketiga kosong, tipografi kecil, tidak ada sosmed

### 4.4 Performa / Aksesibilitas
1. **Tanpa lazy loading** eksplisit untuk gambar
2. **Tanpa skip-to-content** untuk screen reader
3. **Chart button tanpa label** (5 button kosong di section statistik) — aksesibilitas buruk
4. **Halaman "Memuat data…"** lama di Alumni → UX buruk
5. **Tidak ada sitemap.xml / breadcrumb** yang jelas
6. **Tanpa search global** yang berfungsi baik (cuma di Alumni)

### 4.5 Keamanan / Teknis (asumsi, dari pengamatan)
- CMS lama, kemungkinan WordPress
- HTTPS sudah aktif
- Iframe Google Maps di setiap halaman — menambah beban load

---

## 5. BLUEPRINT REDESAIN (To-Be)

### 5.1 Prinsip desain
1. **Modern academic** — bootstrap formal + sentuhan editorial (mirip pola §C SIATEK atau template kampus top global)
2. **Audience-aware** — body 16px+, tipografi jelas untuk orang tua
3. **Mobile-first responsive** — breakpoint mobile/tablet/desktop
4. **Konten-first** — struktur informasi dikoreksi dulu sebelum styling
5. **Performance budget** — lazy-load image, critical CSS inline, target LCP < 2.5s

### 5.2 Stack rekomendasi
- **Frontend:** Next.js 14 (App Router) + TypeScript
- **Styling:** Tailwind CSS + shadcn/ui (komponen siap)
- **Font:** Inter (UI) + Plus Jakarta Sans (display) — atau Source Serif 4 + Inter kalau mode formal dosen
- **CMS:** tetap WordPress (headless via WPGraphQL) untuk kontributor non-teknis; atau migrasi ke Strapi/Payload
- **Image:** Next/Image dengan optimasi otomatis
- **Chart:** Recharts (untuk statistik)
- **Search:** Algolia atau Lunr.js (static search index)
- **Hosting:** sesuai existing (Tailscale 100.x — internal/admin) + publik via UNG domain

### 5.3 Struktur informasi baru (sitemap)

```
/                            → Beranda (hero, ringkasan, berita, agenda)
/profil
  /sejarah                   → Timeline ketua + milestones
  /visi-misi                 → Visi, misi, tujuan prodi
  /struktur-organisasi       → Bagan + daftar pejabat
  /tenaga-pendidik           → Direktori dosen (filterable)
/kurikulum
  /obe-te                    → Kurikulum OBE S1 Teknik Elektro
  /obe-tk                    → Kurikulum OBE S1 Teknik Komputer
  /kkni                      → Kurikulum 2017 (arsip)
/akademik
  /panduan-sop               → List dokumen + label
  /penjamin-mutu             → Dokumen mutu
  /akreditasi                → Status akreditasi + sertifikat
  /laporan-kinerja           → Laporan tahunan
/mahasiswa
  /kegiatan                  → List kegiatan + agenda
  /organisasi                → BEM & ormawa + periode
  /statistik                 → Dashboard chart (mahasiswa, prestasi, MBKM)
/publikasi                  → PERBAIKAN: bukan 404
  /artikel                   → Paper/jurnal
  /buku                      → Buku / book chapter
  /hki                       → Paten / hak cipta
  /statistik                 → Chart publikasi per tahun
/fasilitas
  /lab-tegangan-tinggi
  /lab-elektronika
  /lab-dasar-tenaga-listrik
  /lab-teknik-kendali
  /lab-komputer
  /perpustakaan
/alumni                     → PERBAIKAN: bukan 404
  /direktori                 → Search + filter
  /cerita                    → Testimoni alumni
  /lowongan                  → Job board (opsional)
/berita
  /[kategori]                → Filter: pengumuman, kegiatan, prestasi
  /[slug]                    → Detail berita
/hubungi-kami                → Kontak, peta, form
/cari                       → Search global
```

### 5.4 Wireframe per halaman utama

#### 5.4.1 Beranda (`/`)
```
┌─────────────────────────────────────────────────┐
│  HEADER (sticky)                                │
│  [Logo + Judul Jurusan]   Nav: Beranda | ...    │
├─────────────────────────────────────────────────┤
│  HERO (full-width, 60vh)                        │
│  - Image + caption: Visi singkat                 │
│  - CTA: "Pelajari Prodi" / "Daftar Sekarang"    │
├─────────────────────────────────────────────────┤
│  STATS STRIP (4 KPI cards)                      │
│  - Mahasiswa Aktif | Dosen | Prodi | Akreditasi│
├─────────────────────────────────────────────────┤
│  PROFIL SINGKAT (2 kolom)                       │
│  - Visi Misi kiri, video profil kanan           │
├─────────────────────────────────────────────────┤
│  BERITA TERBARU (3 card grid)                   │
│  - Image + tanggal + judul + excerpt            │
│  - Tombol "Semua Berita →"                      │
├─────────────────────────────────────────────────┤
│  AGENDA + PENGUMUMAN (2 kolom)                  │
│  - Kiri: agenda 5 item chronological            │
│  - Kanan: pengumuman pinned                     │
├─────────────────────────────────────────────────┤
│  KEGIATAN MAHASISWA (3 card grid)               │
├─────────────────────────────────────────────────┤
│  FASILITAS (6 card grid + tombol Selengkapnya)  │
├─────────────────────────────────────────────────┤
│  FOOTER (4 kolom)                               │
│  - Profil | Akademik | Tautan | Kontak+Sosmed  │
└─────────────────────────────────────────────────┘
```

#### 5.4.2 Halaman detail ( Berita / Fasilitas / Publikasi / Kurikulum )
- **Tanpa sidebar** — fokus konten
- **Breadcrumb** di atas H1
- **Hero image** (jika berita) atau **icon + judul** (jika dokumen)
- **Konten utama** centered max-width 800px untuk readability
- **Sidebar ringkas kanan**: tanggal, penulis, bagikan (share buttons), related
- **Related items** di bawah (3 card horizontal)
- **CTA kembali ke daftar** di paling bawah

#### 5.4.3 Direktori dosen (`/profil/tenaga-pendidik`)
- **Header** dengan search bar
- **Filter chips**: Bidang Keahlian, Jabatan, Status
- **Grid card 3 kolom** (desktop), 1 kolom (mobile)
- Tiap card: foto, nama, NIP/NIDN, jabatan, bidang keahlian, link Google Scholar/Sinta
- **Klik card** → halaman detail dosen dengan publikasi, pendidikan, mata kuliah yang diampu

#### 5.4.4 Kurikulum (`/kurikulum/obe-te`)
- **TOC kiri** (sticky): Visi, TPPS, Profil Lulusan, CPL, Sebaran MK, CPL-MK Mapping
- **Konten utama**: tiap section dengan tabel/grid modern
- **Sebaran MK per semester**: tab/accordion per semester, tabel dengan chip untuk SKS/jenis MK
- **Download kurikulum PDF** floating button kanan bawah

### 5.5 Sistem desain (design tokens)

#### Warna
```
--primary: #0F2A47 (navy dalam) — pengganti warna utama header
--primary-soft: #1E3A5F (navy medium) — heading section
--accent: #D97706 (amber — pengingat energi/ketenagalistrikan)
--accent-soft: #FEF3C7
--ink: #0F172A
--ink-soft: #475569
--ink-mute: #94A3B8
--rule: #E2E8F0
--bg: #FFFFFF
--bg-soft: #F8FAFC
--success: #059669
--warning: #D97706
--danger:  #DC2626
```

#### Tipografi
- **Display / Heading:** Plus Jakarta Sans 600/700
- **Body:** Inter 400/500
- **Data tabular:** Inter + `font-variant-numeric: tabular-nums`
- **Ukuran:** body 16px, H1 36-44px, H2 24-28px, H3 18-20px, small 13-14px

#### Spacing
- Skala 4-8-12-16-24-32-48-64-96
- Section padding: 64-96 vertikal desktop, 32-48 mobile
- Container max-width: 1280px (default), 800px (artikel)

#### Komponen
- **Card berita**: shadow halus, hover lift, image aspect 16:9
- **Card dosen**: foto 1:1, nama bold 18px, chip Bidang Keahlian
- **Chip info**: pill, 12-13px, bg netral
- **Tombol**: primary (fill navy), secondary (outline), ghost (text only)
- **Section heading**: numbered (01, 02, …) atau uppercase eyebrow + H2 serif

### 5.6 Komponen global
1. **Top bar** (tipis di atas header): info PMB / hotline / tanggal hari ini
2. **Header**: logo + nav 9 item + search icon + CTA "Daftar"
3. **Mega-menu** untuk dropdown Kurikulum & Akademik (panel lebar dengan card per submenu)
4. **Footer 4 kolom**: 
   - Kolom 1: Logo + alamat singkat + sosmed (Instagram, YouTube, Facebook, Twitter)
   - Kolom 2: Tautan Cepat (Beranda, Profil, Kurikulum, Akademik)
   - Kolom 3: Layanan (Publikasi, Fasilitas, Alumni, Berita)
   - Kolom 4: Kontak + peta mini + newsletter signup
5. **Floating WhatsApp button** (opsional, popular untuk kampus Indonesia)
6. **Cookie consent banner** (GDPR-aware)
7. **Skip-to-content link** untuk a11y

---

## 6. KONTEN YANG PERLU DIKORÉKSI / DILENGKAPI

| Item | Tindakan |
|---|---|
| Footer copyright "2022" | Update ke 2026 (atau auto-update via script) |
| Informasi 2023 di Beranda | Pindahkan ke arsip atau tandai "[Arsip]" |
| Struktur Organisasi Mahasiswa 2016 | Tambahkan minimal 3 periode terakhir (2019, 2022, 2024) |
| Card Fasilitas (heading only) | Tambah foto lab + deskripsi + peralatan utama |
| Link Dokumen Panduan tanpa label | Tambah label/teks untuk setiap link |
| Menu Alumni/Publikasi 404 | Perbaiki URL atau redirect |
| Berita hampir kosong | Lihat apakah ada data berita yang tidak ter-publish |
| Halaman 404 | Buat custom 404 dengan sitemap + search |

---

## 7. ALUR PENGGUNA INTI (User Flow)

### 7.1 Calon mahasiswa
1. Landing di Beranda → lihat hero "Bergabung dengan Teknik Elektro UNG"
2. Klik CTA → scroll ke Prodi Singkat
3. Klik "Kurikulum" → pilih program → lihat sebaran MK
4. Klik "Fasilitas" → eksplorasi lab
5. Klik "Dosen" → lihat profil pengajar
6. Klik "Hubungi Kami" atau form PMB

### 7.2 Mahasiswa aktif
1. Buka Beranda → cek Agenda & Pengumuman
2. Buka Publikasi → cari jurnal prodi
3. Buka Akademik → unduh SOP / format laporan
4. Buka Berita → cek info terbaru

### 7.3 Orang tua
1. Landing di Beranda → cek "Akreditasi" (pinned)
2. Klik "Dosen" → lihat kualifikasi
3. Buka "Fasilitas" → lihat lab
4. Buka "Visi Misi" → cek kesesuaian

### 7.4 Dosen
1. Login (kalau ada) → akses Dashboard
2. Unggah publikasi
3. Unduh dokumen SOP
4. Update profil dosen

---

## 8. KPI & METRIK KEBERHASILAN

| Metrik | Target |
|---|---|
| **LCP** (Largest Contentful Paint) | < 2.5 detik |
| **CLS** (Cumulative Layout Shift) | < 0.1 |
| **INP** (Interaction to Next Paint) | < 200 ms |
| **Bounce rate** Beranda | < 50% |
| **Avg. session duration** | > 2 menit |
| **Mobile traffic share** | > 65% |
| **Aksesibilitas** (Lighthouse) | > 90 |
| **SEO** (Lighthouse) | > 90 |
| **Broken links** | 0 |
| **Update frekuensi** berita | minimal 1/minggu |

---

## 9. TAHAP PELAKSANAAN (Roadmap)

### Tahap 1 — Discovery & Perbaikan Konten (2-3 minggu)
- Audit seluruh halaman, koreksi 404, update informasi outdated
- Lengkapi foto & deskripsi fasilitas
- Lengkapi label dokumen SOP
- Tambah periode organisasi kemahasiswaan
- Update footer copyright

### Tahap 2 — Design System & Mockup (3-4 minggu)
- Tentukan style guide final (warna, font, komponen)
- Mockup Beranda (revisi dengan Bos)
- Mockup 3-4 halaman utama (Profil, Kurikulum, Dosen, Publikasi)
- Approval mockup

### Tahap 3 — Implementasi Frontend (6-8 minggu)
- Setup Next.js + Tailwind + shadcn
- Implementasi design system
- Build halaman satu per satu (prioritas: Beranda → Profil → Kurikulum → Mahasiswa)
- Integrasi headless CMS (WordPress/Strapi)
- Setup CI/CD ke hosting

### Tahap 4 — Konten & Migrasi (3-4 minggu)
- Migrasi semua halaman existing
- Lengkapi konten baru (deskripsi lab, periode organisasi, dst)
- Foto baru dosen & fasilitas
- Review & approval internal

### Tahap 5 — Testing & Launch (2 minggu)
- UAT (User Acceptance Testing) oleh admin prodi
- Lighthouse audit (perf, a11y, SEO, best practice)
- Mobile testing
- Soft launch
- Go-live & monitoring

---

## 10. PERTANYAAN UNTUK BOS IDUL (Klarifikasi Sebelum Lanjut)

Sebelum lanjut ke mockup, butuh keputusan:

1. **Stack teknologi**: tetap WordPress (rebuild tema) atau pindah ke Next.js + headless CMS? WordPress lebih cepat untuk admin non-teknis; Next.js lebih modern & performant.

2. **Mode visual**: kampus negeri UNG punya audience kombinasi (mahasiswa muda, dosen senior, orang tua). Mau:
   - (A) **Modern academic** — Plus Jakarta + Inter, segar tapi tetap formal
   - (B) **Bootstrap formal** — Bootstrap 5 + Lora + Inter, "clean elegant" untuk semua audience
   - (C) **Editorial bold** — pakai warna aksen amber (khas ketenagalistrikan), tipografi mix serif-sans, lebih distinctive

3. **Scope mockup**: mau mockup untuk 1 halaman dulu (Beranda) sebagai proof of concept, atau sekaligus 3-4 halaman kunci?

4. **Bahasa**: full Bahasa Indonesia, atau bilingual ID-EN? (kampus top biasanya bilingual)

5. **Newsletter/PMB**: perlu form PMB inline atau external link ke sistem PMB UNG?

6. **Login area**: perlu area login untuk dosen/mahasiswa (akses SIATEK link, upload publikasi, dst) atau full public?

---

## 11. REFERENSI INSPIRASI (Situs Kampus Acuan)

- **Universitas Indonesia (UI)** — moderne, hirarki jelas
- **Institut Teknologi Bandung (ITB)** — bold, distinctive
- **Universitas Gadjah Mada (UGM)** — tradisional-modern balance
- **Universitas Brawijaya** — friendly, colorful
- **Nanyang Technological University (NTU)** — bersih, modern
- **MIT** — editorial, kental akademik
- **Stanford Engineering** — clean, hero kuat
- **ETH Zurich** — formal, hierarkis

---

**Status:** Blueprint selesai. Menunggu approval Bos Idul untuk lanjut ke mockup Beranda.
