<?php
// detail-berita.php — Halaman Detail Berita (v2 - modern layout)
// Pretty URL: /berita/{slug}  (slug = field "keterangan" dari list-berita)
// API: https://temp.ikad-developer.my.id/elektro/detail-berita/{id}
//      di mana `id` adalah base64 dari field "link" list-berita (mis. NTM=, NTE=)
// Alur lookup:
//   1. Terima slug dari URL
//   2. Fetch list-berita → cari item dengan `keterangan === slug`
//   3. Ambil `link` (base64) dari item tersebut
//   4. Fetch /detail-berita/{link}

$currentPage = 'berita';
$pageCss = ['assets/berita.css'];
$pageTitle = 'Detail Berita — Jurusan Teknik Elektro dan Komputer';

// ---- AMBIL & VALIDASI SLUG ----
$slug = isset($_GET['slug']) ? trim((string)$_GET['slug']) : '';
$slug = preg_replace('/[^a-z0-9-]/', '', strtolower($slug));

// Tahan output header.php dulu, render ulang nanti setelah $pageTitle final.
// Buffer A: header.php, lalu flush ke output di akhir.
// Buffer B: mulai di sini, tangkap output header.php, drop dulu.
ob_start();
include 'template/header.php';
// Buang semua output header — akan dipancarkan ulang nanti setelah pageTitle final.
ob_end_clean();

$berita = null;
$fetchError = false;
$currentSlug = '';
$relatedItems = [];
$listClean = []; // untuk sidebar "Berita Terbaru"

if ($slug !== '') {
    try {
        // 1. Fetch list-berita (cache ringan di memori untuk lookup + related + recent)
        $listUrl = 'https://temp.ikad-developer.my.id/elektro/list-berita';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $listUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $listResp = curl_exec($ch);
        $listCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $listData = [];
        if ($listCode === 200 && $listResp) {
            $listData = json_decode($listResp, true);
            if (!is_array($listData)) $listData = [];
        }

        $listClean = array_values(array_filter($listData, fn($it) =>
            is_array($it) && !empty($it['judul']) && !empty($it['link'])
        ));

        // Cari item dengan slug (keterangan) yang cocok
        $matchItem = null;
        foreach ($listClean as $it) {
            if (isset($it['keterangan']) && strtolower($it['keterangan']) === $slug) {
                $matchItem = $it;
                break;
            }
        }

        if ($matchItem) {
            $currentSlug = $matchItem['keterangan'];
            $beritaId = preg_replace('/[^A-Za-z0-9+\/=]/', '', (string)$matchItem['link']);

            $detailUrl = 'https://temp.ikad-developer.my.id/elektro/detail-berita/' . rawurlencode($beritaId);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $detailUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 200 && $response) {
                $decoded = json_decode($response, true);
                if (is_array($decoded) && !empty($decoded['judul'])) {
                    $berita = $decoded;
                } else {
                    $fetchError = true;
                }
            } else {
                $fetchError = true;
            }

            // 3 berita acak (selain yang sedang dibuka)
            $kandidat = array_values(array_filter($listClean, fn($it) =>
                isset($it['keterangan']) && $it['keterangan'] !== $currentSlug
            ));
            if (!empty($kandidat)) {
                shuffle($kandidat);
                $relatedItems = array_slice($kandidat, 0, 3);
            }
        } else {
            $fetchError = true;
        }
    } catch (\Exception $e) {
        $fetchError = true;
    }
}

// ---- Helpers ----
function tglIndo($tgl) {
    if (empty($tgl)) return '';
    $ts = strtotime($tgl);
    if (!$ts) return $tgl;
    $bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
              'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    return date('j', $ts) . ' ' . $bulan[(int)date('n', $ts)] . ' ' . date('Y', $ts);
}

function hariIndo($tgl) {
    if (empty($tgl)) return '';
    $ts = strtotime($tgl);
    if (!$ts) return '';
    $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    return $hari[(int)date('w', $ts)];
}

function isiToHtml($isi) {
    if (!$isi) return '';
    $normalized = str_replace(["\r\n", '||'], "\n\n", $isi);
    $normalized = preg_replace("/\r?\n+/", "\n\n", $normalized);
    $parts = array_filter(array_map('trim', explode("\n\n", $normalized)), fn($p) => $p !== '');
    $html = '';
    foreach ($parts as $p) {
        $html .= '<p>' . nl2br(htmlspecialchars($p)) . '</p>';
    }
    return $html;
}

function estimateReadingTime($text) {
    // Rata-rata orang membaca 200 kata/menit (Bahasa Indonesia ~180)
    $wordCount = str_word_count(strip_tags($text), 0, 'äëïöüáéíóúàèìòùâêîôûçÄËÏÖÜÁÉÍÓÚÀÈÌÒÙ');
    // Fallback: kalau ext-intl tidak ada, hitung manual (split by whitespace)
    if (!$wordCount) {
        $wordCount = count(preg_split('/\s+/', strip_tags($text), -1, PREG_SPLIT_NO_EMPTY));
    }
    $minutes = max(1, (int)ceil($wordCount / 180));
    return $minutes;
}

// ---- Siapkan variabel ----
if ($berita) {
    $judul  = $berita['judul'] ?? '(Tanpa judul)';
    $tglRaw = $berita['tanggal'] ?? '';
    $gambar = $berita['gambar'] ?? '';
    $isiRaw = $berita['isi'] ?? '';
    $isiHtml = isiToHtml($isiRaw);
    $tglIndo = tglIndo($tglRaw);
    $hariIndo = hariIndo($tglRaw);
    $readMin  = estimateReadingTime($isiRaw);

    $pageTitle = htmlspecialchars($judul) . ' — Jurusan Teknik Elektro dan Komputer';

    // 5 berita terbaru untuk sidebar (berdasarkan tanggal desc)
    $recentItems = $listClean;
    usort($recentItems, function ($a, $b) {
        $ta = isset($a['tanggal']) ? strtotime($a['tanggal']) : 0;
        $tb = isset($b['tanggal']) ? strtotime($b['tanggal']) : 0;
        return $tb <=> $ta;
    });
    $recentItems = array_values(array_filter($recentItems, fn($it) =>
        isset($it['keterangan']) && $it['keterangan'] !== $currentSlug
    ));
    $recentItems = array_slice($recentItems, 0, 5);
}
?>

<?php
// Header.php sudah di-include di awal (output ditahan).
// Sekarang render ulang isi header dengan pageTitle final yang sudah benar.
// Trik: gunakan include ulang yang sudah di-cache oleh opcache,
// tapi untuk amannya kita pakai output buffer lagi.
ob_start();
include 'template/header.php';
ob_end_flush();
?>

<!-- Reading progress bar (atas, fixed) -->
<div class="reading-progress" id="readingProgress" aria-hidden="true"></div>

<?php if (!$berita): ?>
<!-- ===== STATE: BERITA TIDAK DITEMUKAN ===== -->
<section class="page-banner">
    <div class="container">
        <div>
            <div class="breadcrumb">
                <a href="beranda">Beranda</a> &nbsp;&rsaquo;&nbsp;
                <a href="berita">Berita</a> &nbsp;&rsaquo;&nbsp; Detail
            </div>
            <h1>Berita Tidak Ditemukan</h1>
            <p class="lede">Maaf, berita yang Anda cari tidak dapat dimuat saat ini.</p>
        </div>
        <div class="page-banner-meta">
            <strong>404</strong>
            Berita Kosong
        </div>
    </div>
</section>

<section class="berita-detail-section">
    <div class="container">
        <div class="berita-detail-error">
            <div class="err-icon">!</div>
            <h2>Berita tidak tersedia</h2>
            <p>
                <?php if ($slug === ''): ?>
                    ID berita tidak diberikan pada URL.
                <?php else: ?>
                    Berita dengan slug <code><?php echo htmlspecialchars($slug); ?></code> gagal dimuat dari server. Silakan coba lagi nanti.
                <?php endif; ?>
            </p>
            <a href="berita">Kembali ke Daftar Berita</a>
        </div>
    </div>
</section>

<?php else: ?>
<!-- ===== DETAIL BERITA ===== -->
<section class="page-banner">
    <div class="container">
        <div>
            <div class="breadcrumb">
                <a href="beranda">Beranda</a> &nbsp;&rsaquo;&nbsp;
                <a href="berita">Berita</a> &nbsp;&rsaquo;&nbsp; Detail
            </div>
            <h1><?php echo htmlspecialchars($judul); ?></h1>
            <p class="lede">Kumpulan berita, pengumuman, dan aktivitas terbaru Jurusan Teknik Elektro dan Komputer.</p>
        </div>
        <div class="page-banner-meta">
            <strong><?php echo date('Y', strtotime($tglRaw)); ?></strong>
            <?php echo htmlspecialchars($tglIndo); ?>
        </div>
    </div>
</section>

<!-- ===== HERO IMAGE ===== -->
<?php if (!empty($gambar)): ?>
<?php endif; ?>

<!-- ===== KONTEN UTAMA + SIDEBAR ===== -->
<section class="berita-detail-section">
    <div class="container">
        <div class="berita-detail-grid">

            <!-- ============ ARTIKEL ============ -->
            <article class="berita-article">

                <?php if (!empty($gambar)): ?>
                <!-- Hero image (di dalam panel artikel) -->
                <div class="berita-article-hero">
                    <img src="<?php echo htmlspecialchars($gambar); ?>" alt="<?php echo htmlspecialchars($judul); ?>">
                </div>
                <?php endif; ?>

                <!-- Article header (meta + share) -->
                <header class="berita-article-head">
                    <div class="berita-article-tags">
                        <span class="berita-tag">Berita Jurusan</span>
                        <span class="berita-tag">Teknik Elektro</span>
                    </div>

                    <h1 class="berita-article-title"><?php echo htmlspecialchars($judul); ?></h1>

                    <div class="berita-article-meta">
                        <div class="berita-article-author">
                            <div class="berita-article-avatar">JT</div>
                            <div>
                                <strong>Humas JTEK</strong>
                                <span>Jurusan Teknik Elektro dan Komputer</span>
                            </div>
                        </div>
                        <div class="berita-article-info">
                            <?php if ($tglIndo): ?>
                                <span><i class="ico ico-cal"></i> <?php echo htmlspecialchars(($hariIndo ? $hariIndo . ', ' : '') . $tglIndo); ?></span>
                            <?php endif; ?>
                            <span><i class="ico ico-clock"></i> <?php echo (int)$readMin; ?> menit baca</span>
                        </div>
                    </div>

                    <div class="berita-article-share" aria-label="Bagikan berita">
                        <span class="share-label">Bagikan:</span>
                        <a class="share-btn share-wa" href="https://wa.me/?text=<?php echo urlencode($judul . ' — ' . (isset($_SERVER['HTTP_HOST']) ? ('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) : '')); ?>" target="_blank" rel="noopener" title="Bagikan ke WhatsApp">WA</a>
                        <a class="share-btn share-fb" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(isset($_SERVER['HTTP_HOST']) ? ('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) : ''); ?>" target="_blank" rel="noopener" title="Bagikan ke Facebook">f</a>
                        <button class="share-btn share-copy" type="button" id="shareCopy" title="Salin tautan">⎘</button>
                    </div>
                </header>

                <!-- Body -->
                <div class="berita-article-body">
                    <?php echo $isiHtml ?: '<p><em>Konten berita belum tersedia.</em></p>'; ?>
                </div>

                <!-- Footer artikel (back button saja) -->
                <footer class="berita-article-foot">
                    <a class="berita-back-btn" href="berita" aria-label="Kembali ke daftar berita">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <line x1="19" y1="12" x2="5" y2="12"></line>
                            <polyline points="12 19 5 12 12 5"></polyline>
                        </svg>
                        <span>Kembali ke Daftar Berita</span>
                    </a>
                </footer>

            </article>

            <!-- ============ SIDEBAR ============ -->
            <aside class="berita-sidebar">

                <!-- Berita Terbaru -->
                <div class="berita-side-card">
                    <div class="berita-side-card-head">
                        <span class="side-icon">📰</span>
                        <h4>Berita Terbaru</h4>
                    </div>
                    <div class="berita-side-list">
                        <?php if (!empty($recentItems)): ?>
                            <?php foreach ($recentItems as $i => $r):
                                $rImg   = $r['gambar'] ?? '';
                                $rJudul = $r['judul'] ?? '(Tanpa judul)';
                                $rSlug  = $r['keterangan'] ?? '';
                                $rTgl   = tglIndo($r['tanggal'] ?? '');
                                $rHref  = $rSlug !== '' ? 'berita?slug=' . rawurlencode($rSlug) : 'berita';
                                $isActive = ($rSlug === $currentSlug);
                            ?>
                                <a href="<?php echo $rHref; ?>" class="berita-side-item <?php echo $isActive ? 'is-active' : ''; ?>">
                                    <div class="berita-side-num"><?php echo str_pad($i + 1, 2, '0', STR_PAD_LEFT); ?></div>
                                    <div class="berita-side-content">
                                        <h5><?php echo htmlspecialchars($rJudul); ?></h5>
                                        <?php if ($rTgl): ?>
                                            <span class="date"><?php echo htmlspecialchars($rTgl); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="berita-side-empty">Belum ada berita lain.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Kategori Widget -->
                <div class="berita-side-card">
                    <div class="berita-side-card-head">
                        <span class="side-icon">🏷️</span>
                        <h4>Kategori</h4>
                    </div>
                    <ul class="berita-side-tags">
                        <li><a href="berita">Berita Jurusan <span>(<?php echo count($listClean); ?>)</span></a></li>
                        <li><a href="publikasi">Publikasi</a></li>
                        <li><a href="dokumen-akreditas">Akreditasi</a></li>
                        <li><a href="kurikulum-kkni">Kurikulum</a></li>
                    </ul>
                </div>

                <!-- CTA: Kembali ke daftar -->
                <div class="berita-side-cta-box">
                    <div class="cta-icon">📣</div>
                    <h4>Lihat Semua Berita</h4>
                    <p>Jelajahi kumpulan berita, pengumuman, dan aktivitas terbaru Jurusan Teknik Elektro.</p>
                    <a href="berita">Buka Daftar Berita →</a>
                </div>

            </aside>

        </div>

        <!-- ===== RELATED POSTS (di bawah grid utama) ===== -->
        <?php if (!empty($relatedItems)): ?>
        <div class="berita-related">
            <div class="berita-related-head">
                <h2>Berita Lainnya</h2>
                <p>Artikel lain yang mungkin menarik untuk Anda</p>
            </div>
            <div class="berita-related-grid">
                <?php foreach ($relatedItems as $r):
                    $rImg   = $r['gambar'] ?? '';
                    $rJudul = $r['judul'] ?? '(Tanpa judul)';
                    $rSlug  = $r['keterangan'] ?? '';
                    $rTgl   = tglIndo($r['tanggal'] ?? '');
                    $rHref  = $rSlug !== '' ? 'berita?slug=' . rawurlencode($rSlug) : 'berita';
                ?>
                    <article class="berita-related-card">
                        <a class="berita-related-media" href="<?php echo $rHref; ?>" aria-label="<?php echo htmlspecialchars($rJudul); ?>">
                            <img src="<?php echo htmlspecialchars($rImg); ?>" alt="" loading="lazy" onerror="this.parentNode.classList.add('is-empty');">
                        </a>
                        <div class="berita-related-body">
                            <?php if ($rTgl): ?>
                                <span class="date"><?php echo htmlspecialchars($rTgl); ?></span>
                            <?php endif; ?>
                            <h3><a href="<?php echo $rHref; ?>"><?php echo htmlspecialchars($rJudul); ?></a></h3>
                            <a class="berita-related-link" href="<?php echo $rHref; ?>">Baca selengkapnya →</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

    </div>
</section>

<!-- Back to top -->
<button class="back-to-top" id="backToTop" aria-label="Kembali ke atas" title="Kembali ke atas">↑</button>

<script>
// Reading progress bar
(function () {
    const bar = document.getElementById('readingProgress');
    const article = document.querySelector('.berita-article');
    if (!bar || !article) return;
    function update() {
        const rect = article.getBoundingClientRect();
        const total = rect.height - window.innerHeight;
        const scrolled = -rect.top;
        const pct = total > 0 ? Math.min(100, Math.max(0, (scrolled / total) * 100)) : 0;
        bar.style.width = pct + '%';
    }
    window.addEventListener('scroll', update, { passive: true });
    window.addEventListener('resize', update);
    update();
})();

// Copy share link
(function () {
    const btn = document.getElementById('shareCopy');
    if (!btn) return;
    btn.addEventListener('click', async function () {
        try {
            await navigator.clipboard.writeText(window.location.href);
            const orig = btn.textContent;
            btn.textContent = '✓';
            btn.classList.add('is-done');
            setTimeout(() => {
                btn.textContent = orig;
                btn.classList.remove('is-done');
            }, 1400);
        } catch (e) {}
    });
})();

// Back to top
(function () {
    const btn = document.getElementById('backToTop');
    if (!btn) return;
    function toggle() {
        btn.classList.toggle('is-visible', window.scrollY > 600);
    }
    window.addEventListener('scroll', toggle, { passive: true });
    btn.addEventListener('click', function () {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
    toggle();
})();
</script>
<?php endif; ?>

<?php include 'template/footer.php'; ?>