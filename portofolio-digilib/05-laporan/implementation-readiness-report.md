# Implementation Readiness Report — DIGILIB v1

Tanggal: 27 November 2026
Build yang dievaluasi: `v1-baseline` (`6e30775`)
Artefak pendukung: bukti P9 (`03-evidence/`), quality checklist P10 (`06-metrik/quality-checklist.md`)

## 1. Ringkasan eksekutif

Hasil pengujian v1 menunjukkan tidak ada defect Critical, tetapi ada tiga defect
Major yang masih terbuka dan pass rate hanya 61,5%. Karena itu rilis penuh
dinyatakan **No-Go**. Tim mengusulkan **Conditional Go** setelah lima syarat
terpenuhi, dengan strategi **pilot + mini paralel**.

Laporan ini adalah rekomendasi tim QA. Keputusan akhir berada pada pemilik
aplikasi/dosen.

## 2. Ringkasan hasil testing

| Item                    | Hasil               | Bukti                                           |
|-------------------------|---------------------|-------------------------------------------------|
| Test dieksekusi         | 13                  | E-P9-PHPUnit.log                                |
| Assertion               | 27                  | E-P9-PHPUnit.log                                |
| Lulus                   | 8                   | E-INT-01…05, E-SYS-01…05, E-AC-01…03            |
| Gagal                   | 5                   | E-INT-04, E-INT-05, E-SYS-02, E-SYS-03, E-AC-03 |
| Pass rate               | 61,5%               | perhitungan dari 8 ÷ 13                         |
| Defect Critical terbuka | 0                   | 04-defect-log/defect-log.md                     |
| Defect Major terbuka    | 3                   | DEF-01, DEF-02, DEF-03                          |
| Requirement coverage    | alur utama tercakup | 01-test-plan/test-plan.md                       |

## 3. Evaluasi kualitas

Ringkasan dari quality checklist P10 (ISO/IEC 25010 edisi 2011):

| Indikator                   | Target        | Hasil             | Status  |
|-----------------------------|---------------|-------------------|---------|
| 5 dari 5 INT lulus          | 100%          | 3 dari 5          | Tidak   |
| Akses lintas role           | 0             | 3 pelanggaran     | Tidak   |
| Waktu respons `/book`       | maks. 2 detik | 0,0062 detik      | Ya      |
| Elemen cart                 | min. 4 dari 5 | 5 dari 5          | Ya      |
| Transaksi selesai konsisten | 0 kegagalan   | INT-05 gagal      | Tidak   |
| Effectiveness (UAT)         | min. 4 dari 5 | 5 dari 5 diterima | Terukur |

Angka performa berasal dari lingkungan lokal sqlite in-memory dan tidak
diklaim sebagai kinerja produksi.

## 4. Tabel kriteria Go/No-Go

| Kriteria                    | Ambang                | Hasil                                  | Bukti                                                   | Status     |
|-----------------------------|-----------------------|----------------------------------------|---------------------------------------------------------|------------|
| Defect Critical terbuka     | 0                     | 0                                      | `04-defect-log/defect-log.md`                           | Terpenuhi  |
| Defect Major terbuka        | ≤ 2 + workaround      | 0                                      | `defect-log.md`, `P13-v2/`                              | Terpenuhi  |
| Pass rate                   | ≥ 95%                 | 100%                                   | `P13-v2/E-P13-v2-PHPUnit.log`                           | Terpenuhi  |
| Requirement coverage        | 100% alur utama       | 13 dari 13                             | `test-case.md`, 13 bukti JSON                           | Terpenuhi  |
| Akses role sesuai checklist | 0 pelanggaran         | 0                                      | `P13-v2/E-SYS-02.json`, `E-SYS-03.json`, `E-AC-03.json` | Terpenuhi  |
| UAT disetujui               | tanda tangan pemilik  | 5 dari 5 diterima                      | `02-test-case/uat-form.md`                              | Terpenuhi  |
| Backup & rollback diuji     | restore berhasil      | berhasil                               | `03-evidence/rollback-test.log`                         | Terpenuhi  |
| Pelatihan pengguna          | selesai               | 5 peserta                              | `05-laporan/daftar-hadir-pelatihan.md`                  | Terpenuhi  |
| Konversi data terverifikasi | jumlah + sampel cocok | 4 akun, 5 kategori, 6 buku             | `03-evidence/data-conversion-verification.log`          | Terpenuhi  |

Catatan: pelatihan tercatat dengan 5 peserta dan 5 dari 5 tanda tangan terpasang.

## 5. Keputusan dan alasan

**No-Go untuk rilis penuh.** Tidak ada Critical, tetapi tiga Major masih
terbuka, pass rate jauh di bawah ambang, dan prosedur pemulihan belum dicoba.

**Conditional Go** diusulkan setelah:

1. DEF-01, DEF-02, dan DEF-03 tertutup dan dibuktikan di `v2-fixes` lewat regression P13
2. Pass rate minimal 95% pada v2
3. Uji rollback sampai berhasil restore
4. UAT ditandatangani oleh pemilik aplikasi
5. Pelatihan admin dan anggota selesai

## 6. Strategi peralihan

Dipilih **pilot + mini paralel**:

- sistem baru dicoba di satu kelas/lokasi selama satu minggu
- catatan peminjaman manual tetap dipakai sebagai cadangan
- evaluasi setelah minggu pertama sebelum perluasan

Alasan: data peminjaman menyangkut buku dan identitas anggota. Strategi direct
terlalu berisiko; parallel penuh membebani petugas dengan kerja ganda. Pilot
membatasi dampak jika terjadi kegagalan.

## 7. Konversi data dan pelatihan

Konversi difokuskan pada data master (kategori, buku, akun). Data transaksi lama
dibiarkan sebagai arsip karena sistem sebelumnya berbasis catatan manual.

Langkah: ekstrak → bersihkan kode `BK-001…BK-006` dan duplikat → muat lewat
seeder → verifikasi jumlah baris dan sampel nilai.

Verifikasi 28 November 2026: `digilib_v2` berisi 4 akun, 5 kategori
(Fiksi, Non-Fiksi, Teknologi, Sejarah, Novel), dan 6 buku BK-001…BK-006 dengan
0 duplikat. Bukti: `03-evidence/data-conversion-verification.log`.

Pelatihan: satu sesi 60 menit untuk admin dan anggota, panduan satu halaman
(login, meminjam, melihat laporan, penanganan transaksi gagal). Sudah tercatat
di `05-laporan/daftar-hadir-pelatihan.md` dengan 5 peserta; tanda tangan
menyusul.

## 8. Rencana rollback

| Pemicu                           | Tindakan                             | PIC             |
|----------------------------------|--------------------------------------|-----------------|
| 3 transaksi gagal berturut-turut | kembali ke catatan manual            | petugas + admin |
| Error rate > 5% dalam 15 menit   | kembali ke versi sebelumnya          | tim IT          |
| Data peminjaman hilang/rusak     | restore backup terakhir + pengumuman | admin           |

Rencana ini sudah diuji pada 28 November 2026 lewat kloning `digilib_v2` ke
`digilib_rollback_test`: backup dibuat, gangguan disimulasikan dengan mengubah
`BK-002 stock` menjadi 99, lalu database dipulihkan dari backup. Baseline dan
kondisi setelah restore identik (`books=2, users=4, borrows=2,
detail_borrows=2, bk002_stock=5`). Bukti: `03-evidence/rollback-test.log` dan
`03-evidence/backup-digilib-v2-20261128.sql`. Uji ini dilakukan pada database
uji, bukan produksi.

## 9. Risiko residual

| ID  | Risiko            | Dampak | Mitigasi                                                        |
|-----|-------------------|--------|-----------------------------------------------------------------|
| R-1 | Tiga Major di v1  | Sedang | sudah dibuktikan tertutup di `v2-fixes` pada P13                |
| R-2 | Rollback          | Sedang | sudah diuji 28 Nov 2026; restore berhasil (`rollback-test.log`) |
| R-3 | UAT dan pelatihan | Sedang | UAT diterima 5 dari 5; pelatihan 5 dari 5 TTD                   |

## 10. Persetujuan

| Peran            | Nama                                       | Tanda tangan                               | Tanggal          |
|------------------|--------------------------------------------|--------------------------------------------|------------------|
| Pemilik aplikasi | Kelvin Septio (pemilik aplikasi, simulasi) | `03-evidence/tanda-tangan-uat-kelvin.jpeg` | 28 November 2026 |
| Ketua tim QA     | Kelvin Septio (Test Lead / koordinator)    | `03-evidence/tanda-tangan-uat-kelvin.jpeg` | 28 November 2026 |
| Dosen pembimbing | Fatima Felawati, M.Kom (sesuai PDF tugas)  | menyusul                                   | 28 November 2026 |

Nama dan tanggal sudah diisi. Tanda tangan Kelvin terpasang untuk kedua perannya;
tanda tangan dosen pembimbing masih menyusul. Status ini tidak mengklaim dosen
sudah menandatangani.
