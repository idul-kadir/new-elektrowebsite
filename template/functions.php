<?php
// template/functions.php — Helper functions reusable across pages.

if (!function_exists('fetchKaprodiList')) {
    /**
     * Ambil daftar kaprodi dari endpoint API.
     * @return array List of { nama, keterangan, bidang, scholar, profil, key }
     *                key = slug prodi (lowercase), mis. "s1teknikelektro".
     */
    function fetchKaprodiList() {
        static $cache = null;
        if ($cache !== null) return $cache;

        $cache = [];
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://temp.ikad-developer.my.id/elektro/program-studi');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_TIMEOUT, 8);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 200 && $response) {
                $data = json_decode($response, true);
                if (is_array($data)) {
                    foreach ($data as $entry) {
                        if (!is_array($entry)) continue;
                        foreach ($entry as $namaProdi => $info) {
                            $key = strtolower($namaProdi);
                            // Normalisasi: "S1 Pendidikan Vokasional Rekayasa Elektro"
                            //   -> "s1pendidikanvokasionalrekayasaelektro"
                            $key = preg_replace('/\s+/', '', $key);

                            // Ambil inisial untuk fallback
                            preg_match_all('/\b([A-Z])/', $namaProdi, $m);
                            $initial = !empty($m[1]) ? strtoupper(implode('', array_slice($m[1], 0, 3))) : '??';

                            $cache[$key] = [
                                'nama_prodi'  => $namaProdi,
                                'kaprodi'     => $info['kaprodi'] ?? '—',
                                'keterangan'  => $info['keterangan'] ?? 'Ketua Program Studi',
                                'bidang'      => $info['bidang-keahlian'] ?? '',
                                'scholar'     => $info['scholar'] ?? '',
                                'profil'      => $info['profil'] ?? '',
                                'initial'     => $initial,
                                'loaded'      => true,
                            ];
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            // Biarkan cache kosong.
        }
        return $cache;
    }
}

if (!function_exists('getKaprodi')) {
    /**
     * Ambil satu data kaprodi berdasarkan slug prodi.
     * @param string $slug Key prodi (mis. 's1teknikelektro').
     * @return array|null Data kaprodi atau null jika tidak ditemukan.
     */
    function getKaprodi($slug) {
        $list = fetchKaprodiList();
        $key = preg_replace('/\s+/', '', strtolower($slug));
        return $list[$key] ?? null;
    }
}

if (!function_exists('getInitials')) {
    /**
     * Ambil inisial dari nama kaprodi (untuk avatar).
     */
    function getInitials($name) {
        $parts = explode(' ', trim($name));
        // Buang gelar (S.T., MT., Dr., S.Pd., M.Pd., dll)
        $gelar = ['dr.', 'dr', 'prof.', 'prof', 'st.', 'mt.', 'm.t.', 'spd.', 'm.pd.', 'm.kom.', 'ph.d', 'msi.', 'm.si.'];
        $parts = array_filter($parts, fn($p) => !in_array(strtolower(trim($p, '.')), $gelar) && strlen(trim($p)) > 0);
        // Ambil 2 kata pertama yang punya panjang >= 2
        $taken = [];
        foreach ($parts as $p) {
            $p = trim($p, '.');
            if (strlen($p) >= 2) {
                $taken[] = strtoupper(substr($p, 0, 1));
                if (count($taken) >= 2) break;
            }
        }
        return !empty($taken) ? implode('', $taken) : strtoupper(substr(trim($name), 0, 2));
    }
}