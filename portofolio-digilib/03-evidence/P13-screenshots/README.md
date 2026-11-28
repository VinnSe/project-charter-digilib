# Screenshot Verifikasi P13 — DIGILIB

Tanggal pengambilan: 28 November 2026
Build: `v1-baseline` (`6e30775`) dan `v2-fixes` (`7819145`)
Lokasi: folder ini (`03-evidence/P13-screenshots/`)

Delapan file di bawah diambil dari aplikasi yang benar-benar berjalan di Chrome
desktop, bukan dari eksekusi PHPUnit. Address bar sengaja ikut terlihat supaya
URL dan build dapat diverifikasi. Database lokal terpisah: `digilib_v1` dan
`digilib_v2`; server `127.0.0.1:8001` dan `127.0.0.1:8002`.

| File | Defect | Build | URL | Akun | ID bukti | Keterangan |
|---|---|---|---|---|---|---|
| `E-RT-01A-v1.png` | DEF-01 / SYS-02 | `v1-baseline` | `127.0.0.1:8001/cart` | `admin@gmail.com` | `E-SYS-02.json` | Admin berhasil membuka `/borrow` dan masuk ke `/cart`, invoice `28112026-admin-1`. |
| `E-RT-01A-v2.png` | DEF-01 / SYS-02 | `v2-fixes` | `127.0.0.1:8002/borrow` | `admin@gmail.com` | `E-SYS-02.json` | Tab `Forbidden`, akses ditolak 403. |
| `E-RT-01B-v1.png` | DEF-01 / SYS-03, AC-03 | `v1-baseline` | `127.0.0.1:8001/add-book` | `student@gmail.com` | `E-SYS-03.json`, `E-AC-03.json` | Form "Tambah Buku" terbuka untuk anggota. |
| `E-RT-01B-v2.png` | DEF-01 / SYS-03, AC-03 | `v2-fixes` | `127.0.0.1:8002/add-book` | `student@gmail.com` | `E-SYS-03.json`, `E-AC-03.json` | Tab `Forbidden`, akses ditolak 403. |
| `E-RT-02-v1.png` | DEF-02 / INT-04 | `v1-baseline` | `127.0.0.1:8001/cart` | `student@gmail.com` | `E-INT-04.json` | BK-001 dengan `stock=1, being_borrowed=1` tetap masuk keranjang; `being_borrowed` naik menjadi 2. |
| `E-RT-02-v2.png` | DEF-02 / INT-04 | `v2-fixes` | `127.0.0.1:8002/cart?kode_buku=BK-001` | `student@gmail.com` | `E-INT-04.json` | Buku ditemukan, "Stok Tersedia" = 0, tombol "Ambil" disabled; buku tidak masuk keranjang. |
| `E-RT-03-v1.png` | DEF-03 / INT-05 | `v1-baseline` | `127.0.0.1:8001/report` | `student@gmail.com` | `E-INT-05.json` | Setelah `/add-borrow`, baris transaksi masih berstatus "Dipinjam" dan tombol Detail masih ada; kolom `status` di DB tetap `0`. |
| `E-RT-03-v2.png` | DEF-03 / INT-05 | `v2-fixes` | `127.0.0.1:8002/report` | `student@gmail.com` | `E-INT-05.json` | Baris transaksi ber-centang, tombol Detail hilang; kolom `status` di DB menjadi `1` dan session dihapus. |

## Catatan alur v1 vs v2

- Di **v1**, peminjaman wajib memasukkan **Kode Anggota** (`agt-1-rpl1-2005`)
  lewat tombol "Cek Anggota" sebelum memilih buku.
- Di **v2**, field Kode Anggota sudah dihapus sesuai perubahan kelompok. Akun
  yang login langsung dipakai (`Auth::id()` / `user_id`); pengguna bisa meminjam
  tanpa ID anggota. Ini terlihat di `E-RT-02-v2.png` dan `E-RT-03-v2.png`.

## Catatan pengambilan

- Semua gambar adalah PNG mentah, tidak diedit.
- SweetAlert "Peminjaman Berhasil!" di v2 hanya tampil sekitar 2 detik, sehingga
  screenshot final `E-RT-03-v2.png` mengambil kondisi stabil setelah alert
  hilang: status sudah ber-centang dan tombol Detail tidak ada.
- Screenshot tidak mengubah angka atau kesimpulan di laporan; bukti utama tetap
  file JSON dan log PHPUnit di folder `P13-v1/` dan `P13-v2/`.
- File JSON menyimpan `penguji` sesuai penulis test (`Dafit`/`Fathan`). Gambar
  ini diambil sebagai verifikasi P13 oleh agent, bukan atas nama anggota lain.
