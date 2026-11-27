# Go-Live Checklist — DIGILIB

Build yang dinilai: `v1-baseline` (`6e30775`).
Status per 27 November 2026.

| No | Item | Bukti / penjelasan | Status |
|---|---|---|---|
| 1 | Build v1 terverifikasi dan test suite dapat diulang | E-P9-PHPUnit.log, `phpunit.pjbl.xml` | Selesai |
| 2 | Quality checklist P10 terisi dari bukti | `06-metrik/quality-checklist.md` | Selesai |
| 3 | Defect Critical terbuka = 0 | `04-defect-log/defect-log.md` | Selesai |
| 4 | Defect Major terbuka ≤ 2 dengan workaround | 3 Major masih terbuka | Belum |
| 5 | Pass rate ≥ 95% | 61,5% (8 dari 13) | Belum |
| 6 | UAT disetujui pemilik aplikasi | form masih draft | Belum |
| 7 | Backup database dan uji restore | belum dijalankan | Belum |
| 8 | Rencana rollback diuji | belum dijalankan | Belum |
| 9 | Konversi data master terverifikasi | belum ada verifikasi | Belum |
| 10 | Pelatihan admin dan anggota selesai | belum ada daftar hadir | Belum |

Ringkasan: 3 dari 10 item selesai. Ini mendukung keputusan No-Go untuk rilis
penuh dan Conditional Go setelah tujuh item tersisa terpenuhi.

Strategi peralihan yang disepakati: pilot + mini paralel (lihat
`implementation-readiness-report.md` bagian 6).
