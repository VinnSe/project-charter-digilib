# Go-Live Checklist — DIGILIB

Build yang dinilai: `v1-baseline` (`6e30775`).
Status per 27 November 2026.

| No | Item | Bukti / penjelasan | Status |
|---|---|---|---|
| 1 | Build v1 terverifikasi dan test suite dapat diulang | E-P9-PHPUnit.log, `phpunit.pjbl.xml` | Selesai |
| 2 | Quality checklist P10 terisi dari bukti | `06-metrik/quality-checklist.md` | Selesai |
| 3 | Defect Critical terbuka = 0 | `04-defect-log/defect-log.md` | Selesai |
| 4 | Defect Major terbuka ≤ 2 dengan workaround | 0 Major — DEF-01…03 Closed di `v2-fixes` (`04-defect-log/defect-log.md`, P13) | Selesai |
| 5 | Pass rate ≥ 95% | 100% (13 dari 13) di `v2-fixes` (`E-P13-v2-PHPUnit.log`) | Selesai |
| 6 | UAT disetujui pemilik aplikasi | hasil 5 dari 5 terisi di `02-test-case/uat-form.md`; Penutup/tanda tangan masih menunggu pemilik aplikasi | Belum |
| 7 | Backup database dan uji restore | belum dijalankan | Belum |
| 8 | Rencana rollback diuji | belum dijalankan | Belum |
| 9 | Konversi data master terverifikasi | belum ada verifikasi | Belum |
| 10 | Pelatihan admin dan anggota selesai | template kosong belum diisi (`05-laporan/daftar-hadir-pelatihan.md`) | Belum |

Ringkasan: 5 dari 10 item selesai setelah P13. Lima item tersisa: UAT, backup/restore, uji rollback, konversi data, dan pelatihan. Ini mendukung keputusan No-Go untuk rilis penuh dan Conditional Go setelah syarat-syarat tersebut terpenuhi. Panduan pengisian ada di `PANDUAN-5-ITEM.md` di root repository.

Strategi peralihan yang disepakati: pilot + mini paralel (lihat
`implementation-readiness-report.md` bagian 6).
