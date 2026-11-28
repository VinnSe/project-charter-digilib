# Uji Rollback — DIGILIB

Tanggal: 28 November 2026, 17:57:29 SEAST (sesuai `03-evidence/rollback-test.log`)
Tujuan: membuktikan prosedur restore dari backup dapat mengembalikan data ke
kondisi sebelum gangguan.

## Lingkungan

- MySQL XAMPP `127.0.0.1:3306`, user `root`.
- Database sumber: `digilib_v2` (build `v2-fixes`, `7819145`).
- Database uji: `digilib_rollback_test`, hasil kloning dari backup sumber.
- Backup: `03-evidence/backup-digilib-v2-20261128.sql` (13.486 byte).
- Log mentah: `03-evidence/rollback-test.log`.

Ini uji pada **database uji**, bukan produksi. Hasilnya tidak diklaim sebagai
pengujian lingkungan produksi.

## Prosedur dan hasil

| Langkah | Aksi | Hasil |
|---|---|---|
| 1 | `mysqldump` `digilib_v2` ke file backup | Backup terbuat, 13.486 byte |
| 2 | Buat `digilib_rollback_test` dan import backup | Database uji siap |
| 3 | Catat baseline | `books=2, users=4, borrows=2, detail_borrows=2, bk002_stock=5` |
| 4 | Simulasi gangguan: `UPDATE books SET stock=99 WHERE code='BK-002'` | `bk002_stock=99`, jumlah baris lain tidak berubah |
| 5 | Drop database uji, buat ulang, import backup | Restore selesai |
| 6 | Catat kondisi setelah restore | `books=2, users=4, borrows=2, detail_borrows=2, bk002_stock=5` |
| 7 | Bandingkan baseline vs setelah restore | Identik |

## Kesimpulan

**Restore berhasil.** Baseline dan kondisi setelah restore identik, sehingga
prosedur rollback dinyatakan **LULUS** untuk skenario data peminjaman hilang/
rusak. Database uji dibersihkan setelah verifikasi.

Bukti: `03-evidence/rollback-test.log`.
Catatan: go-live checklist item 7 (backup/restore) dan 8 (uji rollback) kini
**Selesai**. Item 9 (konversi data master terverifikasi) masih Belum.
