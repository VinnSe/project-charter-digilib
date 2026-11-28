# Laporan Akhir Terintegrasi — DIGILIB

Mata kuliah: Testing dan Implementasi Sistem (MK35/SIF66026)
Kelompok: 4 — M. Dafit Irwansyah, Ade Henry Febrian, Fathan Al Mu'thi Arsyad,
M. Aovar Ahdan, Kelvin Septio
Objek: DIGILIB — Digital Library (Laravel)
Build: `v1-baseline` (`6e30775`) dan `v2-fixes` (`7819145`)
Tanggal: 28 November 2026
Status: selesai untuk submission; TTD dosen menyusul

Indeks seluruh bukti ada di `05-laporan/evidence-index.md`. Setiap angka di bawah
merujuk ke file di indeks tersebut.

## 1. Ringkasan eksekutif

DIGILIB diuji dari level integration, system, dan acceptance dengan total 13 test
dan 27 assertion per build. Eksekusi awal pada `v1-baseline` menghasilkan 8 dari
13 test lulus (61.5%) dengan 5 kegagalan. Eksekusi ulang memakai
suite yang sama pada `v2-fixes` menghasilkan 13 dari 13 lulus (100,0%). Tiga
defect Major yang ditemukan di v1 — pembatasan role, validasi stok, dan
penyelesaian transaksi — dinyatakan Closed setelah retest P13. Tidak ada test
yang berubah dari lulus menjadi gagal.

Keputusan akhir: **No-Go untuk rilis penuh → Conditional Go** untuk rilis
terbatas. Kelima syarat Conditional Go terpenuhi: defect tertutup, pass rate
minimal 95%, rollback diuji, UAT diterima, dan pelatihan tercatat. Rilis terbatas
dilaksanakan lewat pilot + mini paralel, bukan rilis produksi penuh. Tanda tangan
item 2–3 sudah lengkap; item 4–5 tersisa dosen dan tidak diklaim sudah ada.

Risiko residual yang masih terbuka: belum ada data produksi untuk mengukur
availability; code coverage tidak diukur karena Xdebug/PCOV tidak terpasang;
dan p95 baru terekam untuk v1 pada lingkungan lokal.

| Angka kunci | Nilai | Sumber |
|---|---|---|
| Test lulus v1 → v2 | 8/13 → 13/13 | `E-P9-PHPUnit.log`, `P13-v2/E-P13-v2-PHPUnit.log` |
| Pass rate v1 → v2 | 61.5% → 100.0% | `06-metrik/perbandingan-v1-v2.md` |
| Defect Major terbuka | 3 → 0 | `04-defect-log/defect-log.md` |
| UAT | 5 dari 5 diterima | `02-test-case/uat-form.md` |
| Go-live checklist | 10 dari 10 | `05-laporan/go-live-checklist.md` |
| Rollback | berhasil, baseline = setelah restore | `03-evidence/rollback-test.log` |
| Konversi data | 4 akun, 5 kategori, 6 buku, 0 duplikat | `03-evidence/data-conversion-verification.log` |

## 2. Test summary report

Objek dan versi: DIGILIB pada `v1-baseline` (`6e30775`) dan `v2-fixes`
(`7819145`). Lingkungan: PHPUnit 9.6.3, sqlite in-memory, dua worktree dengan
salinan `phpunit.pjbl.xml` identik. Label build dan commit diambil dari git saat
eksekusi, bukan ditulis manual.

Cakupan: 13 test yang memetakan 13 requirement — INT-01…INT-05 (integration),
SYS-01…SYS-05 (system), dan AC-01…AC-03 (acceptance). Requirement coverage
dinyatakan 100% dengan label eksplisit "requirement", bukan code coverage.
Tambahan P12 mengukur 20 request GET `/book`.

| Level | Test | v1 lulus | v2 lulus | Bukti |
|---|---|---|---|---|
| Integration | INT-01…INT-05 | 3 dari 5 | 5 dari 5 | `E-INT-01…05.json`, `P13-v1/`, `P13-v2/` |
| System | SYS-01…SYS-05 | 3 dari 5 | 5 dari 5 | `E-SYS-01…05.json`, `P13-v1/`, `P13-v2/` |
| Acceptance | AC-01…AC-03 | 2 dari 3 | 3 dari 3 | `E-AC-01…03.json`, `P13-v1/`, `P13-v2/` |
| Performa tambahan | P12-PERF | lulus | tidak dibandingkan | `E-P12-PERF.json` |

Ringkasan defect:

| ID | Ringkasan | Severity | Status v1 | Status v2 | Bukti penutupan |
|---|---|---|---|---|---|
| DEF-01 | Tidak ada pembatasan akses berdasarkan role | Major | Open | Closed | `P13-v2/E-SYS-02.json`, `E-SYS-03.json`, `E-AC-03.json` |
| DEF-02 | Buku stok habis tetap masuk keranjang | Major | Open | Closed | `P13-v2/E-INT-04.json` |
| DEF-03 | Selesai pinjam tidak mengubah status/session | Major | Open | Closed | `P13-v2/E-INT-05.json` |

## 3. Implementation report

Konversi data master: sebelum verifikasi, `digilib_v2` hanya memiliki 1 kategori
dan 2 buku. Data rekaan sesuai test plan dimuat lewat seeder/tinker, lalu
diverifikasi menjadi 4 akun, 5 kategori (Fiksi, Non-Fiksi, Teknologi, Sejarah,
Novel), dan 6 buku BK-001…BK-006 dengan 0 duplikat. Bukti:
`03-evidence/data-conversion-verification.log`.

Go-live checklist: 10 dari 10 item selesai.

| No | Item | Status | Bukti |
|---|---|---|---|
| 1 | Unit test lulus | Selesai | `E-P9-PHPUnit.log` |
| 2 | Integration test sesuai requirement | Selesai | `E-INT-01…05.json` |
| 3 | System test sesuai requirement | Selesai | `E-SYS-01…05.json` |
| 4 | Acceptance test diperlihatkan ke pemilik | Selesai | `E-AC-01…03.json`, `02-test-case/uat-form.md` |
| 5 | Tidak ada defect Major terbuka | Selesai | `04-defect-log/defect-log.md`, `P13-v2/` |
| 6 | Cakupan requirement 100% | Selesai | `01-test-plan/test-plan.md`, 13 bukti JSON |
| 7 | Backup database dan uji restore | Selesai | `03-evidence/rollback-test.log` |
| 8 | Rencana rollback diuji | Selesai | `03-evidence/rollback-test.log` |
| 9 | Konversi data master terverifikasi | Selesai | `03-evidence/data-conversion-verification.log` |
| 10 | Pelatihan admin dan anggota | Selesai* | `05-laporan/daftar-hadir-pelatihan.md` |

\* Selesai secara substantif; 5 dari 5 tanda tangan terpasang.

Rollback: backup `digilib_v2` dibuat (13.486 byte), database uji dibuat dari
backup, gangguan disimulasikan dengan mengubah `BK-002 stock` menjadi 99, lalu
database dipulihkan. Baseline dan kondisi setelah restore identik:
`books=2, users=4, borrows=2, detail_borrows=2, bk002_stock=5`. Bukti:
`03-evidence/rollback-test.log` dan `05-laporan/rollback-test-report.md`. Uji ini
pada database uji, bukan produksi.

Keputusan dan strategi rilis:

| Syarat Conditional Go | Status | Bukti |
|---|---|---|
| 1. Defect tertutup dan dibuktikan di v2 | Terpenuhi | `04-defect-log/defect-log.md`, `P13-v2/` |
| 2. Pass rate minimal 95% | Terpenuhi (100.0%) | `P13-v2/E-P13-v2-PHPUnit.log` |
| 3. Uji rollback sampai restore berhasil | Terpenuhi | `03-evidence/rollback-test.log` |
| 4. UAT ditandatangani pemilik aplikasi | Terpenuhi | `02-test-case/uat-form.md` |
| 5. Pelatihan selesai | Terpenuhi secara substantif | `05-laporan/daftar-hadir-pelatihan.md` |

Strategi: pilot pada satu fakultas dengan 3 pengguna selama 1 minggu, lalu mini
paralel 50% pengguna selama 1 minggu. Rilis penuh baru dipertimbangkan setelah
pilot dan mini paralel selesai tanpa defect Major baru.

Risiko residual:

| ID | Risiko | Status | Penanganan |
|---|---|---|---|
| R-1 | Tiga Major di v1 | Tertutup di v2 | retest P13 |
| R-2 | Rollback | Sudah diuji | log restore tersedia |
| R-3 | UAT dan pelatihan | Substansi selesai | 5 dari 5 TTD |
| R-4 | Belum ada data produksi | Terbuka | jangan klaim availability terukur |
| R-5 | Code coverage tidak diukur | Terbuka | pasang Xdebug/PCOV sebelum target 80% diverifikasi |

## 4. Quality evaluation

Model yang dipakai: ISO/IEC 25010 untuk karakteristik kualitas dan ISO/IEC 25040
untuk kerangka evaluasi. Penilaian berbasis bukti yang tersedia, bukan asumsi.

| Karakteristik ISO 25010 | Indikator di DIGILIB | Hasil | Status |
|---|---|---|---|
| Functional suitability | Requirement coverage | 100% (13/13) | Hijau |
| Functional suitability | Pass rate v2 | 100.0% | Hijau |
| Reliability | Defect Major terbuka | 0 | Hijau |
| Performance efficiency | Rata-rata `/book`, 10 request | 0,0362 s → 0,0373 s | Hijau |
| Performance efficiency | p95, 20 request | 0,0116 s (v1 saja) | Kuning |
| Security | Pelanggaran akses role | 3 → 0 | Hijau |
| Usability | UAT | 5 dari 5 diterima | Hijau |
| Maintainability | Defect density | 1,63 → 0,00 per KLOC | Hijau |
| Portability | Lingkungan uji | sqlite in-memory + XAMPP | Hijau |
| — | Code coverage | tidak diukur | Abu/terbuka |
| — | Availability | belum terukur | Abu/terbuka |

Perbandingan sebelum/sesudah:

| Indikator | v1 | v2 | Target | Bukti |
|---|---|---|---|---|
| Pass rate | 61.5% | 100.0% | ≥ 95% | `06-metrik/perbandingan-v1-v2.md` |
| Test gagal | 5 | 0 | 0 | `P13-v1/`, `P13-v2/` |
| Defect Major terbuka | 3 | 0 | ≤ 2 + workaround | `04-defect-log/defect-log.md` |
| Pelanggaran akses role | 3 | 0 | 0 | `P13-v2/E-SYS-02.json`, `E-SYS-03.json`, `E-AC-03.json` |
| Rata-rata `/book` | 0,0362 s | 0,0373 s | ≤ 2 s | `06-metrik/perbandingan-v1-v2.md` |
| Defect density | 1,63/KLOC | 0,00/KLOC | ≤ 4/KLOC | `06-metrik/perbandingan-v1-v2.md` |
| Code coverage | tidak diukur | tidak diukur | ≥ 80% | `06-metrik/perbandingan-v1-v2.md` |
| UAT pemilik | belum pada P13 | 5 dari 5 diterima | ≥ 4 dari 5 | `02-test-case/uat-form.md` |

Catatan: baris UAT pada `06-metrik/perbandingan-v1-v2.md` adalah snapshot P13 dan
masih menulis "belum". Status terbaru diambil dari `02-test-case/uat-form.md`.

Akar penyebab: dari 5 kegagalan di v1, 3 (60%) berasal dari pembatasan akses.
Analisis 5 Whys menunjukkan akar masalahnya adalah kriteria hak akses tidak
dimasukkan ke Definition of Done sejak awal — masalah proses, bukan sekadar
baris kode yang terlewat.

Bukti perbaikan:

| Defect | Perbaikan di `7819145` | Bukti retest |
|---|---|---|
| DEF-01 | `CheckRole`, alias `role`, route group `role:admin`, menu per role | `P13-v2/E-SYS-02.json`, `E-SYS-03.json`, `E-AC-03.json` |
| DEF-02 | Pemeriksaan `stock - being_borrowed <= 0` sebelum `addCart` | `P13-v2/E-INT-04.json` |
| DEF-03 | `status = 1` dan `session()->forget('code_borrow')` | `P13-v2/E-INT-05.json` |

## 5. Rekomendasi

Rekomendasi R-1…R-6 berasal dari `06-metrik/analisis-penyebab-dan-rekomendasi.md`.
Status di bawah diperbarui dengan bukti terbaru.

| ID | Rekomendasi | Pemilik | Target terukur | Status | Bukti |
|---|---|---|---|---|---|
| R-1 | Terapkan pembatasan role dan uji akses tiap rilis | Dafit + Fathan | 0 pelanggaran akses di v2 | Selesai | `P13-v2/E-SYS-02.json`, `E-SYS-03.json`, `E-AC-03.json` |
| R-2 | Validasi stok sebelum `addCart` | Dafit | INT-04 lulus di v2 | Selesai | `P13-v2/E-INT-04.json` |
| R-3 | Set status peminjaman dan hapus session saat selesai | Dafit | INT-05 lulus di v2 | Selesai | `P13-v2/E-INT-05.json` |
| R-4 | Uji rollback sebelum rilis terbatas | Aovar | restore berhasil, ada log | Selesai | `03-evidence/rollback-test.log` |
| R-5 | Isi UAT dan laksanakan pelatihan | Kelvin | 4 dari 5 penguji + daftar hadir | Selesai secara substantif | `02-test-case/uat-form.md`, `05-laporan/daftar-hadir-pelatihan.md` |
| R-6 | Tambahkan pengukuran p95 pada tiap rilis | Ade | p95 terekam di dashboard | Selesai untuk v1 | `03-evidence/E-P12-PERF.json` |

R-6 baru terekam untuk v1. Tidak ada pengukuran p95 lintas build, sehingga tidak
dipakai sebagai bukti perbandingan performa v1 vs v2.

## 6. Lessons learned

Format: Start — Stop — Continue.

**Start**
- Masukkan kriteria hak akses ke Definition of Done, bukan hanya ke kode route.
  Akar masalah ada di proses, bukan di baris middleware yang terlewat
  (`06-metrik/analisis-penyebab-dan-rekomendasi.md`).
- Rekam p95 setiap rilis, bukan hanya sekali pada P12 (`E-P12-PERF.json`).
- Simpan bukti JSON otomatis sebelum assertion, supaya status test selalu
  punya timestamp, build, commit, dan penguji (`P13-v1/`, `P13-v2/`).

**Stop**
- Stop menganggap test lulus tanpa bukti bertanggal; 5 kegagalan P9 baru
  terlihat jelas setelah evidence JSON dihasilkan (`E-P9-PHPUnit.log`).
- Stop menutup defect tanpa retest pada build berbeda; DEF-01…DEF-03 hanya
  ditutup setelah lulus di `7819145` (`04-defect-log/defect-log.md`).
- Stop menyamakan angka lokal dengan produksi; p95 0,0116 s diberi label
  sqlite/XAMPP, bukan klaim availability (`03-evidence/E-P12-PERF.json`).

**Continue**
- Jalankan suite yang sama di dua worktree dengan label build dari git; ini
  mencegah test diubah agar lebih mudah lulus
  (`05-laporan/regression-test-report.md`).
- Pertahankan defect log transparan, termasuk kegagalan v1
  (`04-defect-log/defect-log.md`).
- Lanjutkan peer review internal dan verifikasi konversi data sebelum rilis
  (`02-test-case/peer-review-form.md`,
  `03-evidence/data-conversion-verification.log`).

## 7. Lampiran

- `05-laporan/evidence-index.md` — indeks seluruh bukti beserta ID, lokasi,
  tanggal, pemilik, dan catatan build.
- `03-evidence/P13-screenshots/` — 8 screenshot visual sebelum/sesudah untuk
  DEF-01A, DEF-01B, DEF-02, dan DEF-03.
- `05-laporan/regression-test-report.md` — analisis regression P13.
- `05-laporan/go-live-checklist.md` — checklist 10 dari 10.
- `05-laporan/rollback-test-report.md` dan
  `03-evidence/data-conversion-verification.log` — bukti operasional.
- `PANDUAN-5-ITEM.md` — panduan kelima item Human; TTD dosen masih
  menyusul dan tidak diklaim sudah ada di laporan ini.
