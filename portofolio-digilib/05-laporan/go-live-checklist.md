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
| 6 | UAT disetujui pemilik aplikasi | `02-test-case/uat-form.md`, 5 dari 5 berhasil, Keputusan: Diterima, tanda tangan `03-evidence/tanda-tangan-uat-kelvin.jpeg` | Selesai |
| 7 | Backup database dan uji restore | `03-evidence/backup-digilib-v2-20261128.sql`, `03-evidence/rollback-test.log` | Selesai |
| 8 | Rencana rollback diuji | simulasi gangguan `BK-002 stock=99` dipulihkan ke `5`; baseline = setelah restore (`rollback-test.log`) | Selesai |
| 9 | Konversi data master terverifikasi | `03-evidence/data-conversion-verification.log`, 4 akun + 5 kategori + BK-001…BK-006, 0 duplikat | Selesai |
| 10 | Pelatihan admin dan anggota selesai | `05-laporan/daftar-hadir-pelatihan.md`, 5 peserta (1 admin, 4 anggota); 5 dari 5 TTD | Selesai* |

Ringkasan: 10 dari 10 item selesai. Semua item operasional go-live telah
terpenuhi; yang masih menyusul adalah TTD dosen pada item 4–5. Keputusan tetap **No-Go untuk rilis penuh → Conditional Go** karena rilis
terbatas baru dilakukan setelah pilot + mini paralel dan tanda tangan lengkap.
Panduan pengisian ada di `PANDUAN-5-ITEM.md` di root repository.

\* Item 10 selesai secara substantif: sesi pelatihan, materi, dan peserta sudah tercatat. 5 dari 5 tanda tangan terpasang. Status ini tidak mengklaim kelima peserta sudah menandatangani.

Strategi peralihan yang disepakati: pilot + mini paralel (lihat
`implementation-readiness-report.md` bagian 6).
