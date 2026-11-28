# Regression Test Report — P13 DIGILIB

Tanggal: 28 November 2026
Objek: DIGILIB — sistem peminjaman buku berbasis Laravel
Build dibandingkan: `v1-baseline` (`6e30775`) dan `v2-fixes` (`7819145`)
Bukti mentah: `03-evidence/P13-v1/` dan `03-evidence/P13-v2/`

## 1. Tujuan dan ruang lingkup

Membuktikan bahwa perbaikan pada `v2-fixes` menyelesaikan tiga defect dari P9
dan tidak menimbulkan regresi pada fitur yang sebelumnya lulus. Sesuai PDF
MK35 tahap 5 dan slide P13, luaran yang wajib ada: analisis dampak, pemilihan
suite regression, hasil retest dan regression, perbandingan v1–v2 pada metrik
yang sama, serta rantai keterlacakan bukti.

Suite yang dijalankan: 13 test P9 (INT-01…05, SYS-01…05, AC-01…03). Test
performa P12 sengaja tidak dimasukkan supaya kedua build menerima perlakuan
yang benar-benar identik dengan P9.

## 2. Lingkungan dan perintah eksekusi

| Item | Nilai |
|---|---|
| Worktree v1 | `D:/digilib-pjbl-v1` pada `6e30775` |
| Worktree v2 | `D:/digilib-pjbl-v2` pada `7819145` |
| PHPUnit | 9.6.3 |
| Database | sqlite `:memory:` + `RefreshDatabase` |
| Konfigurasi | `phpunit.pjbl.xml` (salinan identik di kedua worktree) |
| Filter | `test_(int|sys|ac)_` — hanya 13 test P9 |
| Label build | diambil dari `git describe --tags --always` di shell saat eksekusi |
| Commit bukti | diambil dari `git rev-parse --short HEAD` di shell saat eksekusi |

Perintah yang dijalankan di masing-masing worktree (-environment identik-):

```bash
PJBL_BUILD_LABEL="$(git describe --tags --always)" \
PJBL_COMMIT="$(git rev-parse --short HEAD)" \
PJBL_EVIDENCE_DIR="D:/digilib-pjbl/portofolio-digilib/03-evidence/P13-<v1|v2>" \
php vendor/bin/phpunit -c phpunit.pjbl.xml --filter 'test_(int|sys|ac)_' --testdox
```

Log mentah: `03-evidence/P13-v1/E-P13-v1-PHPUnit.log` dan
`03-evidence/P13-v2/E-P13-v2-PHPUnit.log`.

## 3. Analisis dampak perubahan

Sumber dampak: `git diff 6e30775 7819145` dan matriks modul pada
`01-test-plan/test-plan.md`.

| Perubahan di v2 | Bukti di repository | Modul langsung | Modul terdampak | Test yang dipilih |
|---|---|---|---|---|
| Pembatasan role: `CheckRole`, alias `role`, group `role:admin`, sidebar per role | `app/Http/Middleware/CheckRole.php`, `app/Http/Kernel.php`, `routes/web.php`, `app/Models/User.php`, `resources/views/components/sidebar.blade.php` | Autentikasi & role | Katalog, peminjaman, laporan | Retest SYS-02, SYS-03, AC-03; regression INT-01, SYS-01, SYS-04, SYS-05 |
| Validasi stok sebelum `addCart` | `app/Http/Controllers/BorrowController.php` | Peminjaman & keranjang | Katalog (`being_borrowed`), laporan | Retest INT-04; regression INT-02, INT-03, AC-02, SYS-01 |
| Status `1` dan hapus session saat `addBorrow` | `app/Http/Controllers/BorrowController.php` | Peminjaman | Laporan, session | Retest INT-05; regression INT-01, AC-01, SYS-01 |
| Migrasi `role`, hapus `price`, tambah `user_id` | `database/migrations/` | Skema basis data | Semua fixture test | `P9Data.php` memakai `Schema::hasColumn()`; test tidak diubah |

Tidak ada test yang dilemahkan. File test di kedua worktree memiliki SHA-256
yang identik:

| File | v1 | v2 | Hasil |
|---|---|---|---|
| `RecordsEvidence.php` | `9634c9f432e3e1f9…` | `9634c9f432e3e1f9…` | sama |
| `P9Data.php` | `30c534faf36344e7…` | `30c534faf36344e7…` | sama |
| `P9IntegrationTest.php` | `efacfac803cc083d…` | `efacfac803cc083d…` | sama |
| `P9SystemTest.php` | `3203debaefe7b10b…` | `3203debaefe7b10b…` | sama |
| `P9AcceptanceTest.php` | `728671887a9c9b0b…` | `728671887a9c9b0b…` | sama |

Karena `identical=true`, perbedaan hasil berasal dari kode
aplikasi, bukan dari perubahan test.

## 4. Strategi pemilihan suite

Dipilih **retest-all** untuk 13 test karena suitanya kecil dan ini adalah
pemeriksaan sebelum rilis. Di dalamnya dibedakan:

- **Retest / confirmation testing** — 5 test yang gagal di v1: `SYS-02`,
  `SYS-03`, `AC-03`, `INT-04`, `INT-05`. Tujuannya memastikan defect tertentu
  benar-benar hilang.
- **Regression testing** — 8 test yang lulus di v1: `INT-01`, `INT-02`,
  `INT-03`, `SYS-01`, `SYS-04`, `SYS-05`, `AC-01`, `AC-02`. Tujuannya memastikan
  perbaikan tidak merusak alur yang tadinya benar.

Prioritas berbasis risiko (penilaian tim QA, bukan data terukur):

| Area kegagalan | Dampak (1–5) | Probabilitas (1–5) | Skor | Prioritas |
|---|---|---|---|---|
| Akses / role | 5 | 4 | 20 | Tinggi |
| Validasi stok | 4 | 3 | 12 | Sedang |
| Status / session | 4 | 3 | 12 | Sedang |

Probabilitas akses/role dinaikkan karena P12 mencatat 3 dari 5 kegagalan (60%)
di area itu.

## 5. Hasil retest dan regression

Ket: `Retest` = test yang dulu gagal dan kini diverifikasi; `Regression` =
test yang dulu lulus dan dijalankan ulang.

| ID | Kategori | Actual v1 | Actual v2 | Bukti v1 | Bukti v2 |
|---|---|---|---|---|---|
| INT-01 | Regression | {"http":302,"lokasi":"http:\/\/localhost\/cart","kode_borrow":"28112026-Anggota Uji-1","status":"0"} | {"http":302,"lokasi":"http:\/\/localhost\/cart","kode_borrow":"28112026-Anggota Uji-1","status":"0"} | `03-evidence/P13-v1/E-INT-01.json` | `03-evidence/P13-v2/E-INT-01.json` |
| INT-02 | Regression | {"detail":1,"being_borrowed":1,"return_date":"2026-12-05 00:00:00"} | {"detail":1,"being_borrowed":1,"return_date":"2026-12-05 00:00:00"} | `03-evidence/P13-v1/E-INT-02.json` | `03-evidence/P13-v2/E-INT-02.json` |
| INT-03 | Regression | {"jumlah_detail_setelah_dua_kali_submit":1} | {"jumlah_detail_setelah_dua_kali_submit":1} | `03-evidence/P13-v1/E-INT-03.json` | `03-evidence/P13-v2/E-INT-03.json` |
| INT-04 | Retest (confirmation) | {"jumlah_detail":1,"stok":1,"sedang_dipinjam":1} | {"jumlah_detail":0,"stok":1,"sedang_dipinjam":1} | `03-evidence/P13-v1/E-INT-04.json` | `03-evidence/P13-v2/E-INT-04.json` |
| INT-05 | Retest (confirmation) | {"status":"0","session_code_borrow_masih_ada":true} | {"status":"1","session_code_borrow_masih_ada":false} | `03-evidence/P13-v1/E-INT-05.json` | `03-evidence/P13-v2/E-INT-05.json` |
| SYS-01 | Regression | {"http_report":200} | {"http_report":200} | `03-evidence/P13-v1/E-SYS-01.json` | `03-evidence/P13-v2/E-SYS-01.json` |
| SYS-02 | Retest (confirmation) | {"http":302} | {"http":403} | `03-evidence/P13-v1/E-SYS-02.json` | `03-evidence/P13-v2/E-SYS-02.json` |
| SYS-03 | Retest (confirmation) | {"http":200} | {"http":403} | `03-evidence/P13-v1/E-SYS-03.json` | `03-evidence/P13-v2/E-SYS-03.json` |
| SYS-04 | Regression | {"request":10,"rata_rata_detik":0.0362} | {"request":10,"rata_rata_detik":0.0373} | `03-evidence/P13-v1/E-SYS-04.json` | `03-evidence/P13-v2/E-SYS-04.json` |
| SYS-05 | Regression | {"ditemukan":["<form","name=\"code\"","name=\"return_date\"","<table","add-borrow"],"jumlah":5} | {"ditemukan":["<form","name=\"code\"","name=\"return_date\"","<table","add-borrow"],"jumlah":5} | `03-evidence/P13-v1/E-SYS-05.json` | `03-evidence/P13-v2/E-SYS-05.json` |
| AC-01 | Regression | http=302, transaksi=ada | http=302, transaksi=ada | `03-evidence/P13-v1/E-AC-01.json` | `03-evidence/P13-v2/E-AC-01.json` |
| AC-02 | Regression | muncul=ya, being_borrowed=1 | muncul=ya, being_borrowed=1 | `03-evidence/P13-v1/E-AC-02.json` | `03-evidence/P13-v2/E-AC-02.json` |
| AC-03 | Retest (confirmation) | http=200 | http=403 | `03-evidence/P13-v1/E-AC-03.json` | `03-evidence/P13-v2/E-AC-03.json` |

Ringkasan eksekusi:

| Build | Test | Assertion | Lulus | Gagal | Pass rate |
|---|---|---|---|---|---|
| `v1-baseline` (`6e30775`) | 13 | 27 | 8 | 5 | 61.5% |
| `v2-fixes` (`7819145`) | 13 | 27 | 13 | 0 | 100.0% |

Lima test yang berubah dari gagal menjadi lulus: INT-04, INT-05, SYS-02, SYS-03, AC-03.
Tidak ada test yang berubah dari lulus menjadi gagal, sehingga tidak ada
defect baru pada suite ini.

## 6. Perbandingan metrik v1 dan v2

| Metrik | Target | v1 | v2 | Status | Sumber |
|---|---|---|---|---|---|
| Pass rate | ≥ 95% | 61.5% (8/13) | 100.0% (13/13) | Terpenuhi | log P13-v1, log P13-v2 |
| Test gagal | 0 | 5 | 0 | Terpenuhi | log P13-v1, log P13-v2 |
| Defect Major terbuka | ≤ 2 + workaround | 3 | 0 | Terpenuhi | `04-defect-log/defect-log.md` |
| Pelanggaran akses role | 0 | 3 | 0 | Terpenuhi | `E-SYS-02`, `E-SYS-03`, `E-AC-03` di kedua build |
| Rata-rata `/book`, 10 request | ≤ 2 detik | 0.0362 detik | 0.0373 detik | Terpenuhi | `E-SYS-04.json` di kedua build |
| Defect density (metode sama) | ≤ 4 per KLOC | 1,63 per KLOC (3/1838 baris) | 0,00 per KLOC (0/2013 baris) | Terpenuhi | `git ls-tree` + `git show` pada `app/` |
| Code coverage | ≥ 80% | tidak diukur | tidak diukur | Belum terukur | Xdebug/PCOV tidak terpasang |
| UAT pemilik aplikasi | ≥ 4 dari 5 | belum diisi | belum diisi | Belum terukur | form UAT masih draft |

Detail selisih dan ancaman validitas ada di `06-metrik/perbandingan-v1-v2.md`.

Catatan koreksi: dashboard P12 sebelumnya menulis 1,49 per KLOC untuk v1 dengan
menyebut 2013 baris `app/`. Angka 2013 adalah jumlah baris **v2**. Hitung ulang
dengan metode yang sama di kedua ref git memberi 1838 baris untuk v1 dan 2013
baris untuk v2, sehingga defect density v1 = 1,63 per KLOC. Perbaikan ini
dicatat di dashboard P13 agar laporan akhir tidak bertentangan.

## 7. Rantai keterlacakan bukti

Ringkasan; versi lengkap ada di `03-evidence/rantai-bukti-p13.md`.

| Defect | Requirement | Test | Run sebelum | Perbaikan | Run sesudah | Status |
|---|---|---|---|---|---|---|
| DEF-01 | 0 pelanggaran akses (checklist P10, R-1) | SYS-02, SYS-03, AC-03 | `E-P9-PHPUnit.log`, `E-SYS-02.json`, `E-SYS-03.json`, `E-AC-03.json`, P13-v1 | `7819145` — `CheckRole.php`, `Kernel.php`, `routes/web.php`, `sidebar.blade.php` | P13-v2 `E-SYS-02.json`, `E-SYS-03.json`, `E-AC-03.json` | Closed |
| DEF-02 | Buku stok habis ditolak (skenario negatif test plan, R-2) | INT-04 | `E-P9-PHPUnit.log`, `E-INT-04.json`, P13-v1 | `7819145` — `BorrowController.php::addCart` | P13-v2 `E-INT-04.json` | Closed |
| DEF-03 | Transaksi selesai konsisten (checklist P10, R-3) | INT-05 | `E-P9-PHPUnit.log`, `E-INT-05.json`, P13-v1 | `7819145` — `BorrowController.php::addBorrow` | P13-v2 `E-INT-05.json` | Closed |

Setiap bukti memiliki ID, label build, commit, waktu, dan penguji. Rantai ini
dapat ditelusuri dari requirement di test plan/quality checklist sampai hasil
retest di P13 tanpa bertanya lagi.

## 8. Pemeriksaan bukti (audit ringkas)

Kriteria yang dipakai: 0 defect Major terbuka, pass rate minimal 95%, dan
0 pelanggaran akses lintas peran.

| Kriteria | Sampel bukti | Temuan |
|---|---|---|
| Retest defect tuntas | 5 bukti P13-v2 untuk INT-04, INT-05, SYS-02, SYS-03, AC-03 | Sesuai — kelima status `lulus` |
| Tidak ada regresi | 8 bukti P13-v2 untuk test yang dulu lulus | Sesuai — kedelapan status `lulus` |
| Perbandingan adil | label build, commit, checksum test, environment | Sesuai — berasal dari shell dan file identik |
| Log mentah tersimpan | `E-P13-v1-PHPUnit.log`, `E-P13-v2-PHPUnit.log` | Sesuai — 13 test dan 27 assertion tercatat |
| Screenshot visual sebelum/sesudah | tidak dibuat | Belum tersedia — eksekusi memakai sqlite in-memory; bukti yang diaudit adalah log dan JSON |
| Kinerja produksi | tidak tersedia | Tidak diklaim — semua angka lokal |

## 9. Kesimpulan dan kaitan dengan P14

Ketiga defect P9 (`DEF-01`, `DEF-02`, `DEF-03`) dinyatakan **Closed** setelah
retest lulus dan regression tidak menemukan efek samping. Pass rate naik dari
61.5% menjadi 100.0%, dan tidak ada defect baru.

Ini memenuhi syarat pertama dan kedua dari **Conditional Go** di
`05-laporan/implementation-readiness-report.md`. Tiga syarat lain masih terbuka:
uji rollback, UAT bertanda tangan pemilik, dan pelatihan admin/anggota.
Keputusan akhir tetap berada pada pemilik aplikasi dan dosen; P14 akan
mengintegrasikan bukti ini tanpa mengisi tanda tangan atas nama orang lain.
