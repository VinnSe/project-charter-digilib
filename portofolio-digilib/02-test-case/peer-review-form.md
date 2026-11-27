# Form Peer Review — P9

Diisi oleh anggota kelompok sendiri (sesuai arahan dosen). Status: **draf berbasis bukti eksekusi, belum ditandatangani anggota**.

Catatan: draf ini disusun dari hasil P9 yang benar-benar dijalankan (`E-P9-PHPUnit.log` dan file `E-*.json`). Ini bukan penilaian dari orang lain dan tidak boleh dianggap sebagai peer review selesai sampai dikonfirmasi serta ditandatangani anggota.

| Aspek | Hal yang sudah baik | Hal yang perlu diperbaiki | Saran konkret |
|---|---|---|---|
| Kelengkapan skenario (normal & negatif) | 13 test mencakup INT, SYS, dan AC; skenario negatif hadir di INT-03, INT-04, SYS-02, dan SYS-03 | SYS-04 pada P9 hanya merekam rata-rata, belum p95 | Sertakan p95 langsung di test performa; sudah ditindaklanjuti lewat `P12PerformanceTest.php` dan `E-P12-PERF.json` |
| Ketepatan eksekusi (langkah & data) | Data uji dinyatakan rekaan; `RefreshDatabase` dan sqlite `:memory:` membuat hasil dapat diulang; label build `v1-baseline` tercatat di tiap bukti | INT-02 sempat gagal hanya karena perbandingan format tanggal (`2026-12-04` vs `2026-12-04 00:00:00`) | Tulis format tanggal yang eksplisit di kolom expected agar tidak ambigu |
| Kejelasan bukti (bertanggal, dapat diverifikasi) | 13 file JSON memuat ID, build, commit, data uji, expected, actual, status, penguji, dan waktu | Bukti SYS-02 dan SYS-03 hanya mencatat kode HTTP, tanpa cuplikan pesan/error | Tambahkan cuplikan respons pada bukti akses agar lebih mudah diverifikasi |
| Keterlacakan (test → requirement) | Setiap ID bukti cocok dengan baris di `test-case.md`; DEF-01…03 menunjuk ke ID bukti yang sama | AC-01…03 belum dipetakan ke nomor requirement yang lebih formal | Tambahkan kolom requirement ID pada tabel `test-case.md` |

Pengreview: **belum diisi — menunggu konfirmasi anggota**  Tanggal: ..................
