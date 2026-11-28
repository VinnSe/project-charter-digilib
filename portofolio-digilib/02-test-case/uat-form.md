# Form UAT — DIGILIB v2

Build yang diuji: `v2-fixes` (`7819145`)
Tujuan: konfirmasi dari pemilik aplikasi bahwa alur utama dapat diterima.
Status: **hasil eksekusi sudah ditranskrip dari bukti UAT; bagian Penutup masih kosong — menunggu pemilik aplikasi**.

Petunjuk: isi kolom **Hasil** dengan `Ya` atau `Tidak`. Kolom **Catatan** boleh
dikosongkan kalau tidak ada kendala. Minimal 4 dari 5 skenario berhasil agar
target UAT di `06-metrik/quality-checklist.md` terpenuhi. Jangan mengisi kolom
hasil atas nama pemilik aplikasi.

| ID | Skenario (Diberikan–Ketika–Maka) | Expected | Bukti pendamping | Hasil | Catatan |
|---|---|---|---|---|---|
| UAT-01 | Diberikan akun anggota demo, ketika login, maka dashboard menampilkan nama anggota | Login berhasil dan nama pemakai tampil | `E-INT-01.json`, `E-AC-01.json` | Ya |  |
| UAT-02 | Diberikan anggota sudah login, ketika membuka `/borrow`, maka transaksi dibuat dan diarahkan ke `/cart` | `/cart` terbuka dengan invoice transaksi | `E-INT-01.json`, `E-AC-01.json` | Ya |  |
| UAT-03 | Diberikan buku tersedia, ketika dipilih di `/cart` lalu disimpan, maka transaksi selesai | Status transaksi berubah dan session dibersihkan | `E-INT-05.json`, `P13-screenshots/E-RT-03-v2.png` | Ya | BK-001 stok 0, memakai BK-002 sesuai skenario buku tersedia. |
| UAT-04 | Diberikan transaksi selesai, ketika membuka `/report`, maka data tampil dengan status yang benar | Baris transaksi tampil tanpa tombol Detail aktif | `E-SYS-01.json`, `P13-screenshots/E-RT-03-v2.png` | Ya |  |
| UAT-05 | Diberikan akun anggota, ketika membuka `/add-book`, maka akses ditolak | Halaman 403, tidak ada form admin | `E-SYS-03.json`, `E-AC-03.json`, `P13-screenshots/E-RT-01B-v2.png` | Ya | Pesan 403 memuat typo "MENGASKSES"; akses tetap ditolak. |

Ringkasan UAT: 5 dari 5 skenario berhasil.

## Penutup

Nama pemilik aplikasi: ..................................................
Tanda tangan: ..........................................................
Tanggal: ...............................................................
Keputusan UAT: ................ (Diterima / Diterima dengan catatan / Ditolak)

Catatan: kolom di atas sengaja dikosongkan sampai diisi oleh pemilik aplikasi.
