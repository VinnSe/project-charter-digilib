# Test Plan — P9 Pengujian Bertingkat

## Tujuan

Membuktikan modul DIGILIB bekerja dan saling terhubung pada alur utama, serta
menghasilkan bukti yang dapat diverifikasi dan diulang.

## Ruang lingkup

Alur utama: `login → /borrow → pilih buku → /cart → /add-borrow → /report`.

Lima modul yang terlibat: autentikasi & role, katalog buku & kategori,
peminjaman, keranjang, dan laporan.

## Level pengujian

| Level | Jumlah | Fokus |
|---|---|---|
| Integration | 5 | interaksi auth → borrow → cart → add-borrow |
| System | 5 | alur lengkap, negatif, keamanan, kinerja, usability |
| Acceptance | 3 | kriteria Diberikan–Ketika–Maka |

Skenario negatif yang diuji: admin membuka `/borrow`, anggota membuka
`/add-book`, buku duplikat, dan buku dengan stok habis.

## Data uji

Seluruh data di bawah adalah **data rekaan/demo** yang dibuat khusus untuk
pengujian. Bukan data produksi dan bukan data pribadi asli.

| Jenis | Data |
|---|---|
| Akun | `admin@gmail.com`, `pustakawan@gmail.com`, `student@gmail.com`, `user@gmail.com` |
| Password | `12345678` (demo) |
| Buku | `BK-001` s.d. `BK-006` |
| Kategori | 5 kategori rekaan |
| Kode anggota uji | `U-001` |

## Lingkungan

| Item | Nilai |
|---|---|
| Build | `v1-baseline` / `6e30775` (worktree terpisah) |
| Framework | PHPUnit 9.6.3 |
| Database | sqlite `:memory:` dengan `RefreshDatabase` |
| Konfigurasi | `phpunit.pjbl.xml` |
| Penulis bukti | otomatis oleh `RecordsEvidence.php` saat test berjalan |

## Strategi bukti

Setiap test memanggil `recordEvidence()` SEBELUM assertion, sehingga bukti tetap
ditulis walaupun test gagal. Bukti memuat ID, label build, commit, data uji,
expected, actual, status, penguji, dan waktu.

## Kriteria selesai

- 5 INT, 5 SYS, dan 3 AC dieksekusi
- Setiap test memiliki file bukti `.json`
- Log PHPUnit disimpan apa adanya
- Kegagalan dicatat sebagai defect, tidak dihapus
