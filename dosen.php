<?php
$pageTitle = 'Tenaga Pendidik — Jurusan Teknik Elektro dan Komputer';
$currentPage = 'dosen';
$pageCss = ['assets/dosen.css'];
include 'template/header.php';

// ---- FETCH DATA DOSEN DARI API ----
$dosenData = [];
try {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://temp.ikad-developer.my.id/elektro/daftar-dosen');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200 && $response) {
        $decoded = json_decode($response, true);
        if (is_array($decoded)) {
            $dosenData = $decoded;
        }
    }
} catch (\Exception $e) {
    // Jika gagal, tetap tampilkan halaman tanpa data
}

$dosenCount = count($dosenData);
?>

<!-- page banner -->
<section class="page-banner">
    <div class="container">
        <div>
            <div class="breadcrumb"><a href="index.php">Beranda</a> &nbsp;&rsaquo;&nbsp; Tenaga Pendidik</div>
            <h1>Tenaga Pendidik Jurusan Teknik Elektro & Komputer</h1>
            <p class="lede">Dosen dan tenaga pendidik yang mengampu mata kuliah di program studi S1 Teknik Elektro dan S1 Teknik Komputer.</p>
        </div>
        <div class="page-banner-meta">
            <strong><?php echo $dosenCount; ?></strong>
            Dosen Aktif
        </div>
    </div>
</section>

<!-- DOSEN SECTION -->
<section id="tenaga-pendidik">
    <div class="container">
        <div class="section-head section-head-split">
            <div class="section-head-left">
                <div class="section-eyebrow">Tenaga Pendidik</div>
            </div>
            <div class="section-head-right">
                <h2 class="section-title">Daftar Dosen</h2>
            </div>
        </div>
        <p class="section-desc dosen-section-desc">Seluruh dosen aktif Jurusan Teknik Elektro dan Komputer, Universitas Negeri Gorontalo.</p>
        
        <?php if (!empty($dosenData)): ?>
        <div class="dosen-grid">
            <?php foreach ($dosenData as $p): 
                $nama = trim($p['nama'] ?? '');
                $bidang = trim($p['bidang keahlian'] ?? '');
                $fotoUrl = trim($p['profil'] ?? '');
                $scholarUrl = trim($p['scholar'] ?? '');
                
                // Generate initials for fallback
                $parts = preg_split('/[\s,]+/', $nama, -1, PREG_SPLIT_NO_EMPTY);
                $parts = array_filter($parts, function($s) {
                    return !preg_match('/^[A-Z]\.?$/i', $s) && !preg_match('/^(ST|MT|S\.Pd|M\.Eng|Dr)$/i', $s);
                });
                $initials = '';
                $firstPart = array_values($parts)[0] ?? '';
                $secondPart = array_values($parts)[1] ?? '';
                if ($firstPart) $initials .= $firstPart[0];
                if ($secondPart) $initials .= $secondPart[0];
                $fbText = strtoupper($initials) ?: '—';
                
                // Build full image URL if relative
                $fullFotoUrl = '';
                if ($fotoUrl) {
                    if (strpos($fotoUrl, 'http') === 0 || strpos($fotoUrl, '//') === 0) {
                        $fullFotoUrl = $fotoUrl;
                    } else {
                        $fullFotoUrl = 'https://temp.ikad-developer.my.id' . $fotoUrl;
                    }
                }
                
                // Check if foto URL is valid and not empty
                $hasFoto = !empty($fullFotoUrl);
            ?>
            <div class="dosen-card">
                <div class="dosen-foto-wrap">
                    <?php if ($hasFoto): ?>
                    <img class="dosen-foto" src="<?php echo htmlspecialchars($fullFotoUrl); ?>" alt="<?php echo htmlspecialchars($nama); ?>" loading="lazy">
                    <?php else: ?>
                    <div class="dosen-foto-fallback"><?php echo $fbText; ?></div>
                    <?php endif; ?>
                </div>
                <div class="dosen-body">
                    <div class="dosen-nama"><?php echo htmlspecialchars($nama); ?></div>
                    <?php if ($bidang): ?>
                    <div class="dosen-bidang"><?php echo htmlspecialchars($bidang); ?></div>
                    <?php endif; ?>
                    <?php if ($scholarUrl): ?>
                    <a href="<?php echo htmlspecialchars($scholarUrl); ?>" target="_blank" rel="noopener" class="dosen-scholar" title="Google Scholar" aria-label="Google Scholar">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="currentColor">
                            <path d="M5.242 13.769L0 9.5 12 0l12 9.5-5.242 4.269C17.548 11.249 14.978 9.5 12 9.5c-2.977 0-5.548 1.748-6.758 4.269zM12 10a7 7 0 1 0 0 14 7 7 0 0 0 0-14z"/>
                        </svg>
                        Google Scholar
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="dosen-grid">
            <div class="dosen-card" style="padding:32px;color:var(--text-muted); text-align:center;">
                <p>Gagal memuat data tenaga pendidik.</p>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php include 'template/footer.php'; ?>
