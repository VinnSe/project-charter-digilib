# Dashboard KPI — P12 DIGILIB

Build yang diukur: `v1-baseline` (`6e30775`).
Sumber angka: bukti P9 (`E-INT-*`, `E-SYS-*`, `E-AC-*`, `E-P9-PHPUnit.log`),
profil performa `E-P12-PERF.json`, quality checklist P10, dan defect log.

Status RAG: **Hijau** = target terpenuhi, **Kuning** = mendekati target atau
belum terukur, **Merah** = target tidak terpenuhi.

| No | Indikator | Target | Hasil | Status | ID bukti |
|---|---|---|---|---|---|
| 1 | Pass rate | ≥ 95% | 61,5% (8 dari 13) | Merah | E-P9-PHPUnit.log |
| 2 | Defect Critical + Major terbuka | 0 / maks. 2 | 3 Major | Merah | DEF-01…03 |
| 3 | DRE | ≥ 85% | 100% (provisional) | Kuning | 04-defect-log/defect-log.md |
| 4 | Defect density | ≤ 4 per KLOC | 1,49 per KLOC | Hijau | 2013 baris `app/` + 3 defect |
| 5 | Requirement coverage | 100% alur utama | 100% | Hijau | test-plan.md, test-case.md |
| 6 | Code coverage | ≥ 80% | tidak diukur | Kuning | Xdebug/PCOV absen |
| 7 | Waktu respons rata-rata `/book` | ≤ 2 detik | 0,0130 detik | Hijau | E-P12-PERF.json |
| 8 | Waktu respons p95 | ≤ 3 detik | 0,0116 detik | Hijau | E-P12-PERF.json |
| 9 | Availability / indikator keandalan | ≥ 99% | belum terukur | Kuning | tidak ada data MTTF/MTTR |
| 10 | Kepuasan UAT | ≥ 4 dari 5 | belum diisi | Kuning | form UAT draft |

Ringkasan: 4 Hijau, 2 Merah, 4 Kuning. Dua indikator Merah menjadi perhatian
utama: pass rate dan defect terbuka.

Catatan penting:

1. **DRE provisional.** E = 3 defect ditemukan sebelum rilis, D = 0 karena belum
   ada data defect pasca-rilis. DRE = 3 ÷ (3 + 0) = 100%, tetapi belum bermakna
   sebagai bukti kualitas rilis. Status sengaja Kuning.
2. **Code coverage tidak diukur.** Tidak ada Xdebug/PCOV di mesin ini. Yang
   dipakai adalah requirement coverage dan dinyatakan eksplisit.
3. **Dua angka waktu respons.** E-SYS-04 mencatat 0,0062 detik untuk 10 request
   saat P9. E-P12-PERF memakai 20 request dan menjadi angka acuan di dashboard:
   rata-rata 0,0130 detik, p95 0,0116 detik, maksimum 0,0907 detik. p95 lebih
   kecil dari rata-rata karena ada satu request lambat yang menaikkan rata-rata.
4. **Availability tidak diklaim.** Rumusnya `MTTF ÷ (MTTF + MTTR)`, tetapi data
   produksi tidak tersedia. Indikator ini dibiarkan belum terukur.

Semua angka di atas berasal dari lingkungan lokal dengan sqlite in-memory.
Tidak ada angka yang diklaim sebagai kinerja produksi.

## Cara menghitung

- Pass rate = lulus ÷ dieksekusi × 100% = 8 ÷ 13 × 100% = 61,5%
- DRE = E ÷ (E + D) = 3 ÷ (3 + 0) = 100% (provisional)
- Defect density = defect ÷ KLOC = 3 ÷ 2,013 = 1,49 per KLOC
- Requirement coverage = alur utama yang tercakup ÷ total alur utama = 100%
- p95 = nilai ke-19 dari 20 hasil pengukuran setelah diurutkan
