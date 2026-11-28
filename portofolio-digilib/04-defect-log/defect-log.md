# Defect Log — DIGILIB

Build yang diuji: `v1-baseline` (`6e30775`).
Verifikasi perbaikan: `v2-fixes` (`7819145`) pada P13.

| ID | Ringkasan | Severity | Status di v1 | Status di v2 | Bukti v1 | Bukti v2 |
|---|---|---|---|---|---|---|
| DEF-01 | Tidak ada pembatasan akses berdasarkan role | Major | Open | Closed | `E-SYS-02.json`, `E-SYS-03.json`, `E-AC-03.json`, `P13-v1/` | `P13-v2/E-SYS-02.json`, `E-SYS-03.json`, `E-AC-03.json` |
| DEF-02 | Buku dengan stok habis tetap bisa ditambahkan ke keranjang | Major | Open | Closed | `E-INT-04.json`, `P13-v1/E-INT-04.json` | `P13-v2/E-INT-04.json` |
| DEF-03 | Selesai peminjaman tidak mengubah status dan tidak menghapus session | Major | Open | Closed | `E-INT-05.json`, `P13-v1/E-INT-05.json` | `P13-v2/E-INT-05.json` |

## DEF-01 — Pembatasan role belum ada

- Ditemukan oleh: SYS-02, SYS-03, AC-03
- Expected: admin ditolak di `/borrow` (403), anggota ditolak di `/add-book` (403)
- Actual di v1: admin dialihkan ke `/cart` (302), anggota mendapat halaman admin (200)
- Dampak: pengguna biasa bisa mengelola buku dan kategori
- Perbaikan di v2: `CheckRole`, alias `role`, route group `role:admin`, menu
  sidebar per role (commit `7819145`)
- Verifikasi P13: SYS-02 http=403, SYS-03 http=403, AC-03 http=403;
  ketiga test `lulus`
- Status: **Closed** — bukti `03-evidence/P13-v2/E-SYS-02.json`,
  `E-SYS-03.json`, `E-AC-03.json`

## DEF-02 — Validasi stok belum ada

- Ditemukan oleh: INT-04
- Expected: buku dengan `stock=1` dan `being_borrowed=1` ditolak
- Actual di v1: `jumlah_detail=1` — detail keranjang tetap bertambah
- Dampak: buku dapat dipinjam melebihi stok yang tersedia
- Perbaikan di v2: pemeriksaan `stock - being_borrowed <= 0` sebelum `addCart`
  pada `BorrowController.php` (commit `7819145`)
- Verifikasi P13: `jumlah_detail=0`, test `lulus`
- Status: **Closed** — bukti `03-evidence/P13-v2/E-INT-04.json`

## DEF-03 — Penyelesaian transaksi belum benar

- Ditemukan oleh: INT-05
- Expected: `status` menjadi `1` dan `code_borrow` dihapus dari session
- Actual di v1: `status="0"`, `session_code_borrow_masih_ada=true`
- Dampak: transaksi selesai tidak tercatat, session lama terbawa
- Perbaikan di v2: `status = 1` dan `session()->forget('code_borrow')` pada
  `BorrowController.php` (commit `7819145`)
- Verifikasi P13: `status="1"`, session terhapus, test `lulus`
- Status: **Closed** — bukti `03-evidence/P13-v2/E-INT-05.json`

## Tidak ada defect baru

Delapan test yang lulus di v1 tetap lulus di v2. Tidak ada test yang berubah
dari lulus menjadi gagal pada P13. Rincian ada di
`05-laporan/regression-test-report.md` dan `03-evidence/rantai-bukti-p13.md`.

Catatan: ketiga defect di atas tidak disembunyikan. Kegagalan di v1 justru
menjadi dasar pembuktian perbaikan di v2.
