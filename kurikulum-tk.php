<?php
// kurikulum-tk.php — Halaman Kurikulum OBE 2025 S1 Teknik Komputer
$pageTitle = 'Kurikulum OBE 2025 — S1 Teknik Komputer';
$currentPage = 'kurikulum';
$pageCss = ['assets/kurikulum.css'];
include 'template/header.php';
require_once 'template/functions.php';

// ---- FETCH KAPRODI ----
$kaprodi = getKaprodi('s1 teknik komputer');

// ---- FETCH MATA KULIAH DARI API ----
$mkData = [];
$mkLoaded = false;
try {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://temp.ikad-developer.my.id/elektro/kurikulum');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200 && $response) {
        $all = json_decode($response, true);
        if (is_array($all)) {
            foreach ($all as $paket) {
                $kodeProdi = strtolower($paket['kode_prodi'] ?? '');
                $nama = strtolower($paket['nama'] ?? '');
                $tahun = (string)($paket['tahun'] ?? '');
                if ($kodeProdi === 's1teknikkomputer'
                    && $tahun === '2025'
                    && str_contains($nama, 'obe')) {
                    $mkData = $paket['matakuliah'] ?? [];
                    $mkLoaded = !empty($mkData);
                    break;
                }
            }
        }
    }
} catch (\Exception $e) {
    // Biarkan $mkData kosong.
}

// ---- KELOMPOKKAN PER SEMESTER ----
$grouped = [];
foreach ($mkData as $mk) {
    $sem = (string)($mk['semester'] ?? '0');
    $kon = strtolower(trim($mk['konsentrasi'] ?? ''));
    if ($kon === '') $kon = 'umum';
    $grouped[$sem][$kon][] = $mk;
}
ksort($grouped, SORT_NATURAL);

$semesterLabels = [
    '0' => 'Mata Kuliah Pilihan',
    '1' => 'Semester 1',
    '2' => 'Semester 2',
    '3' => 'Semester 3',
    '4' => 'Semester 4',
    '5' => 'Semester 5',
    '6' => 'Semester 6',
    '7' => 'Semester 7',
    '8' => 'Semester 8',
];

$konsentrasiLabels = [
    'umum' => null,
];
?>

<!-- page banner -->
<section class="page-banner">
    <div class="container">
        <div>
            <div class="breadcrumb"><a href="index.php">Beranda</a> &nbsp;&rsaquo;&nbsp; <a href="kurikulum.php">Kurikulum</a> &nbsp;&rsaquo;&nbsp; Teknik Komputer</div>
            <h1>Kurikulum OBE 2025 &mdash; S1 Teknik Komputer</h1>
            <p class="lede">Kurikulum Outcome-Based Education untuk program sarjana teknik komputer, berfokus pada sistem tertanam, jaringan, dan rekayasa perangkat lunak.</p>
        </div>
        <div class="page-banner-meta">
            <strong>2025</strong>
            Tahun Kurikulum
        </div>
    </div>
</section>

<!-- SECTION KURIKULUM OBE TK -->
<section id="tk-2025" class="prodi-section">
    <div class="container">
        <div class="section-head section-head-split">
            <div class="section-head-left">
                <div class="section-eyebrow">01 &mdash; Kurikulum OBE 2025</div>
            </div>
            <div class="section-head-right">
                <h2 class="section-title">S1 Teknik Komputer</h2>
            </div>
        </div>
        <p class="section-desc" style="margin-top:-32px;margin-bottom:48px;max-width:720px;">
            Kurikulum OBE 2025 yang menyiapkan lulusan sebagai insinyur komputer dengan keahlian di bidang <em>embedded systems</em>, jaringan, dan rekayasa perangkat lunak.
        </p>

        <!-- VISI KEILMUAN -->
        <h3 class="subsection-heading">Visi Keilmuan Program Studi</h3>
        <div class="kurikulum-visi-card">
            Menghasilkan lulusan sarjana teknik komputer yang <strong>profesional, berdaya saing global, dan berorientasi pada sistem tertanam</strong> melalui pendekatan pendidikan berbasis capaian (<em>Outcome-Based Education</em>).
        </div>

        <!-- PENGELOLA PROGRAM STUDI -->
        <?php if ($kaprodi): ?>
        <h3 class="subsection-heading">Pengelola Program Studi</h3>
        <div class="kaprodi-card">
            <div class="kpc-photo">
                <img src="<?php echo htmlspecialchars($kaprodi['profil']); ?>"
                     alt="Foto <?php echo htmlspecialchars($kaprodi['kaprodi']); ?>"
                     onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                <div class="kpc-initial" style="display:none;"><?php echo htmlspecialchars(getInitials($kaprodi['kaprodi'])); ?></div>
            </div>
            <div class="kpc-info">
                <div class="kpc-label"><?php echo htmlspecialchars($kaprodi['keterangan'] ?? 'Ketua Program Studi'); ?></div>
                <div class="kpc-name"><?php echo htmlspecialchars($kaprodi['kaprodi']); ?></div>
                <?php if (!empty($kaprodi['bidang'])): ?>
                <div class="kpc-bidang"><em><?php echo htmlspecialchars($kaprodi['bidang']); ?></em></div>
                <?php endif; ?>
                <?php if (!empty($kaprodi['scholar'])): ?>
                <a href="<?php echo htmlspecialchars($kaprodi['scholar']); ?>" target="_blank" rel="noopener" class="kpc-link">Google Scholar ↗</a>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- TUJUAN PENDIDIKAN PROGRAM STUDI (TPPS) -->
        <h3 class="subsection-heading">Tujuan Pendidikan Program Studi (TPPS)</h3>
        <ol class="tpps-list">
            <li>Menghasilkan lulusan yang memiliki integritas, profesional, dan mampu menerapkan etika rekayasa di bidang teknik komputer.</li>
            <li>Menguasai ilmu dasar, ilmu rekayasa, dan teknologi komputer (perangkat keras, perangkat lunak, jaringan) untuk pemecahan masalah nyata.</li>
            <li>Mampu merancang, menganalisis, dan mengimplementasikan sistem komputasi yang efisien, aman, dan berkelanjutan.</li>
            <li>Memiliki keterampilan komunikasi, kerja tim, dan kepemimpinan yang efektif di lingkungan multidisiplin.</li>
            <li>Memiliki kesadaran belajar sepanjang hayat dan kemampuan beradaptasi terhadap perkembangan teknologi.</li>
            <li>Berkontribusi aktif dalam penelitian terapan dan pengabdian kepada masyarakat di kawasan Indonesia Timur.</li>
        </ol>

        <!-- PROFIL LULUSAN -->
        <h3 class="subsection-heading">Profil Lulusan</h3>
        <div class="profil-lulusan-grid">
            <div class="profil-card">
                <div class="profil-card-num">PL-1</div>
                <h4>Embedded Systems Engineer</h4>
                <p>Merancang, memprogram, dan menguji sistem tertanam berbasis mikroprosesor, mikrokontroler, dan IoT.</p>
            </div>
            <div class="profil-card">
                <div class="profil-card-num">PL-2</div>
                <h4>Software Developer</h4>
                <p>Mengembangkan aplikasi desktop, web, bergerak, dan berbasis cloud dengan praktik rekayasa perangkat lunak modern.</p>
            </div>
            <div class="profil-card">
                <div class="profil-card-num">PL-3</div>
                <h4>Network &amp; System Administrator</h4>
                <p>Merancang, mengelola, dan mengamankan jaringan komputer dan sistem terdistribusi di berbagai skala organisasi.</p>
            </div>
            <div class="profil-card">
                <div class="profil-card-num">PL-4</div>
                <h4>Technopreneur Bidang Komputer</h4>
                <p>Membangun usaha berbasis teknologi komputer, khususnya solusi lokal untuk kawasan Indonesia Timur.</p>
            </div>
        </div>

        <!-- CAPAIAN PEMBELAJARAN LULUSAN (CPL) -->
        <h3 class="subsection-heading">Capaian Pembelajaran Lulusan (CPL)</h3>
        <div class="cpl-table-wrap">
            <table class="cpl-table">
                <thead>
                    <tr>
                        <th style="width:90px;">Kode</th>
                        <th>Deskripsi Capaian</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td class="cpl-num">CPL-1</td><td class="cpl-desc">Menunjukkan karakter religius, nasionalisme, dan integritas akademik sesuai Pancasila.</td></tr>
                    <tr><td class="cpl-num">CPL-2</td><td class="cpl-desc">Berkontribusi dalam peningkatan mutu kehidupan bermasyarakat, berbangsa, dan bernegara.</td></tr>
                    <tr><td class="cpl-num">CPL-3</td><td class="cpl-desc">Mampu bekerja sama, berkomunikasi efektif, dan beradaptasi dalam tim multidisiplin.</td></tr>
                    <tr><td class="cpl-num">CPL-4</td><td class="cpl-desc">Menguasai konsep matematika, sains, dan ilmu dasar rekayasa untuk menyelesaikan permasalahan komputer.</td></tr>
                    <tr><td class="cpl-num">CPL-5</td><td class="cpl-desc">Menguasai prinsip rekayasa perangkat keras, perangkat lunak, jaringan, dan komputasi modern.</td></tr>
                    <tr><td class="cpl-num">CPL-6</td><td class="cpl-desc">Mampu merancang sistem komputasi dengan memperhatikan aspek keselamatan, keamanan, dan keberlanjutan.</td></tr>
                    <tr><td class="cpl-num">CPL-7</td><td class="cpl-desc">Mampu menganalisis, memodelkan, dan menyelesaikan masalah rekayasa komputer berbasis data dan eksperimen.</td></tr>
                    <tr><td class="cpl-num">CPL-8</td><td class="cpl-desc">Mampu mengimplementasikan solusi teknologi pada sistem tertanam, jaringan, atau aplikasi perangkat lunak.</td></tr>
                    <tr><td class="cpl-num">CPL-9</td><td class="cpl-desc">Memiliki kesadaran belajar sepanjang hayat dan kemampuan mengikuti perkembangan IPTEK.</td></tr>
                    <tr><td class="cpl-num">CPL-10</td><td class="cpl-desc">Memiliki pemahaman terhadap isu kontemporer (energi, lingkungan, kemaritiman) dalam konteks rekayasa komputer.</td></tr>
                    <tr><td class="cpl-num">CPL-11</td><td class="cpl-desc">Memiliki jiwa kewirausahaan dan kemampuan mengelola proyek rekayasa sederhana.</td></tr>
                </tbody>
            </table>
        </div>

        <!-- SEBARAN MATA KULIAH PER SEMESTER -->
        <h3 class="subsection-heading">Sebaran Mata Kuliah per Semester</h3>
        <?php if (!$mkLoaded): ?>
            <p class="section-desc" style="color:var(--accent-dark);">
                Data mata kuliah gagal dimuat dari server. Silakan coba beberapa saat lagi.
            </p>
        <?php else: ?>
            <p class="section-desc" style="margin-bottom:24px;">
                Total <?php echo count($mkData); ?> mata kuliah untuk Program Studi S1 Teknik Komputer.
            </p>
            <div class="sebaran-mk-accordion">
                <?php foreach ($semesterLabels as $semKey => $semLabel):
                    if (empty($grouped[$semKey])) continue;
                    $konsentrasiList = $grouped[$semKey];
                    $totalSks = 0;
                    foreach ($konsentrasiList as $rows) {
                        foreach ($rows as $r) { $totalSks += (int)($r['sks'] ?? 0); }
                    }
                    $isFirst = $semKey === '1';
                ?>
                <details <?php echo $isFirst ? 'open' : ''; ?>>
                    <summary>
                        <div class="semester-info">
                            <span class="semester-label"><?php echo htmlspecialchars($semLabel); ?></span>
                        </div>
                        <span class="sks-total"><?php echo $totalSks; ?> SKS</span>
                    </summary>
                    <div>
                        <?php foreach ($konsentrasiList as $konKey => $rows):
                            $konLabel = $konsentrasiLabels[$konKey] ?? null;
                        ?>
                            <table class="mk-table">
                                <thead>
                                    <tr>
                                        <th style="width:140px;">Kode</th>
                                        <th>Mata Kuliah</th>
                                        <th style="width:90px;">Kategori</th>
                                        <th style="width:60px;">SKS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($rows as $r):
                                    $kode = $r['kode-matakuliah'] ?? '—';
                                    $nama = $r['nama-matakuliah'] ?? '(tanpa nama)';
                                    $sks = (int)($r['sks'] ?? 0);
                                    $kat = $r['deskripsi'] ?? '';
                                    $katLabel = $kat !== '' ? $kat : '—';
                                ?>
                                    <tr>
                                        <td class="mk-kode"><?php echo htmlspecialchars($kode); ?></td>
                                        <td><?php echo htmlspecialchars($nama); ?></td>
                                        <td style="font-size:12px;color:var(--text-muted);"><?php echo htmlspecialchars($katLabel); ?></td>
                                        <td class="mk-sks"><?php echo $sks; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endforeach; ?>
                    </div>
                </details>
                <?php endforeach; ?>
            </div>
            <?php if (!empty($grouped['0'])): ?>
                <p class="section-desc" style="margin-top:24px;font-size:13px;color:var(--text-muted);">
                    <strong style="color:var(--navy);">Catatan:</strong> Mata kuliah pilihan (Semester 0) dapat diambil pada Semester 7 sesuai kebutuhan peminatan.
                </p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<?php include 'template/footer.php'; ?>