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

| Item | Hasil | Bukti |
|---|---|---|
| Test dieksekusi | 13 | E-P9-PHPUnit.log |
| Assertion | 27 | E-P9-PHPUnit.log |
| Lulus | 8 | E-INT-01…05, E-SYS-01…05, E-AC-01…03 |
| Gagal | 5 | E-INT-04, E-INT-05, E-SYS-02, E-SYS-03, E-AC-03 |
| Pass rate | 61,5% | perhitungan dari 8 ÷ 13 |
| Defect Critical terbuka | 0 | 04-defect-log/defect-log.md |
| Defect Major terbuka | 3 | DEF-01, DEF-02, DEF-03 |
| Requirement coverage | alur utama tercakup | 01-test-plan/test-plan.md |

## 3. Evaluasi kualitas

Ringkasan dari quality checklist P10 (ISO/IEC 25010 edisi 2011):

| Indikator | Target | Hasil | Status |
|---|---|---|---|
| 5 dari 5 INT lulus | 100% | 3 dari 5 | Tidak |
| Akses lintas role | 0 | 3 pelanggaran | Tidak |
| Waktu respons `/book` | maks. 2 detik | 0,0062 detik | Ya |
| Elemen cart | min. 4 dari 5 | 5 dari 5 | Ya |
| Transaksi selesai konsisten | 0 kegagalan | INT-05 gagal | Tidak |
| Effectiveness (UAT) | min. 4 dari 5 | belum diisi | Belum terukur |

Angka performa berasal dari lingkungan lokal sqlite in-memory dan tidak
diklaim sebagai kinerja produksi.

## 4. Tabel kriteria Go/No-Go

| Kriteria | Ambang | Hasil | Bukti | Status |
|---|---|---|---|---|
| Defect Critical terbuka | 0 | 0 | defect-log.md | Terpenuhi |
| Defect Major terbuka | ≤ 2 + workaround | 3 | DEF-01…03 | Belum |
| Pass rate | ≥ 95% | 61,5% | E-P9-PHPUnit.log | Belum |
| Requirement coverage | 100% alur utama | tercakup | test-case.md | Terpenuhi |
| Akses role sesuai checklist | 0 pelanggaran | 3 | E-SYS-02, E-SYS-03, E-AC-03 | Belum |
| UAT disetujui | tanda tangan pemilik | draft | 02-test-case/peer-review-form.md | Belum |
| Backup & rollback diuji | restore berhasil | belum | — | Belum |
| Pelatihan pengguna | selesai | belum | — | Belum |
| Konversi data terverifikasi | jumlah + sampel cocok | belum | — | Belum |

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

Pelatihan: satu sesi 60 menit untuk admin dan anggota, panduan satu halaman
(login, meminjam, melihat laporan, penanganan transaksi gagal). Belum terlaksana.

## 8. Rencana rollback

| Pemicu | Tindakan | PIC |
|---|---|---|
| 3 transaksi gagal berturut-turut | kembali ke catatan manual | petugas + admin |
| Error rate > 5% dalam 15 menit | kembali ke versi sebelumnya | tim IT |
| Data peminjaman hilang/rusak | restore backup terakhir + pengumuman | admin |

Rencana ini **belum diuji**, sehingga tetap menjadi salah satu syarat
Conditional Go.

## 9. Risiko residual

| ID | Risiko | Dampak | Mitigasi |
|---|---|---|---|
| R-1 | Tiga Major masih terbuka di v1 | Sedang | dibuktikan tertutup di v2 pada P13 |
| R-2 | Rollback belum diuji | Sedang | uji sebelum rilis terbatas |
| R-3 | UAT dan pelatihan belum dilakukan | Sedang | ditandatangani/dilaksanakan sebelum go-live |

## 10. Persetujuan

| Peran | Nama | Tanda tangan | Tanggal |
|---|---|---|---|
| Pemilik aplikasi |  |  |  |
| Ketua tim QA |  |  |  |
| Dosen pembimbing |  |  |  |

Kolom sengaja dikosongkan sampai benar-benar ditandatangani.
