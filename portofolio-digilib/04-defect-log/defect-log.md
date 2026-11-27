# Defect Log — P9

Build yang diuji: `v1-baseline` (`6e30775`).

| ID | Ringkasan | Severity | Status di v1 | Bukti |
|---|---|---|---|---|
| DEF-01 | Tidak ada pembatasan akses berdasarkan role | Major | Open | `E-SYS-02.json`, `E-SYS-03.json`, `E-AC-03.json` |
| DEF-02 | Buku dengan stok habis tetap bisa ditambahkan ke keranjang | Major | Open | `E-INT-04.json` |
| DEF-03 | Selesai peminjaman tidak mengubah status dan tidak menghapus session | Major | Open | `E-INT-05.json` |

## DEF-01 — Pembatasan role belum ada

- Ditemukan oleh: SYS-02, SYS-03, AC-03
- Expected: admin ditolak di `/borrow` (403), anggota ditolak di `/add-book` (403)
- Actual: admin dialihkan ke `/cart` (302), anggota mendapat halaman admin (200)
- Dampak: pengguna biasa bisa mengelola buku dan kategori
- Perbaikan di v2: `CheckRole`, route group `role:admin`, menu sidebar per role (commit `f0c5930`)
- Rencana pembuktian: retest REG pada P13 dengan test yang sama

## DEF-02 — Validasi stok belum ada

- Ditemukan oleh: INT-04
- Expected: buku dengan `stock=1` dan `being_borrowed=1` ditolak
- Actual: detail keranjang tetap bertambah
- Dampak: buku dapat dipinjam melebihi stok yang tersedia
- Perbaikan di v2: pemeriksaan `stock - being_borrowed <= 0` sebelum `addCart`
- Rencana pembuktian: retest REG pada P13

## DEF-03 — Penyelesaian transaksi belum benar

- Ditemukan oleh: INT-05
- Expected: `status` menjadi `1` dan `code_borrow` dihapus dari session
- Actual: `status` tetap `0` dan session masih tersimpan
- Dampak: transaksi selesai tidak tercatat, session lama terbawa
- Perbaikan di v2: `status = 1` dan `session()->forget('code_borrow')`
- Rencana pembuktian: retest REG pada P13

Catatan: ketiga defect di atas tidak disembunyikan. Kegagalan di v1 justru
menjadi dasar pembuktian perbaikan di v2.
