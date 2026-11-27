# Test Case — P9 DIGILIB

Build yang diuji: `v1-baseline` / commit `6e30775`.
Eksekusi: PHPUnit 9.6.3, sqlite `:memory:`, `RefreshDatabase`.
Log mentah: `03-evidence/E-P9-PHPUnit.log`.

| ID | Level | Skenario | Expected | Actual | Status | Bukti |
|---|---|---|---|---|---|---|
| INT-01 | Integration | Login lalu buka /borrow | redirect /cart, borrows bertambah dengan status 0, session code_borrow terisi | {"http":302,"lokasi":"http:\/\/localhost\/cart","kode_borrow":"27112026-Anggota Uji-1","status":"0"} | lulus | `03-evidence/E-INT-01.json` |
| INT-02 | Integration | Tambah BK-001 ke keranjang | detail_borrows +1, being_borrowed=1, return_date=H+7 | {"detail":1,"being_borrowed":1,"return_date":"2026-12-04 00:00:00"} | lulus | `03-evidence/E-INT-02.json` |
| INT-03 | Integration | Tambah buku yang sama dua kali | jumlah detail tetap 1 | {"jumlah_detail_setelah_dua_kali_submit":1} | lulus | `03-evidence/E-INT-03.json` |
| INT-04 | Integration | Tambah buku dengan stok habis | ditolak, tidak ada detail baru | {"jumlah_detail":1,"stok":1,"sedang_dipinjam":1} | gagal | `03-evidence/E-INT-04.json` |
| INT-05 | Integration | Selesaikan peminjaman via /add-borrow | status=1 dan session code_borrow dihapus | {"status":"0","session_code_borrow_masih_ada":true} | gagal | `03-evidence/E-INT-05.json` |
| SYS-01 | System | Alur lengkap sampai halaman /report | halaman /report dapat dibuka setelah alur peminjaman | {"http_report":200} | lulus | `03-evidence/E-SYS-01.json` |
| SYS-02 | System | Admin membuka /borrow | akses /borrow ditolak dengan 403 | {"http":302} | gagal | `03-evidence/E-SYS-02.json` |
| SYS-03 | System | Anggota membuka /add-book | akses /add-book ditolak dengan 403 | {"http":200} | gagal | `03-evidence/E-SYS-03.json` |
| SYS-04 | System | 10 request GET /book diukur waktunya | rata-rata maksimal 2 detik | {"request":10,"rata_rata_detik":0.0062} | lulus | `03-evidence/E-SYS-04.json` |
| SYS-05 | System | Kelengkapan 5 elemen halaman keranjang | minimal 4 dari 5 elemen antarmuka cart tersedia | {"ditemukan":["<form","name=\"code\"","name=\"return_date\"","<table","add-borrow"],"jumlah":5} | lulus | `03-evidence/E-SYS-05.json` |
| AC-01 | Acceptance | Anggota memulai peminjaman | Diberikan akun anggota, ketika membuka /borrow, maka transaksi dibuat dan diarahkan ke /cart | http=302, transaksi=ada | lulus | `03-evidence/E-AC-01.json` |
| AC-02 | Acceptance | Buku muncul di keranjang | Diberikan buku tersedia, ketika ditambah ke keranjang, maka muncul di /cart dan Dipinjam +1 | muncul=ya, being_borrowed=1 | lulus | `03-evidence/E-AC-02.json` |
| AC-03 | Acceptance | Anggota ditolak di halaman admin | Diberikan akun anggota, ketika membuka /add-book, maka ditolak dengan 403 | http=200 | gagal | `03-evidence/E-AC-03.json` |

Ringkasan: 13 test dijalankan, 8 lulus, 5 gagal, 27 assertion. Pass rate = 61.5%.
Rata-rata waktu respons SYS-04: 0.0062 detik (10 request, lingkungan lokal, bukan produksi).

Kegagalan dikelompokkan ke tiga defect di `04-defect-log/defect-log.md`.
