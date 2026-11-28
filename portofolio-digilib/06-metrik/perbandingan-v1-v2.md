# Perbandingan v1 vs v2 — P13 DIGILIB

Build: `v1-baseline` (`6e30775`) vs `v2-fixes` (`7819145`)
Sumber: bukti eksekusi `03-evidence/P13-v1/` dan `03-evidence/P13-v2/`
Lingkungan: sqlite `:memory:`, PHPUnit 9.6.3, 13 test yang sama, label build
diambil dari git di shell saat eksekusi.

## Tabel perbandingan

| Indikator                      | v1           | v2           | Selisih absolut | Selisih relatif  | Target           | RAG v2 |
|--------------------------------|--------------|--------------|-----------------|------------------|------------------|--------|
| Pass rate                      | 61.5%        | 100.0%       | +38.5 poin      | +62.5%           | ≥ 95%            | Hijau  |
| Test gagal                     | 5            | 0            | −5              | −100%            | 0                | Hijau  |
| Defect Major terbuka           | 3            | 0            | −3              | −100%            | ≤ 2 + workaround | Hijau  |
| Pelanggaran akses role         | 3            | 0            | −3              | −100%            | 0                | Hijau  |
| Rata-rata `/book` (10 request) | 0.0362 s     | 0.0373 s     | +0.0011 s       | +3.0%            | ≤ 2 s            | Hijau  |
| Defect density                 | 1,63/KLOC    | 0,00/KLOC    | −1,63/KLOC      | −100%            | ≤ 4/KLOC         | Hijau  |
| Code coverage                  | tidak diukur | tidak diukur | —               | —                | ≥ 80%            | Kuning |
| UAT pemilik                    | belum        | belum        | —               | —                | ≥ 4 dari 5       | Kuning |

Angka performa di atas berasal dari 10 request lokal pada sqlite in-memory.
Profil 20 request dengan p95 (`E-P12-PERF.json`) hanya tersedia untuk v1,
sehingga tidak dipakai sebagai perbandingan lintas build di tabel ini.

## Ancaman validitas dan mitigasi

| Ancaman                             | Mitigasi yang diterapkan                                                               | Bukti                                                    |
|-------------------------------------|----------------------------------------------------------------------------------------|----------------------------------------------------------|
| Sampel terlalu kecil                | Seluruh 13 test dijalankan, bukan sampel                                               | log P13-v1 dan P13-v2                                    |
| Lingkungan berubah antar pengukuran | Dua worktree pada commit berbeda, environment identik, salinan `phpunit.pjbl.xml` sama | `PJBL_BUILD_LABEL`, `PJBL_COMMIT`, evidence JSON         |
| Test diubah agar lebih mudah lulus  | SHA-256 file test identik di kedua worktree                                            | tabel checksum di `05-laporan/regression-test-report.md` |
| Defect baru tidak dilaporkan        | Semua 13 actual value disimpan; 0 test lulus→gagal                                     | bukti JSON kedua build                                   |
| Kinerja lokal diklaim produksi      | Angka diberi label sqlite in-memory, p95 tidak dibandingkan lintas build               | catatan tabel ini                                        |
| DRE 100% dianggap bermakna          | Tidak dipakai sebagai indikator rilis karena D = 0                                     | catatan dashboard P12                                    |

## RAG ringkas

Hijau: 6 indikator. Kuning: 2 indikator (code coverage dan UAT). Merah: 0.
Dua indikator Kuning bukan kegagalan regression; keduanya memang belum terukur
dan tetap dibiarkan terbuka sampai ada bukti nyata.
