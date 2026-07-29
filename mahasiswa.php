<?php
// mahasiswa.php — Halaman Mahasiswa Jurusan Teknik Elektro dan Komputer
// Endpoint API: /statistik-mahasiswa, /list-kegiatan-mahasiswa
$pageTitle = 'Mahasiswa — Jurusan Teknik Elektro dan Komputer';
$currentPage = 'mahasiswa';
$pageCss = ['assets/mahasiswa.css'];
include 'template/header.php';
?>

<!-- page banner -->
<section class="page-banner">
    <div class="container">
        <div>
            <div class="breadcrumb">
                <a href="beranda">Beranda</a> &nbsp;&rsaquo;&nbsp; Mahasiswa
            </div>
            <h1>Mahasiswa Jurusan Teknik Elektro &amp; Komputer</h1>
            <p class="lede">Statistik keaktifan mahasiswa per tahun ajaran dan dokumentasi kegiatan kemahasiswaan di lingkungan Jurusan Teknik Elektro dan Komputer.</p>
        </div>
        <div class="page-banner-meta">
            <strong id="mhs-total">—</strong>
            Entri Statistik
        </div>
    </div>
</section>

<!-- ============================================
     SECTION 1 — STATISTIK MAHASISWA
     ============================================ -->
<section id="mahasiswa">
    <div class="container">
        <div class="section-head section-head-split">
            <div class="section-head-left">
                <div class="section-eyebrow">Statistik</div>
            </div>
            <div class="section-head-right">
                <h2 class="section-title">Rekapitulasi Mahasiswa</h2>
            </div>
        </div>
        <p class="section-desc">
            Ringkasan jumlah mahasiswa baru, lulusan, dan prestasi kemahasiswaan (akademik &amp; non-akademik) yang dihimpun per tahun ajaran.
        </p>

        <!-- Stats row (4 angka) -->
        <div class="mhs-stats-row">
            <div class="mhs-stat">
                <span class="mhs-stat-label">Total Mahasiswa Baru</span>
                <span class="mhs-stat-value" id="mhs-stat-masuk">—</span>
            </div>
            <div class="mhs-stat">
                <span class="mhs-stat-label">Total Lulusan</span>
                <span class="mhs-stat-value" id="mhs-stat-lulus">—</span>
            </div>
            <div class="mhs-stat">
                <span class="mhs-stat-label">Tahun Aktif</span>
                <span class="mhs-stat-value" id="mhs-stat-years">—</span>
            </div>
            <div class="mhs-stat">
                <span class="mhs-stat-label">Rata-rata / Tahun</span>
                <span class="mhs-stat-value" id="mhs-stat-avg">—</span>
            </div>
        </div>

        <!-- Bar Chart: Mahasiswa Baru vs Lulusan per Tahun -->
        <div id="mhs-bar-card" class="mhs-chart-card" style="display:none;">
            <div class="mhs-chart-head">
                <div>
                    <h3 class="mhs-chart-title">Mahasiswa Baru &amp; Lulusan per Tahun</h3>
                    <p class="mhs-chart-sub">Perbandingan jumlah mahasiswa baru yang masuk dengan lulusan tiap tahun ajaran.</p>
                </div>
                <div class="mhs-chart-legend" aria-hidden="true">
                    <span class="mhs-legend-item"><span class="mhs-legend-dot masuk"></span>Mahasiswa Baru</span>
                    <span class="mhs-legend-item"><span class="mhs-legend-dot lulus"></span>Lulusan</span>
                </div>
            </div>
            <div class="mhs-chart-wrap">
                <canvas id="mhs-bar-chart" aria-label="Grafik batang mahasiswa baru dan lulusan per tahun" role="img"></canvas>
            </div>
        </div>

        <!-- Line Chart: Tren Prestasi Mahasiswa per Tahun -->
        <div id="mhs-chart-card" class="mhs-chart-card" style="display:none;">
            <div class="mhs-chart-head">
                <div>
                    <h3 class="mhs-chart-title">Tren Prestasi Mahasiswa per Tahun</h3>
                    <p class="mhs-chart-sub">Perkembangan jumlah prestasi akademik dan non-akademik yang dicatatkan mahasiswa tiap tahun ajaran.</p>
                </div>
                <div class="mhs-chart-legend" aria-hidden="true">
                    <span class="mhs-legend-item"><span class="mhs-legend-dot akademik"></span>Prestasi Akademik</span>
                    <span class="mhs-legend-item"><span class="mhs-legend-dot nonakademik"></span>Prestasi Non-Akademik</span>
                </div>
            </div>
            <div class="mhs-chart-wrap">
                <canvas id="mhs-line-chart" aria-label="Grafik garis tren prestasi mahasiswa per tahun" role="img"></canvas>
            </div>
        </div>

        <!-- Row: Tabel (kiri) + Donut (kanan) -->
        <div class="mhs-row">
            <!-- Tabel rekap per tahun (5 kolom saja) -->
            <div id="mhs-table-wrap" class="mhs-table-wrap" style="display:none;">
                <table class="mhs-table">
                    <thead>
                        <tr>
                            <th>Tahun</th>
                            <th>Mhs Baru</th>
                            <th>Lulusan</th>
                            <th>Pres. Akademik</th>
                            <th>Pres. Non-Akademik</th>
                        </tr>
                    </thead>
                    <tbody id="mhs-table-body"></tbody>
                </table>
            </div>

            <!-- Donut: Proporsi Mahasiswa Baru per Tahun -->
            <div id="mhs-donut-card" class="mhs-donut-card" style="display:none;">
                <div class="mhs-chart-head">
                    <div>
                        <h3 class="mhs-chart-title">Proporsi Mahasiswa Baru</h3>
                        <p class="mhs-chart-sub">Distribusi total mahasiswa baru yang masuk tiap tahun ajaran.</p>
                    </div>
                </div>
                <div class="mhs-donut-wrap">
                    <canvas id="mhs-donut-chart" aria-label="Donut chart proporsi mahasiswa baru per tahun" role="img"></canvas>
                </div>
                <div id="mhs-donut-list" class="mhs-donut-list"></div>
            </div>
        </div>

        <div id="mhs-loading" class="loading-state">
            <div class="spinner"></div>
            <p>Memuat data statistik mahasiswa...</p>
        </div>
        <div id="mhs-error" class="error-state" style="display:none;">
            <p>Gagal memuat data statistik mahasiswa. Coba lagi nanti.</p>
        </div>
    </div>
</section>

<!-- ============================================
     SECTION 2 — KEGIATAN MAHASISWA
     ============================================ -->
<section id="kegiatan">
    <div class="container">
        <div class="section-head section-head-split">
            <div class="section-head-left">
                <div class="section-eyebrow">Kegiatan</div>
            </div>
            <div class="section-head-right">
                <h2 class="section-title">Dokumentasi Kegiatan</h2>
            </div>
        </div>
        <p class="section-desc">
            Galeri foto kegiatan kemahasiswaan seperti Temu PA, PKKMB, penerimaan mahasiswa baru, serta sosialisasi sistem akademik.
        </p>

        <div id="kgt-loading" class="loading-state">
            <div class="spinner"></div>
            <p>Memuat data kegiatan mahasiswa...</p>
        </div>
        <div id="kgt-error" class="error-state" style="display:none;">
            <p>Gagal memuat data kegiatan. Coba lagi nanti.</p>
        </div>
        <div id="kgt-empty" class="empty-state" style="display:none;">
            <p>Belum ada dokumentasi kegiatan yang tersedia.</p>
        </div>

        <div id="kgt-grid" class="kegiatan-grid"></div>
    </div>
</section>

<!-- Modal: Album Kegiatan -->
<div id="album-modal" class="album-modal" role="dialog" aria-modal="true" aria-labelledby="album-title" aria-hidden="true">
    <div class="album-backdrop" data-modal-close></div>
    <div id="album-panel" class="album-panel" role="document">
        <header class="album-header">
            <div class="album-header-text">
                <span id="album-date" class="album-date"></span>
                <h3 id="album-title" class="album-title">Album</h3>
                <p id="album-count" class="album-count"></p>
            </div>
            <button type="button" class="album-close" data-modal-close aria-label="Tutup album">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </header>

        <div id="album-desc" class="album-desc"></div>

        <div id="album-loading" class="album-loading" style="display:flex;">
            <div class="album-spinner" aria-hidden="true"></div>
            <p>Memuat foto album...</p>
        </div>

        <div id="album-error" class="album-error" style="display:none;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <p>Gagal memuat album.</p>
            <p id="album-error-msg" style="font-size:12.5px; opacity:.8;"></p>
        </div>

        <div id="album-grid" class="album-grid"></div>
    </div>
</div>

<!-- Lightbox foto individual -->
<div id="lightbox" class="lightbox" role="dialog" aria-modal="true" aria-hidden="true">
    <button type="button" id="lightbox-close" class="lightbox-close" data-modal-close aria-label="Tutup foto">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
    </button>
    <button type="button" id="lightbox-prev" class="lightbox-nav lightbox-nav-prev" aria-label="Foto sebelumnya">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <polyline points="15 18 9 12 15 6"/>
        </svg>
    </button>
    <button type="button" id="lightbox-next" class="lightbox-nav lightbox-nav-next" aria-label="Foto selanjutnya">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <polyline points="9 18 15 12 9 6"/>
        </svg>
    </button>
    <figure class="lightbox-figure">
        <img id="lightbox-img" src="" alt="">
        <figcaption id="lightbox-caption"></figcaption>
    </figure>
</div>

<!-- Chart.js (CDN) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>

<script>
/* ============================================================
   Halaman Mahasiswa — load statistik + kegiatan
   ============================================================ */
(async function() {
    const API = 'https://temp.ikad-developer.my.id/elektro';
    const $ = (id) => document.getElementById(id);

    const escapeHtml = (s) => String(s ?? '').replace(/[&<>"']/g, c => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
    }[c]));

    // =====================================================
    // SECTION 1 — STATISTIK MAHASISWA
    // =====================================================
    const statMasuk = $('mhs-stat-masuk');
    const statLulus = $('mhs-stat-lulus');
    const statYears = $('mhs-stat-years');
    const statAvg   = $('mhs-stat-avg');
    const statTotal = $('mhs-total');
    const tblWrap   = $('mhs-table-wrap');
    const tblBody   = $('mhs-table-body');
    const stLoading = $('mhs-loading');
    const stError   = $('mhs-error');

    // Parse tanggal "07 September 2025" -> Date
    const parseTglID = (str) => {
        if (!str) return null;
        const bulan = {
            januari: 0, februari: 1, maret: 2, april: 3, mei: 4, juni: 5,
            juli: 6, agustus: 7, september: 8, oktober: 9, november: 10, desember: 11
        };
        const parts = String(str).trim().toLowerCase().split(/\s+/);
        if (parts.length !== 3) return null;
        const day = parseInt(parts[0], 10);
        const month = bulan[parts[1]];
        const year = parseInt(parts[2], 10);
        if (isNaN(day) || month === undefined || isNaN(year)) return null;
        return new Date(year, month, day);
    };

    // Format "07 September 2025" -> "07 Sep 2025"
    const fmtTglShort = (str) => {
        const d = parseTglID(str);
        if (!d) return str;
        return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
    };

    try {
        const res = await fetch(API + '/statistik-mahasiswa');
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        const data = await res.json();
        stLoading.style.display = 'none';

        if (!Array.isArray(data) || data.length === 0) {
            stError.style.display = 'block';
            statTotal.textContent = '0';
            return;
        }

        // Urutkan ascending tahun
        const items = [...data].sort((a, b) => (a.tahun || 0) - (b.tahun || 0));

        // Hitung statistik
        const totalMasuk = items.reduce((s, x) => s + (x['jumlah-masuk'] || 0), 0);
        const totalLulus = items.reduce((s, x) => s + (x['jumlah-lulus'] || 0), 0);
        const tahunSet = items.map(x => x.tahun).filter(y => Number.isFinite(y));
        const tahunMin = tahunSet.length ? Math.min(...tahunSet) : null;
        const tahunMax = tahunSet.length ? Math.max(...tahunSet) : null;
        const tahunUnik = new Set(tahunSet).size;
        const avg = tahunUnik > 0 ? Math.round(totalMasuk / tahunUnik) : 0;

        statTotal.textContent = items.length.toLocaleString('id-ID');
        statMasuk.textContent = totalMasuk.toLocaleString('id-ID');
        statLulus.textContent = totalLulus.toLocaleString('id-ID');
        statYears.textContent = (tahunMin !== null && tahunMax !== null)
            ? (tahunMin === tahunMax ? String(tahunMax) : `${tahunMin}–${tahunMax}`)
            : '—';
        statAvg.textContent = avg.toLocaleString('id-ID');

        // Render tabel (5 kolom saja: Tahun, Mhs Baru, Lulusan, Pres. Akademik, Pres. Non-Akademik)
        const rows = items.map(it => {
            const masuk  = it['jumlah-masuk'] || 0;
            const lulus  = it['jumlah-lulus'] || 0;
            const pa     = it['prestasi-akademik'] || 0;
            const pna    = it['prestasi-non-akademik'] || 0;
            const cls = (n) => n === 0 ? 'mhs-zero' : '';
            return `
                <tr>
                    <td>${escapeHtml(it.tahun)}</td>
                    <td class="${cls(masuk)}">${escapeHtml(masuk)}</td>
                    <td class="${cls(lulus)}">${escapeHtml(lulus)}</td>
                    <td class="${cls(pa)}">${escapeHtml(pa)}</td>
                    <td class="${cls(pna)}">${escapeHtml(pna)}</td>
                </tr>
            `;
        }).join('');
        tblBody.innerHTML = rows;
        tblWrap.style.display = 'block';

        // =====================================================
        // GRAFIK 1 — Bar chart: Mahasiswa Baru vs Lulusan per Tahun
        // =====================================================
        if (typeof Chart === 'undefined') return;

        const styles = getComputedStyle(document.documentElement);
        const navy       = styles.getPropertyValue('--navy').trim() || '#1E3A8A';
        const navyLight  = styles.getPropertyValue('--navy-light').trim() || '#3B82F6';
        const accent     = styles.getPropertyValue('--accent').trim() || '#F97316';
        const accentDark = styles.getPropertyValue('--accent-dark').trim() || '#C2410C';
        const textMuted  = styles.getPropertyValue('--text-muted').trim() || '#555555';
        const border     = styles.getPropertyValue('--border').trim() || '#E5E7EB';

        // Helper: konversi "#RRGGBB" ke "rgba(...)" dengan alpha tertentu
        const hexToRgba = (hex, a) => {
            const v = hex.replace('#', '');
            const r = parseInt(v.substring(0, 2), 16);
            const g = parseInt(v.substring(2, 4), 16);
            const b = parseInt(v.substring(4, 6), 16);
            return `rgba(${r}, ${g}, ${b}, ${a})`;
        };

        const yearLabels = items.map(it => String(it.tahun));

        // === BAR CHART: Mhs Baru vs Lulusan ===
        const barCanvas = $('mhs-bar-chart');
        const barCard = $('mhs-bar-card');
        if (barCanvas) {
            new Chart(barCanvas, {
                type: 'bar',
                data: {
                    labels: yearLabels,
                    datasets: [
                        {
                            label: 'Mahasiswa Baru',
                            data: items.map(it => it['jumlah-masuk'] || 0),
                            backgroundColor: navy,
                            borderColor: navy,
                            borderWidth: 0,
                            borderRadius: 6,
                            maxBarThickness: 42
                        },
                        {
                            label: 'Lulusan',
                            data: items.map(it => it['jumlah-lulus'] || 0),
                            backgroundColor: accent,
                            borderColor: accent,
                            borderWidth: 0,
                            borderRadius: 6,
                            maxBarThickness: 42
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: { display: false }, // pakai custom chips
                        tooltip: {
                            backgroundColor: '#0F1E47',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            padding: 12,
                            cornerRadius: 8,
                            displayColors: true,
                            boxPadding: 4,
                            titleFont: { family: 'Inter, sans-serif', weight: '700', size: 13 },
                            bodyFont: { family: 'Inter, sans-serif', size: 13 },
                            callbacks: {
                                title: (ctx) => `Tahun ${ctx[0].label}`,
                                label: (ctx) => ` ${ctx.dataset.label}: ${ctx.parsed.y} mahasiswa`
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false, drawBorder: false },
                            ticks: {
                                color: textMuted,
                                font: { family: 'Inter, sans-serif', size: 12, weight: '600' }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: border, drawBorder: false },
                            ticks: {
                                color: textMuted,
                                font: { family: 'Inter, sans-serif', size: 12 },
                                stepSize: 25
                            }
                        }
                    }
                }
            });
            barCard.style.display = 'block';
        }

        // === LINE CHART ===
        const lineCanvas = $('mhs-line-chart');
        const lineCard = $('mhs-chart-card');
        if (lineCanvas) {
            new Chart(lineCanvas, {
                type: 'line',
                data: {
                    labels: yearLabels,
                    datasets: [
                        {
                            label: 'Prestasi Akademik',
                            data: items.map(it => it['prestasi-akademik'] || 0),
                            borderColor: navy,
                            backgroundColor: hexToRgba(navy, 0.08),
                            borderWidth: 3,
                            fill: true,
                            tension: 0.35,
                            pointRadius: 5,
                            pointHoverRadius: 7,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: navy,
                            pointBorderWidth: 2.5
                        },
                        {
                            label: 'Prestasi Non-Akademik',
                            data: items.map(it => it['prestasi-non-akademik'] || 0),
                            borderColor: accent,
                            backgroundColor: hexToRgba(accent, 0.10),
                            borderWidth: 3,
                            fill: true,
                            tension: 0.35,
                            pointRadius: 5,
                            pointHoverRadius: 7,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: accent,
                            pointBorderWidth: 2.5
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0F1E47',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            padding: 12,
                            cornerRadius: 8,
                            displayColors: true,
                            boxPadding: 4,
                            titleFont: { family: 'Inter, sans-serif', weight: '700', size: 13 },
                            bodyFont: { family: 'Inter, sans-serif', size: 13 },
                            callbacks: {
                                title: (ctx) => `Tahun ${ctx[0].label}`,
                                label: (ctx) => ` ${ctx.dataset.label}: ${ctx.parsed.y} prestasi`
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false, drawBorder: false },
                            ticks: {
                                color: textMuted,
                                font: { family: 'Inter, sans-serif', size: 12, weight: '600' }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: border, drawBorder: false },
                            ticks: {
                                color: textMuted,
                                font: { family: 'Inter, sans-serif', size: 12 },
                                precision: 0
                            }
                        }
                    }
                }
            });
            lineCard.style.display = 'block';
        }

        // =====================================================
        // GRAFIK 2 — Donut: Proporsi Mahasiswa Baru per Tahun
        // Hanya tampilkan tahun dengan jumlah-masuk > 0
        // =====================================================
        const donutCanvas = $('mhs-donut-chart');
        const donutCard = $('mhs-donut-card');
        const donutList = $('mhs-donut-list');
        if (donutCanvas) {
            const donutData = items
                .filter(it => (it['jumlah-masuk'] || 0) > 0)
                .map(it => ({
                    tahun: it.tahun,
                    masuk: it['jumlah-masuk']
                }));

            if (donutData.length === 0) {
                donutCard.style.display = 'none';
            } else {
                // Palet warna: variasi navy → accent (5 slot)
                const palette = [navy, navyLight, accent, accentDark, '#60A5FA'];
                const colors = donutData.map((_, i) => palette[i % palette.length]);

                const totalMasukAll = donutData.reduce((s, d) => s + d.masuk, 0);

                new Chart(donutCanvas, {
                    type: 'doughnut',
                    data: {
                        labels: donutData.map(d => String(d.tahun)),
                        datasets: [{
                            data: donutData.map(d => d.masuk),
                            backgroundColor: colors,
                            borderColor: '#fff',
                            borderWidth: 3,
                            hoverOffset: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '62%',
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#0F1E47',
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                padding: 12,
                                cornerRadius: 8,
                                displayColors: true,
                                boxPadding: 4,
                                titleFont: { family: 'Inter, sans-serif', weight: '700', size: 13 },
                                bodyFont: { family: 'Inter, sans-serif', size: 13 },
                                callbacks: {
                                    title: (ctx) => `Tahun ${ctx[0].label}`,
                                    label: (ctx) => {
                                        const v = ctx.parsed;
                                        const pct = totalMasukAll > 0
                                            ? ((v / totalMasukAll) * 100).toFixed(1)
                                            : 0;
                                        return ` ${v} mahasiswa (${pct}%)`;
                                    }
                                }
                            }
                        }
                    }
                });

                // Legend list custom di bawah chart
                donutList.innerHTML = donutData.map((d, i) => {
                    const pct = totalMasukAll > 0
                        ? ((d.masuk / totalMasukAll) * 100).toFixed(1)
                        : 0;
                    return `
                        <div class="mhs-donut-list-item">
                            <span class="mhs-donut-swatch" style="background:${colors[i]};"></span>
                            <span class="mhs-donut-year">${escapeHtml(d.tahun)}</span>
                            <span class="mhs-donut-val">${d.masuk}<span class="mhs-donut-pct">(${pct}%)</span></span>
                        </div>
                    `;
                }).join('');

                donutCard.style.display = 'block';
            }
        }

    } catch (err) {
        console.error('statistik fetch error:', err);
        stLoading.style.display = 'none';
        stError.style.display = 'block';
        stError.innerHTML = `<p>Gagal memuat data statistik mahasiswa.</p>
            <p style="margin-top:6px; font-size:12.5px; opacity:.8;">Detail: ${escapeHtml(err && err.message ? err.message : 'unknown error')}</p>`;
    }

    // =====================================================
    // SECTION 2 — KEGIATAN MAHASISWA
    // =====================================================
    const kgtGrid    = $('kgt-grid');
    const kgtLoading = $('kgt-loading');
    const kgtError   = $('kgt-error');
    const kgtEmpty   = $('kgt-empty');

    // Ikon kalender kecil untuk tanggal
    const calendarSvg = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
        <line x1="16" y1="2" x2="16" y2="6"></line>
        <line x1="8" y1="2" x2="8" y2="6"></line>
        <line x1="3" y1="10" x2="21" y2="10"></line>
    </svg>`;

    // Ikon panah luar
    const extSvg = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M14 3h7v7"/><path d="M10 14L21 3"/><path d="M21 14v7H3V3h7"/>
    </svg>`;

    // Ikon gallery (image stack)
    const imagesSvg = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <rect x="3" y="3" width="14" height="14" rx="2" ry="2"/>
        <circle cx="8.5" cy="8.5" r="1.5"/>
        <path d="M3 17l5-5 4 4 3-3 2 2"/>
        <path d="M17 5h2a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-2"/>
    </svg>`;

    try {
        const res = await fetch(API + '/list-kegiatan-mahasiswa');
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        const data = await res.json();
        kgtLoading.style.display = 'none';

        if (!Array.isArray(data) || data.length === 0) {
            kgtEmpty.style.display = 'block';
            return;
        }

        // Urutkan descending berdasarkan tanggal
        const items = [...data].sort((a, b) => {
            const da = parseTglID(a.tanggal);
            const db = parseTglID(b.tanggal);
            if (!da && !db) return 0;
            if (!da) return 1;
            if (!db) return -1;
            return db - da;
        });

        kgtGrid.innerHTML = items.map(it => {
            const foto = (it.lokasi || '').trim();
            const nama = (it.nama || '').trim();
            const tgl  = fmtTglShort(it.tanggal || '');
            const tag  = tgl && tgl !== it.tanggal ? tgl : (it.tanggal || '');
            const idFolder = (it.id_folder || '').trim();
            return `
                <article class="kegiatan-card${idFolder ? ' is-clickable' : ''}"
                         ${idFolder ? `role="button" tabindex="0" aria-label="Buka album ${escapeHtml(nama)}" data-album-trigger data-id="${escapeHtml(idFolder)}" data-nama="${escapeHtml(nama)}"` : ''}>
                    <div class="kegiatan-img-wrap">
                        <img src="${escapeHtml(foto)}" alt="${escapeHtml(nama)}" loading="lazy"
                             onerror="this.style.display='none';">
                        ${tag ? `<span class="kegiatan-tag">${escapeHtml(tag)}</span>` : ''}
                        ${idFolder ? `<div class="kegiatan-tooltip" aria-hidden="true">
                            <span class="kegiatan-tooltip-icon">${imagesSvg}</span>
                            <span>Klik untuk lihat album</span>
                        </div>` : ''}
                    </div>
                    <div class="kegiatan-body">
                        ${it.tanggal ? `<span class="kegiatan-date">${calendarSvg}${escapeHtml(it.tanggal)}</span>` : ''}
                        <h3 class="kegiatan-title">${escapeHtml(nama || 'Tanpa judul')}</h3>
                    </div>
                </article>
            `;
        }).join('');

        // Pasang event listener untuk album di seluruh card (klik + keyboard)
        kgtGrid.querySelectorAll('[data-album-trigger]').forEach(el => {
            const open = () => {
                const id = el.dataset.id;
                const nama = el.dataset.nama || 'Album';
                if (id) openAlbum(id, nama);
            };
            el.addEventListener('click', open);
            el.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    open();
                }
            });
        });

    } catch (err) {
        console.error('kegiatan fetch error:', err);
        kgtLoading.style.display = 'none';
        kgtError.style.display = 'block';
        kgtError.innerHTML = `<p>Gagal memuat data kegiatan.</p>
            <p style="margin-top:6px; font-size:12.5px; opacity:.8;">Detail: ${escapeHtml(err && err.message ? err.message : 'unknown error')}</p>`;
    }

    /* ============================================================
       Album kegiatan — modal + lightbox
       ============================================================ */
    const albumBackdrop = $('album-modal');
    const albumPanel    = $('album-panel');
    const albumTitleEl  = $('album-title');
    const albumDateEl   = $('album-date');
    const albumDescEl   = $('album-desc');
    const albumGridEl   = $('album-grid');
    const albumCountEl  = $('album-count');
    const albumSpinner  = $('album-loading');
    const albumErrEl    = $('album-error');
    const albumErrMsg   = $('album-error-msg');
    const lightbox      = $('lightbox');
    const lightboxImg   = $('lightbox-img');
    const lightboxCap   = $('lightbox-caption');
    const lightboxClose = $('lightbox-close');
    const lightboxPrev  = $('lightbox-prev') || null;
    const lightboxNext  = $('lightbox-next') || null;

    let lastFocused = null;
    let currentAlbum = null; // { nama, tanggal, file[] }
    let lightboxIndex = 0;

    function openModal(modalEl) {
        if (!modalEl) return;
        lastFocused = document.activeElement;
        modalEl.classList.add('is-open');
        modalEl.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        // Fokus ke tombol close (atau ke panel) untuk aksesibilitas
        const firstFocusable = modalEl.querySelector('[data-modal-close], button, [tabindex="0"]');
        if (firstFocusable) firstFocusable.focus({ preventScroll: true });
    }

    function closeModal(modalEl) {
        if (!modalEl) return;
        modalEl.classList.remove('is-open');
        modalEl.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
        if (lastFocused && typeof lastFocused.focus === 'function') {
            lastFocused.focus({ preventScroll: true });
        }
    }

    function showLightbox(src, caption, idx) {
        if (!lightbox) return;
        if (typeof idx === 'number') lightboxIndex = idx;
        lightboxImg.src = src;
        lightboxImg.alt = caption || '';
        lightboxCap.textContent = caption || '';
        updateLightboxNav();
        openModal(lightbox);
    }

    function updateLightboxNav() {
        if (!currentAlbum || !Array.isArray(currentAlbum.file)) return;
        const total = currentAlbum.file.length;
        const hasNav = total > 1;
        if (lightboxPrev) {
            lightboxPrev.style.display = hasNav ? 'inline-flex' : 'none';
            lightboxPrev.disabled = lightboxIndex <= 0;
        }
        if (lightboxNext) {
            lightboxNext.style.display = hasNav ? 'inline-flex' : 'none';
            lightboxNext.disabled = lightboxIndex >= total - 1;
        }
    }

    function lightboxGo(delta) {
        if (!currentAlbum || !Array.isArray(currentAlbum.file)) return;
        const total = currentAlbum.file.length;
        const nextIdx = lightboxIndex + delta;
        if (nextIdx < 0 || nextIdx >= total) return;
        const src = (currentAlbum.file[nextIdx].gambar || '').trim();
        if (!src) return;
        const nama = (currentAlbum.nama || 'Album').trim();
        lightboxIndex = nextIdx;
        lightboxImg.src = src;
        lightboxImg.alt = `${nama} - foto ${nextIdx + 1} dari ${total}`;
        lightboxCap.textContent = `${nama} — foto ${nextIdx + 1} dari ${total}`;
        updateLightboxNav();
    }

    function resetAlbum() {
        albumTitleEl.textContent = '';
        albumDateEl.textContent = '';
        albumDescEl.textContent = '';
        albumCountEl.textContent = '';
        albumGridEl.innerHTML = '';
        albumSpinner.style.display = 'flex';
        albumErrEl.style.display = 'none';
    }

    function renderAlbum(data) {
        currentAlbum = data;
        const file = Array.isArray(data.file) ? data.file : [];
        const nama = (data.nama || 'Album Kegiatan').trim();
        const tgl  = (data.tanggal || '').trim();
        const desc = (data.deskripsi || '').trim();

        albumTitleEl.textContent = nama;
        albumDateEl.textContent  = tgl;
        albumDescEl.textContent  = desc;

        // Bersihkan newline/tab berlebih
        const cleanDesc = desc.replace(/\s+/g, ' ').trim();
        albumDescEl.textContent = cleanDesc;

        if (file.length === 0) {
            albumCountEl.textContent = '0 foto';
            albumGridEl.innerHTML = `<div class="album-empty">Tidak ada foto pada album ini.</div>`;
            return;
        }

        albumCountEl.textContent = `${file.length} foto`;

        albumGridEl.innerHTML = file.map((f, idx) => {
            const src = (f.gambar || '').trim();
            if (!src) return '';
            const safeSrc = escapeHtml(src);
            return `
                <button class="album-thumb" type="button"
                        data-src="${safeSrc}" data-idx="${idx}"
                        aria-label="Buka foto ${idx + 1} dari ${file.length}">
                    <img src="${safeSrc}" alt="${escapeHtml(nama)} - foto ${idx + 1}" loading="lazy"
                         onerror="this.parentElement.classList.add('is-broken'); this.removeAttribute('src');">
                </button>
            `;
        }).join('');

        // Pasang listener untuk buka lightbox
        albumGridEl.querySelectorAll('.album-thumb').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const src = e.currentTarget.dataset.src;
                const idx = parseInt(e.currentTarget.dataset.idx, 10) || 0;
                const caption = `${nama} — foto ${idx + 1} dari ${file.length}`;
                showLightbox(src, caption, idx);
            });
        });
    }

    async function openAlbum(idFolder, fallbackNama) {
        resetAlbum();
        albumTitleEl.textContent = fallbackNama || 'Album';
        openModal(albumBackdrop);

        try {
            const res = await fetch(`${API}/detail-kegiatan-mahasiswa/${encodeURIComponent(idFolder)}`);
            if (!res.ok) throw new Error(`HTTP ${res.status}`);
            const data = await res.json();
            // Response sukses punya field 'nama' + 'file'; error response punya 'status' + 'Description'
            if (!data || !data.nama || !Array.isArray(data.file)) {
                throw new Error((data && data.Description) || 'Response tidak valid');
            }
            albumSpinner.style.display = 'none';
            renderAlbum(data);
        } catch (err) {
            console.error('album fetch error:', err);
            albumSpinner.style.display = 'none';
            albumErrEl.style.display = 'block';
            albumErrMsg.textContent = err && err.message ? err.message : 'Tidak diketahui';
        }
    }

    // Listener untuk tutup modal album (klik backdrop, X, ESC)
    // Catatan: click handler dipasang di PANEL, bukan backdrop, agar klik di
    // backdrop (e.target === backdrop) dan klik di tombol close (e.target.closest)
    // keduanya tertangani oleh satu listener.
    if (albumPanel) {
        albumPanel.addEventListener('click', (e) => {
            if (e.target === albumBackdrop || e.target.closest('[data-modal-close]')) {
                closeModal(albumBackdrop);
            }
        });
    }
    if (lightbox) {
        lightbox.addEventListener('click', (e) => {
            if (e.target === lightbox || e.target.closest('[data-modal-close]')) {
                closeModal(lightbox);
            }
        });
    }

    // Tombol nav prev/next di lightbox
    if (lightboxPrev) lightboxPrev.addEventListener('click', (e) => { e.stopPropagation(); lightboxGo(-1); });
    if (lightboxNext) lightboxNext.addEventListener('click', (e) => { e.stopPropagation(); lightboxGo(1); });

    // ESC close + panah kiri/kanan untuk navigasi di lightbox
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            if (lightbox && lightbox.classList.contains('is-open')) {
                closeModal(lightbox);
            } else if (albumBackdrop && albumBackdrop.classList.contains('is-open')) {
                closeModal(albumBackdrop);
            }
            return;
        }
        // Navigasi panah hanya saat lightbox terbuka
        if (lightbox && lightbox.classList.contains('is-open')) {
            if (e.key === 'ArrowLeft')  { e.preventDefault(); lightboxGo(-1); }
            if (e.key === 'ArrowRight') { e.preventDefault(); lightboxGo(1); }
        }
    });
})();
</script>

<?php include 'template/footer.php'; ?>