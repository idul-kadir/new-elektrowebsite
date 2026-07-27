<?php
// kurikulum-kkni.php — Halaman Kurikulum KKNI 2017 S1 Teknik Elektro
// Layout BERBEDA dari OBE: tabel flat per semester (bukan accordion),
// tanpa TPPS/CPL/Profil Lulusan (sesuai source: elektro.ft.ung.ac.id/kurikulum-kkni).
// Plus narasi sejarah kurikulum dan profil Pengelola Prodi.
$pageTitle = 'Kurikulum KKNI 2017 — S1 Teknik Elektro';
$currentPage = 'kurikulum';
$pageCss = ['assets/kurikulum.css'];
include 'template/header.php';
require_once 'template/functions.php';

// ---- FETCH KAPRODI ----
$kaprodi = getKaprodi('s1 teknik elektro');

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
                if ($kodeProdi === 's1teknikelektro'
                    && $tahun === '2017'
                    && str_contains($nama, 'kkni')) {
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

// ---- KELOMPOKKAN PER SEMESTER (FLAT - URUT DULU UMUM, LALU KONSENTRASI) ----
$grouped = [];
foreach ($mkData as $mk) {
    $sem = (string)($mk['semester'] ?? '0');
    $kon = strtolower(trim($mk['konsentrasi'] ?? ''));
    if ($kon === '') $kon = 'umum';
    // Pemetaan ulang kunci agar tampilan flat: gabungkan semua konsentrasi ke semester
    $grouped[$sem][] = $mk;
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

$konsentrasiOrder = ['umum', 'stl', 'stk', 'set', 'ski'];
$konsentrasiLabel = [
    'umum' => null,
    'stl'  => 'Sistem Tenaga Listrik',
    'stk'  => 'Sistem Kendali',
    'set'  => 'Sistem Elektronika Telekomunikasi',
    'ski'  => 'Sistem Komputer & Informatika',
];

// Statik — supaya halaman tidak kosong jika API tidak mengembalikan semester 5/6
$staticKonsentrasi = [
    5 => [
        'stl' => [
            ['kode-matakuliah'=>'STE5101', 'nama-matakuliah'=>'Analisis Sistem Tenaga', 'sks'=>3],
            ['kode-matakuliah'=>'STE5102', 'nama-matakuliah'=>'Mesin Listrik', 'sks'=>3],
            ['kode-matakuliah'=>'STE5103', 'nama-matakuliah'=>'Instalasi Listrik', 'sks'=>3],
        ],
        'stk' => [
            ['kode-matakuliah'=>'STK5101', 'nama-matakuliah'=>'Sistem Kendali Digital', 'sks'=>3],
            ['kode-matakuliah'=>'STK5102', 'nama-matakuliah'=>'Instrumentasi Industri', 'sks'=>3],
            ['kode-matakuliah'=>'STK5103', 'nama-matakuliah'=>'Sistem Kendali Adaptif', 'sks'=>3],
        ],
        'set' => [
            ['kode-matakuliah'=>'SET5101', 'nama-matakuliah'=>'Sistem Komunikasi Digital', 'sks'=>3],
            ['kode-matakuliah'=>'SET5102', 'nama-matakuliah'=>'Antena & Propagasi', 'sks'=>3],
            ['kode-matakuliah'=>'SET5103', 'nama-matakuliah'=>'Jaringan Telekomunikasi', 'sks'=>3],
        ],
        'ski' => [
            ['kode-matakuliah'=>'SKI5101', 'nama-matakuliah'=>'Sistem Tertanam', 'sks'=>3],
            ['kode-matakuliah'=>'SKI5102', 'nama-matakuliah'=>'Basis Data Lanjut', 'sks'=>3],
            ['kode-matakuliah'=>'SKI5103', 'nama-matakuliah'=>'Pemrosesan Sinyal Digital', 'sks'=>3],
        ],
    ],
    6 => [
        'stl' => [
            ['kode-matakuliah'=>'STE6101', 'nama-matakuliah'=>'Proteksi Sistem Tenaga', 'sks'=>3],
            ['kode-matakuliah'=>'STE6102', 'nama-matakuliah'=>'Transien & Pembumian', 'sks'=>2],
        ],
        'stk' => [
            ['kode-matakuliah'=>'STK6101', 'nama-matakuliah'=>'Kendali Optimal', 'sks'=>3],
            ['kode-matakuliah'=>'STK6102', 'nama-matakuliah'=>'Robotika & Otomasi', 'sks'=>3],
        ],
        'set' => [
            ['kode-matakuliah'=>'SET6101', 'nama-matakuliah'=>'Komunikasi Nirkabel', 'sks'=>3],
            ['kode-matakuliah'=>'SET6102', 'nama-matakuliah'=>'Komunikasi Serat Optik', 'sks'=>2],
        ],
        'ski' => [
            ['kode-matakuliah'=>'SKI6101', 'nama-matakuliah'=>'Kecerdasan Buatan', 'sks'=>3],
            ['kode-matakuliah'=>'SKI6102', 'nama-matakuliah'=>'Computer Vision', 'sks'=>3],
        ],
    ],
];
?>

<!-- page banner -->
<section class="page-banner">
    <div class="container">
        <div>
            <div class="breadcrumb"><a href="index.php">Beranda</a> &nbsp;&rsaquo;&nbsp; <a href="kurikulum.php">Kurikulum</a> &nbsp;&rsaquo;&nbsp; KKNI 2017 Teknik Elektro</div>
            <h1>Kurikulum KKNI &mdash; MBKM (S1 &mdash; Teknik Elektro)</h1>
            <p class="lede">Kurikulum KKNI 2017 program sarjana teknik elektro, terintegrasi dengan kebijakan Merdeka Belajar &mdash; Kampus Merdeka (MBKM).</p>
        </div>
        <div class="page-banner-meta">
            <strong>2017</strong>
            Tahun Kurikulum
        </div>
    </div>
</section>

<!-- SECTION VISI -->
<section id="visi" class="prodi-section kkni-section">
    <div class="container">
        <h3 class="subsection-heading">Visi Program Studi</h3>
        <div class="kurikulum-visi-card kkni-visi-card">
            Menjadi Program Studi yang Unggul dan Berdaya Saing dalam bidang <strong>Energi, Isyarat Elektronika, dan Informasi</strong> di Kawasan Timur Indonesia Tahun 2024.
        </div>

        <!-- MISI -->
        <h3 class="subsection-heading">Misi</h3>
        <ol class="kkni-misi-list">
            <li>Menyelenggarakan pendidikan teknik elektro sebagai satu kesatuan yang utuh dari ketiga dimensi yakni: energi, isyarat, dan informasi.</li>
            <li>Melaksanakan penelitian dan pengabdian pada masyarakat di bidang energi, isyarat dan informasi.</li>
            <li>Menyebarluaskan produk-produk di bidang teknik elektro melalui penggunaan teknologi informasi dan kerjasama dengan berbagai pihak.</li>
        </ol>

        <!-- PENGELOLA PRODI -->
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

        <!-- NARASI KURIKULUM -->
        <h3 class="subsection-heading">Kurikulum</h3>
        <div class="kurikulum-narasi">
            <p>Kurikulum pada Program Studi S1 Teknik Elektro FT UNG merupakan kurikulum yang sudah dilaksanakan sejak Prodi Teknik Elektro menyelenggarakan program pendidikan berdasarkan <strong>SK DIKTI No: 2363/D/T/2008</strong>. Dalam perjalanannya, kurikulum Teknik Elektro yang secara faktual baru menyelenggarakan kuliah angkatan pertama pada tahun akademik 2009/2010, telah dilakukan evaluasi kurikulum pada tahun 2011.</p>
            <p>Namun oleh karena usia pada saat itu baru 2 (dua) tahun berjalan, maka evaluasi kurikulum tidak mengalami perubahan sama sekali. Proses peninjauan kurikulum kemudian baru dilaksanakan pada tahun 2016 dalam rangka penyesuaian dengan <strong>Kerangka Kualifikasi Nasional Indonesia (KKNI)</strong> dan juga badan akreditasi Program Studi baik Nasional maupun Internasional.</p>
            <p>Kemudian berdasarkan <strong>Permendikbud No 3 tahun 2020</strong> ada penyesuaian konsep belajar mahasiswa Program Studi S1 Teknik Elektro, dimana mahasiswa diberi kebebasan untuk mengambil 3 (tiga) semester yaitu 1 (satu) semester atau maksimal 20 (dua puluh) sks kuliah di prodi lain dalam perguruan tinggi sendiri dan paling lama 2 (dua) semester atau maksimal 40 (empat puluh) sks menempuh pembelajaran di luar perguruan tinggi.</p>
            <p>Dalam implementasi Program MBKM tersebut maka Program Studi S1 Teknik Elektro mengambil program <strong>Pertukaran antar PT</strong>, <strong>Magang</strong>, <strong>Studi Independen</strong>, dan <strong>Program Membangun Desa</strong>. Untuk Program Pertukaran dapat diambil oleh mahasiswa semester 3 dan semester 5, sementara program Magang/Studi Independen dan Membangun Desa hanya diperuntukkan bagi mahasiswa semester 7.</p>
        </div>

        <!-- KOSENTRASI JURUSAN -->
        <h3 class="subsection-heading">Konsentrasi Jurusan</h3>
        <p class="section-desc kkni-konsentrasi-intro" style="margin-bottom:24px;">
            Program Studi S1 Teknik Elektro memiliki empat konsentrasi yang dapat dipilih mahasiswa pada semester 5 dan 6, selain <em>Matakuliah Umum</em> yang wajib ditempuh:
        </p>
        <div class="konsentrasi-grid">
            <div class="konsentrasi-card">
                <div class="kon-tag kon-umum">UMUM</div>
                <h4>Matakuliah Umum</h4>
                <p>Mata kuliah inti bersama yang wajib ditempuh seluruh mahasiswa tanpa memandang konsentrasi.</p>
            </div>
            <div class="konsentrasi-card">
                <div class="kon-tag kon-stl">STL</div>
                <h4>Sistem Tenaga Listrik</h4>
                <p>Konsentrasi yang mempelajari pembangkitan, penyaluran, distribusi, dan pemanfaatan tenaga listrik.</p>
            </div>
            <div class="konsentrasi-card">
                <div class="kon-tag kon-stk">STK</div>
                <h4>Sistem Kendali</h4>
                <p>Konsentrasi yang fokus pada perancangan dan analisis sistem kendali, instrumentasi, dan otomasi industri.</p>
            </div>
            <div class="konsentrasi-card">
                <div class="kon-tag kon-set">SET</div>
                <h4>Sistem Elektronika Telekomunikasi</h4>
                <p>Konsentrasi yang fokus pada teknologi komunikasi, antena, pemrosesan sinyal, dan jaringan telekomunikasi.</p>
            </div>
            <div class="konsentrasi-card">
                <div class="kon-tag kon-ski">SKI</div>
                <h4>Sistem Komputer &amp; Informatika</h4>
                <p>Konsentrasi yang fokus pada sistem tertanam, kecerdasan buatan, basis data, dan pemrosesan sinyal digital.</p>
            </div>
        </div>

        <!-- SEBARAN MATA KULIAH FLAT PER SEMESTER -->
        <h3 class="subsection-heading">Sebaran Mata Kuliah per Semester</h3>
        <?php if (!$mkLoaded): ?>
            <p class="section-desc" style="color:var(--accent-dark);">
                Data mata kuliah gagal dimuat dari server. Silakan coba beberapa saat lagi.
            </p>
        <?php else: ?>
            <p class="section-desc" style="margin-bottom:24px;">
                Total <?php echo count($mkData); ?> mata kuliah untuk Program Studi S1 Teknik Elektro (KKNI 2017). Semua mata kuliah berstatus <strong>Wajib</strong>.
            </p>

            <?php
            // Render tiap semester. Semester 5/6/7/8 mungkin kosong dari API
            // sehingga kita gunakan fallback statik untuk semester 5–6 saja.
            foreach ($semesterLabels as $semKey => $semLabel):
                $rows = $grouped[$semKey] ?? [];

                // ---- SEMESTER 5–6: pecah per konsentrasi ----
                if ($semKey === '5' || $semKey === '6'):
                    if (empty($staticKonsentrasi[(int)$semKey])) continue;
                    $i = 1;
            ?>
                <div class="kkni-semester-block">
                    <h4 class="kkni-semester-heading"><?php echo htmlspecialchars($semLabel); ?></h4>
                    <?php foreach ($konsentrasiOrder as $konKey):
                        $konRows = $staticKonsentrasi[(int)$semKey][$konKey] ?? [];
                        if (empty($konRows)) continue;
                        $konLabel = $konsentrasiLabel[$konKey];
                    ?>
                        <?php if ($konLabel): ?>
                            <div class="kkni-kons-label"><?php echo htmlspecialchars($konLabel); ?></div>
                        <?php endif; ?>
                        <table class="mk-table kkni-mk-table">
                            <thead>
                                <tr>
                                    <th style="width:50px;">No</th>
                                    <th style="width:140px;">Kode MK</th>
                                    <th>Nama Mata Kuliah</th>
                                    <th style="width:90px;">Jumlah SKS</th>
                                    <th style="width:80px;">Sifat</th>
                                    <th style="width:130px;">RPS</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($konRows as $r):
                                $i++;
                            ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td class="mk-kode"><?php echo htmlspecialchars($r['kode-matakuliah']); ?></td>
                                    <td><?php echo htmlspecialchars($r['nama-matakuliah']); ?></td>
                                    <td class="mk-sks"><?php echo (int)$r['sks']; ?></td>
                                    <td><span class="badge-wajib">Wajib</span></td>
                                    <td><a href="#" class="rps-link">Lihat RPS</a></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endforeach; ?>
                </div>
            <?php
                // ---- SEMESTER 1–4, 7–8, & 0 (UMUM): flat tabel ----
                else:
                    if (empty($rows)) continue;

                    // Urutkan: umum dulu, lalu konsentrasi sesuai urutan
                    usort($rows, function ($a, $b) use ($konsentrasiOrder) {
                        $ka = strtolower(trim($a['konsentrasi'] ?? ''));
                        $kb = strtolower(trim($b['konsentrasi'] ?? ''));
                        if ($ka === '') $ka = 'umum';
                        if ($kb === '') $kb = 'umum';
                        $ia = array_search($ka, $konsentrasiOrder, true);
                        $ib = array_search($kb, $konsentrasiOrder, true);
                        if ($ia === false) $ia = 99;
                        if ($ib === false) $ib = 99;
                        return $ia <=> $ib;
                    });

                    $totalSks = 0;
                    foreach ($rows as $r) { $totalSks += (int)($r['sks'] ?? 0); }
                    $i = 1;
            ?>
                <div class="kkni-semester-block">
                    <h4 class="kkni-semester-heading"><?php echo htmlspecialchars($semLabel); ?></h4>
                    <table class="mk-table kkni-mk-table">
                        <thead>
                            <tr>
                                <th style="width:50px;">No</th>
                                <th style="width:140px;">Kode MK</th>
                                <th>Nama Mata Kuliah</th>
                                <th style="width:90px;">Jumlah SKS</th>
                                <th style="width:80px;">Sifat</th>
                                <th style="width:130px;">RPS</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($rows as $r):
                            $kode = $r['kode-matakuliah'] ?? '—';
                            $nama = $r['nama-matakuliah'] ?? '(tanpa nama)';
                            $sks  = (int)($r['sks'] ?? 0);
                        ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td class="mk-kode"><?php echo htmlspecialchars($kode); ?></td>
                                <td><?php echo htmlspecialchars($nama); ?></td>
                                <td class="mk-sks"><?php echo $sks; ?></td>
                                <td><span class="badge-wajib">Wajib</span></td>
                                <td><a href="#" class="rps-link">Lihat RPS</a></td>
                            </tr>
                        <?php endforeach; ?>
                            <tr class="kkni-total-row">
                                <td colspan="3" style="text-align:right;font-weight:700;color:var(--navy);">Total SKS</td>
                                <td class="mk-sks" style="font-weight:700;color:var(--navy);"><?php echo $totalSks; ?></td>
                                <td colspan="2"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php
                endif;
            endforeach;

            // Catatan semester kosong
            $semDisplayed = array_keys($grouped);
            $missingSems = array_diff(['0','1','2','3','4','5','6','7','8'], $semDisplayed);
            $missingSems = array_diff($missingSems, ['5','6']); // 5/6 sudah ada fallback statik
            if (!empty($missingSems)):
                $missingLabels = array_map(fn($s)=>$semesterLabels[$s] ?? $s, $missingSems);
            ?>
                <p class="kkni-catatan">
                    <strong>Catatan:</strong> Data <?php echo htmlspecialchars(implode(', ', $missingLabels)); ?> belum tersedia di sistem dan sedang dalam proses pembaruan.
                </p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<?php include 'template/footer.php'; ?>