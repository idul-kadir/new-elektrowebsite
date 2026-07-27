<?php
// kurikulum-obe-tk.php — Halaman Kurikulum OBE S1 Teknik Komputer
// Konten disalin verbatim dari https://elektro.ft.ung.ac.id/kurikulum-obe-tk
// (jangan improvisasi untuk website pendidikan).
$pageTitle = 'Kurikulum OBE (S1 - Teknik Komputer)';
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
    '0' => 'Matakuliah Pilihan',
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
            <div class="breadcrumb"><a href="beranda">Beranda</a> &nbsp;&rsaquo;&nbsp; Kurikulum &nbsp;&rsaquo;&nbsp; Teknik Komputer</div>
            <h1>Kurikulum OBE (S1 - Teknik Komputer)</h1>
            <p class="lede">Kurikulum OBE Program Studi S1 Teknik Komputer Fakultas Teknik Universitas Negeri Gorontalo.</p>
        </div>
        <div class="page-banner-meta">
            <strong>OBE</strong>
            Outcome-Based Education
        </div>
    </div>
</section>

<!-- SECTION KURIKULUM OBE TK -->
<section id="tk-obe" class="prodi-section">
    <div class="container">
        <div class="section-head section-head-split">
            <div class="section-head-left">
                <div class="section-eyebrow">01 &mdash; Kurikulum OBE</div>
            </div>
            <div class="section-head-right">
                <h2 class="section-title">S1 Teknik Komputer</h2>
            </div>
        </div>

        <!-- VISI + PENGELOLA GRID 8/4 -->
        <div class="visi-kaprodi-grid">
            <div class="vk-col vk-col-visi">
                <h3 class="subsection-heading">Visi Keilmuan Program Studi</h3>
                <div class="kurikulum-visi-card">
                    Mengembangkan Teknologi Sistem Komputer Berorientasi Sistem Tertanam Yang Berdampak Pada Kemajuan Kawasan.
                </div>
            </div>
            <?php if ($kaprodi): ?>
            <div class="vk-col vk-col-kaprodi">
                <h3 class="subsection-heading">Koordinator Program Studi</h3>
                <div class="kaprodi-card">
                    <div class="kpc-photo">
                        <img src="<?php echo htmlspecialchars($kaprodi['profil']); ?>"
                             alt="Foto <?php echo htmlspecialchars($kaprodi['kaprodi']); ?>"
                             onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                        <div class="kpc-initial" style="display:none;"><?php echo htmlspecialchars(getInitials($kaprodi['kaprodi'])); ?></div>
                    </div>
                    <div class="kpc-info">
                        <div class="kpc-label"><?php echo htmlspecialchars($kaprodi['keterangan'] ?? 'Ketua Program Studi S1 Teknik Komputer'); ?></div>
                        <div class="kpc-name"><?php echo htmlspecialchars($kaprodi['kaprodi']); ?></div>
                        <?php if (!empty($kaprodi['bidang'])): ?>
                        <div class="kpc-bidang"><em>Focus Riset : <?php echo htmlspecialchars($kaprodi['bidang']); ?></em></div>
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
            <li>Menghasilkan Lulusan Kompeten</li>
            <li>Memberikan Dampak Positif bagi Kawasan</li>
            <li>Menumbuhkan Budaya Riset dan Pengembangan</li>
            <li>Memfasilitasi Kolaborasi dengan Industri dan Pemerintah</li>
        </ol>

        <!-- PROFIL LULUSAN -->
        <h3 class="subsection-heading">Profil Lulusan</h3>
        <p class="kurikulum-narasi" style="margin-bottom:24px;">
            Profil Lulusan untuk Program Studi Teknik Komputer disusun dari 4 (empat) aspek yaitu Sikap (S), Pengetahuan (P), Keterampilan Umum (KU), dan Keterampilan Khusus (KK).
        </p>
        <div class="profil-lulusan-grid">
            <div class="profil-card">
                <div class="profil-card-num">PL01</div>
                <h4>Keterampilan Khusus (KK)</h4>
                <p>Lulusan memiliki kemampuan untuk melakukan perencanaan, implementasi dan pemeliharaan yang meliputi perangkat keras maupun perangkat lunak pada sistem komputasi modern yang melibatkan perangkat cerdas berbasis embedded systems.</p>
            </div>
            <div class="profil-card">
                <div class="profil-card-num">PL02</div>
                <h4>Penguasaan Pengetahuan (P)</h4>
                <p>Lulusan memiliki kemampuan untuk menerapkan konsep matematika, sains dasar dan mengimplementasikannya dalam bidang rekayasa yang berhubungan dengan sistem komputer, yang meliputi perangkat hardware maupun software.</p>
            </div>
            <div class="profil-card">
                <div class="profil-card-num">PL03</div>
                <h4>Sikap (S)</h4>
                <p>Perekayasa atau profesional yang memiliki jiwa kepemimpinan yang baik, standar etika dan integritas yang tinggi, dan pembelajaran sepanjang hayat untuk mempertahankan keunggulan dalam inovasi.</p>
            </div>
            <div class="profil-card">
                <div class="profil-card-num">PL04</div>
                <h4>Keterampilan Umum (KU)</h4>
                <p>Perekayasa atau profesional yang memiliki jiwa enterprenuer dan mampu mengembangkan potensi Kawasan.</p>
            </div>
        </div>

        <!-- CAPAIAN PEMBELAJARAN LULUSAN (CPL) -->
        <h3 class="subsection-heading">Capaian Pembelajaran Lulusan</h3>
        <div class="cpl-table-wrap">
            <table class="cpl-table">
                <thead>
                    <tr>
                        <th style="width:90px;">Kode CPL</th>
                        <th>Uraian CPL</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td class="cpl-num">CPL-1</td><td class="cpl-desc">Mampu menjelaskan dan menerapkan konsep-konsep bidang sistem komputer, matematika dan statistika serta sciences dasar untuk mengembangkan keterampilan berpikir analitis yang kuat melalui pembelajaran empiris dan eksperimen.</td></tr>
                    <tr><td class="cpl-num">CPL-2</td><td class="cpl-desc">Mampu menguasai dan menerapkan konsep &ndash; konsep bidang sistem komputer untuk menyelesaikan permasalahan pada dunia usaha dan dunia industri.</td></tr>
                    <tr><td class="cpl-num">CPL-3</td><td class="cpl-desc">Mampu menelaah dan menyelesaikan permasalahan di bidang dunia usaha dan industri yang meliputi system sensor, jaringan sensor maupun Internet of Things (IoT), embedded systems dan akuisisi data dengan pemodelan, prototype maupun melalui simulasi computer.</td></tr>
                    <tr><td class="cpl-num">CPL-4</td><td class="cpl-desc">Mampu menganalisis komputasi kompleks, merancang dan menerapkan inovasi perangkat sistem berbasis komputer yang meliputi system sensor, jaringan sensor maupun Internet of Things (IoT), embedded system dan akuisisi data untuk menghasilkan fungsi terbaru dengan kompleksitas yang lebih tinggi yang dibutuhkan oleh dunia usaha dan dunia industri.</td></tr>
                    <tr><td class="cpl-num">CPL-5</td><td class="cpl-desc">Mampu melakukan pemeliharaan dan pengujian sistem berbasis komputer yang memenuhi standar industri atau standar baku yang berlaku.</td></tr>
                    <tr><td class="cpl-num">CPL-6</td><td class="cpl-desc">Kemampuan berkomunikasi secara efektif baik lisan maupun tulisan.</td></tr>
                    <tr><td class="cpl-num">CPL-7</td><td class="cpl-desc">Kemampuan merencanakan, menyelesaikan dan mengevaluasi tugas di dalam batasan-batasan yang ada.</td></tr>
                    <tr><td class="cpl-num">CPL-8</td><td class="cpl-desc">Kemampuan bekerja dalam tim lintas disiplin dan lintas budaya.</td></tr>
                    <tr><td class="cpl-num">CPL-9</td><td class="cpl-desc">Kemampuan untuk bertanggung jawab kepada masyarakat dan mematuhi etika profesi dalam menyelesaikan permasalahan teknik.</td></tr>
                    <tr><td class="cpl-num">CPL-10</td><td class="cpl-desc">Kemampuan memahami kebutuhan akan pembelajaran sepanjang hayat, termasuk akses terhadap pengetahuan terkait isu-isu kekinian yang relevan.</td></tr>
                    <tr><td class="cpl-num">CPL-11</td><td class="cpl-desc">Kemampuan inovasi dan mengembangkan potensi potensi kawasan untuk kesejahteraan masyarakat.</td></tr>
                </tbody>
            </table>
        </div>

        <!-- NARASI KURIKULUM -->
        <h3 class="subsection-heading">Kurikulum</h3>
        <div class="kurikulum-narasi">
            <p>Kurikulum pada Program Studi S1 Teknik Komputer FT UNG sudah disesuaikan dengan:</p>
            <ul style="margin:0 0 20px 22px;color:var(--text);line-height:1.75;">
                <li>Kerangka Kualifikasi Nasional Indonesia (KKNI)</li>
                <li>Badan akreditasi Program Studi baik Nasional maupun Internasional</li>
            </ul>
            <p><strong>Implementasi MBKM (Permendikbud No 3 tahun 2020):</strong></p>
            <ul style="margin:0 0 20px 22px;color:var(--text);line-height:1.75;">
                <li>Mahasiswa diberi kebebasan untuk mengambil 3 (tiga) semester di prodi lain dalam perguruan tinggi sendiri (maksimal 20 SKS) atau paling lama 2 (dua) semester / maksimal 40 SKS di luar perguruan tinggi.</li>
                <li>Program MBKM yang diambil: Pertukaran antar PT, Magang, Studi Independen, dan Program Membangun Desa.</li>
                <li>Program Pertukaran: mahasiswa semester 3 dan semester 5.</li>
                <li>Program Magang/Studi Independen/Membangun Desa: mahasiswa semester 7.</li>
            </ul>
        </div>

        <!-- SEBARAN MATA KULIAH PER SEMESTER -->
        <h3 class="subsection-heading">Sebaran Mata Kuliah</h3>
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
                                        <th style="width:140px;">Kode MK</th>
                                        <th>Nama Mata Kuliah</th>
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
        <?php endif; ?>
    </div>
</section>

<?php include 'template/footer.php'; ?>