<?php
// kurikulum.php — Halaman Kurikulum OBE S1 Teknik Elektro (#te-2025)
$pageTitle = 'Kurikulum OBE 2025 — Jurusan Teknik Elektro dan Komputer';
$currentPage = 'kurikulum';
$pageCss = ['assets/kurikulum.css'];
include 'template/header.php';
require_once 'template/functions.php';

// ---- FETCH KAPRODI ----
$kaprodi = getKaprodi('s1 teknik elektro');

// ---- FETCH MATA KULIAH DARI API ----
// Endpoint: https://temp.ikad-developer.my.id/elektro/kurikulum
// Response: array of paket kurikulum. Filter: S1 Teknik Elektro OBE 2025.
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
                if ($kodeProdi === 's1teknikelektro'
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
    // Biarkan $mkData kosong, fallback statik akan dipakai.
}

// ---- KELOMPOKKAN PER SEMESTER ----
// Struktur: $grouped[semester][konsentrasi] = [rows...]
$grouped = [];
foreach ($mkData as $mk) {
    $sem = (string)($mk['semester'] ?? '0');
    $kon = strtolower(trim($mk['konsentrasi'] ?? ''));
    if ($kon === '') $kon = 'umum';
    $grouped[$sem][$kon][] = $mk;
}
ksort($grouped, SORT_NATURAL);

// Label semester 1..8 (jika 0 → "Pilihan")
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

// Konsentrasi yang tampil untuk semester 5/6
$konsentrasiLabels = [
    'ttl' => 'Konsentrasi TTL — Teknik Tenaga Listrik',
    'tet' => 'Konsentrasi TET — Teknik Elektro Telekomunikasi',
    'umum' => null, // tidak perlu sub-judul
];
?>

<!-- page banner -->
<section class="page-banner">
    <div class="container">
        <div>
            <div class="breadcrumb"><a href="beranda">Beranda</a> &nbsp;&rsaquo;&nbsp; Kurikulum &nbsp;&rsaquo;&nbsp; Kurikulum OBE 2025</div>
            <h1>Kurikulum OBE 2025 &mdash; S1 Teknik Elektro</h1>
            <p class="lede">Kurikulum Outcome-Based Education Program Studi Sarjana Teknik Elektro, berbasis capaian pembelajaran lulusan dan berorientasi pada energi baru terbarukan.</p>
        </div>
        <div class="page-banner-meta">
            <strong>2025</strong>
            Tahun Kurikulum
        </div>
    </div>
</section>

<!-- SECTION KURIKULUM OBE TE -->
<section id="te-2025" class="prodi-section">
    <div class="container">
        <div class="section-head section-head-split">
            <div class="section-head-left">
                <div class="section-eyebrow">01 &mdash; Kurikulum OBE 2025</div>
            </div>
            <div class="section-head-right">
                <h2 class="section-title">S1 Teknik Elektro</h2>
            </div>
        </div>
        <p class="section-desc" style="margin-top:-32px;margin-bottom:48px;max-width:720px;">
            Kurikulum 2025 disusun berdasarkan <em>Outcome-Based Education</em> dengan menyederhanakan CPL dari 39 (SN DIKTI) menjadi 11 CPL sesuai rekomendasi Forum Pendidikan Tinggi Teknik Elektro Indonesia (Fortei), sehingga setiap CPL dapat diukur secara terstruktur.
        </p>

        <!-- VISI + PENGELOLA GRID 7/5 -->
        <div class="visi-kaprodi-grid">
            <div class="vk-col vk-col-visi">
                <h3 class="subsection-heading">Visi Keilmuan Program Studi</h3>
                <div class="kurikulum-visi-card">
                    <strong>"Mengembangkan Teknologi Bidang Elektro yang berorientasi pada Energi Baru Terbarukan Berbasis Potensi Kawasan."</strong>
                </div>
            </div>
            <?php if ($kaprodi): ?>
            <div class="vk-col vk-col-kaprodi">
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
            </div>
            <?php endif; ?>
        </div>

        <!-- TUJUAN PENDIDIKAN PROGRAM STUDI (TPPS) -->
        <h3 class="subsection-heading">Tujuan Pendidikan Program Studi (TPPS)</h3>
        <ol class="tpps-list">
            <li><strong>TPPS - 1:</strong> Menghasilkan lulusan yang mampu menerapkan ilmu dan teknologi untuk menyelesaikan permasalahan teknik elektro yang kreatif, inovatif, dan beretika, serta adaptif terhadap perkembangan teknologi global dan kebutuhan masyarakat lokal.</li>
            <li><strong>TPPS - 2:</strong> Menghasilkan lulusan yang memiliki jiwa kepemimpinan, etika dan berintegritas serta berjiwa entrepreneurship.</li>
        </ol>

        <!-- PROFIL LULUSAN -->
        <h3 class="subsection-heading">Profil Lulusan</h3>
        <div class="profil-lulusan-grid">
            <div class="profil-card">
                <div class="profil-card-num">PL-1</div>
                <h4>Engineering Science</h4>
                <p>Perekayasa atau profesional yang mampu menerapkan pengetahuan tentang prinsip-prinsip teknik elektro yang menjadi landasan praktik, serta mendefinisikan, menyelidiki, dan menganalisis masalah teknik elektro yang kompleks menggunakan data dan teknologi informasi yang sesuai.</p>
                <p class="profil-kerja"><em>Bidang Kerja:</em> Perekayasa, Perencana, Analis, Konsultan, Manajer, Pendidik, Entrepreneur</p>
            </div>
            <div class="profil-card">
                <div class="profil-card-num">PL-2</div>
                <h4>Engineering Design</h4>
                <p>Perekayasa atau profesional yang mampu merancang atau mengembangkan solusi untuk masalah teknik elektro yang kompleks dengan mempertimbangkan berbagai pandangan dan memperhatikan pandangan pemangku kepentingan, serta mengevaluasi hasil dan dampak dari kegiatan rekayasa yang dilakukan.</p>
            </div>
            <div class="profil-card">
                <div class="profil-card-num">PL-3</div>
                <h4>Soft Skill</h4>
                <p>Perekayasa atau profesional yang memiliki jiwa kepemimpinan yang baik, standar etika dan integritas yang tinggi, dan pembelajaran sepanjang hayat untuk mempertahankan keunggulan dalam inovasi.</p>
            </div>
            <div class="profil-card">
                <div class="profil-card-num">PL-4</div>
                <h4>Entrepreneur</h4>
                <p>Perekayasa atau profesional yang memiliki jiwa entrepreneur dan mampu mengembangkan potensi kawasan.</p>
            </div>
        </div>

        <!-- CAPAIAN PEMBELAJARAN LULUSAN (CPL) -->
        <h3 class="subsection-heading">Capaian Pembelajaran Lulusan (CPL)</h3>
        <p class="cpl-note">CPL Program Studi Teknik Elektro UNG mengacu pada CPL yang direkomendasikan oleh Forum Pendidikan Tinggi Teknik Elektro Indonesia (Fortei).</p>
        <div class="cpl-table-wrap">
            <table class="cpl-table">
                <thead>
                    <tr>
                        <th style="width:90px;">Kode</th>
                        <th>Uraian CPL</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td class="cpl-num">CPL-1</td><td class="cpl-desc">Kemampuan menerapkan pengetahuan matematika, ilmu pengetahuan alam dan/atau material, teknologi informasi dan keteknikan untuk mendapatkan pemahaman menyeluruh tentang prinsip-prinsip teknik elektro.</td></tr>
                    <tr><td class="cpl-num">CPL-2</td><td class="cpl-desc">Kemampuan mendesain komponen, sistem dan/atau proses teknik elektro untuk memenuhi kebutuhan yang diharapkan di dalam batasan-batasan realistis, misalnya hukum, ekonomi, lingkungan, sosial, politik, kesehatan dan keselamatan, keberlanjutan serta untuk mengenali dan/atau memanfaatkan potensi sumber daya lokal dan nasional dengan wawasan global.</td></tr>
                    <tr><td class="cpl-num">CPL-3</td><td class="cpl-desc">Kemampuan mendesain dan melaksanakan eksperimen laboratorium dan/atau lapangan serta menganalisis dan mengartikan data untuk memperkuat penilaian teknik elektro.</td></tr>
                    <tr><td class="cpl-num">CPL-4</td><td class="cpl-desc">Mengidentifikasi, merumuskan, menganalisis dan menyelesaikan permasalahan teknik elektro.</td></tr>
                    <tr><td class="cpl-num">CPL-5</td><td class="cpl-desc">Kemampuan menerapkan metode, keterampilan dan piranti teknik yang modern yang diperlukan untuk praktik teknik elektro.</td></tr>
                    <tr><td class="cpl-num">CPL-6</td><td class="cpl-desc">Kemampuan berkomunikasi secara efektif baik lisan maupun tulisan.</td></tr>
                    <tr><td class="cpl-num">CPL-7</td><td class="cpl-desc">Kemampuan merencanakan, menyelesaikan dan mengevaluasi tugas di dalam batasan-batasan yang ada.</td></tr>
                    <tr><td class="cpl-num">CPL-8</td><td class="cpl-desc">Kemampuan bekerja dalam tim lintas disiplin dan lintas budaya.</td></tr>
                    <tr><td class="cpl-num">CPL-9</td><td class="cpl-desc">Kemampuan untuk bertanggung jawab kepada masyarakat dan mematuhi etika profesi dalam menyelesaikan permasalahan teknik.</td></tr>
                    <tr><td class="cpl-num">CPL-10</td><td class="cpl-desc">Kemampuan memahami kebutuhan akan pembelajaran sepanjang hayat, termasuk akses terhadap pengetahuan terkait isu-isu kekinian yang relevan.</td></tr>
                    <tr><td class="cpl-num">CPL-11</td><td class="cpl-desc">Kemampuan inovasi dan mengembangkan potensi kawasan untuk kesejahteraan masyarakat.</td></tr>
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
                Total <?php echo count($mkData); ?> mata kuliah untuk Program Studi S1 Teknik Elektro.
            </p>
            <div class="sebaran-mk-accordion">
                <?php foreach ($semesterLabels as $semKey => $semLabel):
                    if (empty($grouped[$semKey])) continue;
                    $konsentrasiList = $grouped[$semKey];
                    // Total SKS semester
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
                            // Untuk semester 5 & 6 yang punya 2 konsentrasi → tampilkan sub-heading
                            if ($konLabel && count($konsentrasiList) > 1): ?>
                                <div style="padding:14px 22px 8px;background:var(--bg);font-size:11.5px;font-weight:700;color:var(--accent-dark);letter-spacing:.08em;text-transform:uppercase;border-bottom:1px solid var(--border);">
                                    <?php echo htmlspecialchars($konLabel); ?>
                                </div>
                            <?php endif; ?>
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
                    <strong style="color:var(--navy);">Catatan:</strong> Mata kuliah pilihan (Semester 0) dapat diambil pada Semester 7 sesuai kebutuhan konsentrasi.
                </p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<?php include 'template/footer.php'; ?>