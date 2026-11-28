# Rantai Bukti P13 — DIGILIB

Prinsip: requirement → test case → run → defect → perbaikan/commit → retest.
Setiap bukti JSON memuat ID, label build, commit, data uji, expected, actual,
status, penguji, dan waktu.

## DEF-01 — Tidak ada pembatasan akses berdasarkan role

1. **Requirement** — 0 pelanggaran akses lintas peran
   (`06-metrik/quality-checklist.md`; rekomendasi R-1 di
   `06-metrik/analisis-penyebab-dan-rekomendasi.md`).
2. **Test** — `SYS-02` (admin membuka `/borrow`), `SYS-03` (anggota membuka
   `/add-book`), `AC-03` (kriteria penerimaan akses admin).
3. **Run sebelum** — `03-evidence/E-P9-PHPUnit.log`,
   `03-evidence/E-SYS-02.json` (http=302), `03-evidence/E-SYS-03.json`
   (http=200), `03-evidence/E-AC-03.json` (http=200), dan
   `03-evidence/P13-v1/E-*.json` untuk ketiga ID dengan label `v1-baseline`.
4. **Defect** — `DEF-01`, Major, Open di v1 (`04-defect-log/defect-log.md`).
5. **Perbaikan** — commit `7819145`: `app/Http/Middleware/CheckRole.php`,
   `app/Http/Kernel.php`, `routes/web.php`, `app/Models/User.php`, dan
   komponen sidebar. Akar prosesnya adalah kriteria hak akses yang belum masuk
   Definition of Done (5 Whys di analisis P12).
6. **Retest** — `03-evidence/P13-v2/E-SYS-02.json`, `E-SYS-03.json`, dan
   `E-AC-03.json`, semuanya `lulus` dengan http=403 pada `v2-fixes`.
7. **Status** — Closed.

## DEF-02 — Buku dengan stok habis tetap bisa ditambahkan

1. **Requirement** — skenario negatif di `01-test-plan/test-plan.md` dan R-2.
2. **Test** — `INT-04`.
3. **Run sebelum** — `03-evidence/E-INT-04.json` (jumlah_detail=1, stok=1,
   sedang_dipinjam=1) dan `03-evidence/P13-v1/E-INT-04.json`.
4. **Defect** — `DEF-02`, Major, Open di v1.
5. **Perbaikan** — commit `7819145`, `BorrowController.php::addCart` menolak
   ketika `stock - being_borrowed <= 0`.
6. **Retest** — `03-evidence/P13-v2/E-INT-04.json`, `jumlah_detail=0`, `lulus`.
7. **Status** — Closed.

## DEF-03 — Penyelesaian transaksi belum benar

1. **Requirement** — transaksi selesai konsisten (quality checklist P10, R-3).
2. **Test** — `INT-05`.
3. **Run sebelum** — `03-evidence/E-INT-05.json` (`status="0"`,
   session masih ada) dan `03-evidence/P13-v1/E-INT-05.json`.
4. **Defect** — `DEF-03`, Major, Open di v1.
5. **Perbaikan** — commit `7819145`, `BorrowController.php::addBorrow`
   menetapkan `status=1` dan `session()->forget('code_borrow')`.
6. **Retest** — `03-evidence/P13-v2/E-INT-05.json`, `status="1"`, session
   terhapus, `lulus`.
7. **Status** — Closed.

## Regression tambahan

Delapan test yang lulus di v1 (`INT-01`, `INT-02`, `INT-03`, `SYS-01`,
`SYS-04`, `SYS-05`, `AC-01`, `AC-02`) tetap lulus di v2. Bukti:
`03-evidence/P13-v1/E-<ID>.json` dan `03-evidence/P13-v2/E-<ID>.json`.
Tidak ada test yang berubah dari lulus menjadi gagal.
