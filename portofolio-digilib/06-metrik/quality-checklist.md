# Quality Checklist — P10 (ISO/IEC 25010:2011)

Objek: DIGILIB, build `v1-baseline` (`6e30775`).
Sumber data: bukti eksekusi P9 di `03-evidence/`.
Edisi standar yang dipakai: **ISO/IEC 25010:2011** (8 karakteristik product quality, 5 quality in use), sesuai RPS. Edisi 2023 tidak dipakai agar tidak tertukar.

## Alasan pemilihan karakteristik

DIGILIB menyimpan data peminjaman dan membedakan akses admin/anggota. Karena itu kebenaran fungsi dan keamanan akses menjadi prioritas utama. Kinerja diukur karena katalog diakses berulang kali. Usability penting karena pengguna perpustakaan tidak menerima pelatihan khusus. Reliability dipilih karena transaksi yang tidak selesai merusak data peminjaman. Effectiveness dipakai sebagai quality in use untuk melihat apakah anggota benar-benar bisa meminjam tanpa bantuan.

## Pemetaan karakteristik → indikator → target

| Karakteristik | Subkarakteristik | Indikator | Target SMART | Metode uji | Hasil dari P9 | Status | Bukti |
|---|---|---|---|---|---|---|---|
| Functional suitability | Functional correctness | Test integrasi alur peminjaman lulus | 100% (5 dari 5 INT) pada rilis v1, sebelum 30 Nov 2026 | PHPUnit feature test | 3 dari 5 lulus | Tidak memenuhi | E-INT-01…05 |
| Security | Confidentiality | Akses lintas role berhasil | 0 akses berhasil pada rilis v1 | Security test (HTTP status) | 3 pelanggaran | Tidak memenuhi | E-SYS-02, E-SYS-03, E-AC-03 |
| Performance efficiency | Time behaviour | Waktu respons rata-rata `/book` | Maks. 2 detik, 10 request berurutan, lingkungan lokal, sebelum 30 Nov 2026 | Uji lokal | 0,0062 detik | Memenuhi | E-SYS-04 |
| Usability | Operability | Elemen halaman keranjang tersedia | Minimal 4 dari 5 elemen pada rilis v1 | Pemeriksaan DOM | 5 dari 5 | Memenuhi | E-SYS-05 |
| Reliability | Fault tolerance | Transaksi selesai konsisten | Status menjadi 1 dan session dihapus, 0 kegagalan | System/integration test | INT-05 gagal | Tidak memenuhi | E-INT-05 |
| Effectiveness (quality in use) | — | Anggota menyelesaikan peminjaman tanpa bantuan | Minimal 4 dari 5 penguji | UAT | Belum diisi | Belum terukur | form UAT draft |

Catatan performa: angka 0,0062 detik adalah hasil lingkungan lokal dengan sqlite in-memory. Ini bukan ukuran kinerja produksi dan tidak boleh diklaim sebagai kinerja produksi.

## Quality checklist

Isi jawaban diambil dari bukti P9, bukan dari perkiraan.

| No | Pertanyaan checklist | Karakteristik | Jawaban | Bukti |
|---|---|---|---|---|
| 1 | Apakah alur peminjaman dasar terbentuk (borrow → cart)? | Functional completeness | Ya | E-INT-01, E-INT-02 |
| 2 | Apakah seluruh test integrasi alur lulus? | Functional correctness | Tidak (3 dari 5) | E-INT-01…05 |
| 3 | Apakah anggota tidak dapat membuka halaman admin? | Confidentiality | Tidak | E-SYS-03, E-AC-03 |
| 4 | Apakah admin tidak dapat membuka halaman peminjaman? | Confidentiality | Tidak | E-SYS-02 |
| 5 | Apakah waktu respons `/book` maksimal 2 detik? | Time behaviour | Ya (0,0062 detik) | E-SYS-04 |
| 6 | Apakah elemen halaman keranjang lengkap? | Operability | Ya (5 dari 5) | E-SYS-05 |
| 7 | Apakah transaksi selesai mengubah status dan membersihkan session? | Fault tolerance | Tidak | E-INT-05 |
| 8 | Apakah anggota dapat meminjam tanpa bantuan? | Effectiveness | Belum terukur | form UAT draft |

## Kesimpulan

Dari 8 butir checklist: 3 Ya, 4 Tidak, 1 belum terukur. Dari 6 indikator: 2 memenuhi, 3 tidak memenuhi, 1 belum terukur.

Ketidakmemenuhan berpusat pada pembatasan role dan penyelesaian transaksi — dua area yang sudah diperbaiki di `v2-fixes`. Pembuktiannya akan dilakukan pada P13 dengan test yang sama. UAT sengaja dibiarkan kosong sampai benar-benar diisi dan ditandatangani anggota/pemilik.
