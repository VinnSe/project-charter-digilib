# Form Peer Review — P9

Diisi oleh anggota kelompok sendiri (sesuai arahan dosen). Status: **konfirmasi, nama, tanggal, dan 5 dari 5 tanda tangan terpasang**.

Catatan: draf ini disusun dari hasil P9 yang benar-benar dijalankan (`E-P9-PHPUnit.log` dan file `E-*.json`). Kolom "Pengreview yang disarankan" adalah usulan pembagian, bukan tanda tangan. Konfirmasi isi, nama, dan tanggal sudah terisi; form menjadi sah sebagai peer review setelah tanda tangan kelima anggota dilampirkan.

| Aspek | Pengreview yang disarankan | Hal yang sudah baik | Hal yang perlu diperbaiki | Saran konkret |
|---|---|---|---|---|
| Kelengkapan skenario (normal & negatif) | Kelvin Septio (Test Lead) | 13 test mencakup INT, SYS, dan AC; skenario negatif hadir di INT-03, INT-04, SYS-02, dan SYS-03 | SYS-04 pada P9 hanya merekam rata-rata, belum p95 | Sertakan p95 langsung di test performa; sudah ditindaklanjuti lewat `P12PerformanceTest.php` dan `E-P12-PERF.json` |
| Ketepatan eksekusi — test INT (pekerjaan Dafit) | Fathan Al Mu'thi Arsyad | Data uji dinyatakan rekaan; `RefreshDatabase` dan sqlite `:memory:` membuat hasil dapat diulang; label build `v1-baseline` tercatat di tiap bukti | INT-02 sempat gagal hanya karena perbandingan format tanggal (`2026-12-04` vs `2026-12-04 00:00:00`) | Tulis format tanggal yang eksplisit di kolom expected agar tidak ambigu |
| Ketepatan eksekusi — test SYS/AC (pekerjaan Fathan) | M. Dafit Irwansyah | AC-01…03 memakai format Diberikan–Ketika–Maka; SYS-02 dan SYS-03 menguji skenario negatif akses | SYS-04 belum merekam p95 pada saat P9 | Tambahkan profil 20 request dengan p95; sudah ada di `E-P12-PERF.json` |
| Keterlacakan (test → requirement → defect → bukti) | Ade Henry Febrian (Quality Analyst) | Setiap ID bukti cocok dengan baris di `test-case.md`; DEF-01…03 menunjuk ke ID bukti yang sama | AC-01…03 belum dipetakan ke nomor requirement yang lebih formal | Tambahkan kolom requirement ID pada tabel `test-case.md` |
| Kejelasan bukti (bertanggal, dapat diverifikasi) | M. Aovar Ahdan (Documentation Lead) | 13 file JSON memuat ID, build, commit, data uji, expected, actual, status, penguji, dan waktu | Bukti SYS-02 dan SYS-03 hanya mencatat kode HTTP, tanpa cuplikan pesan/error | Tambahkan cuplikan respons pada bukti akses agar lebih mudah diverifikasi |

Pengreview: kelima anggota (lihat tabel konfirmasi di bawah) — nama dan tanggal
28 November 2026 sudah terisi. Tanda tangan Kelvin, Fathan, Ade, dan Ahdan
sudah terpasang.  Tanggal: 28 November 2026

## Konfirmasi dan tanda tangan anggota

Isi kolom Status konfirmasi dengan: Setuju / Setuju dengan catatan / Perlu koreksi.
Kolom Nama, Tanda tangan, dan Tanggal diisi oleh masing-masing anggota.

| No | Pengreview | Status konfirmasi | Nama | Tanda tangan | Tanggal |
|---|---|---|---|---|---|
| 1 | Kelvin Septio | Setuju | Kelvin Septio | `03-evidence/tanda-tangan-uat-kelvin.jpeg` | 28 November 2026 |
| 2 | Fathan Al Mu'thi Arsyad | Setuju | Fathan Al Mu'thi Arsyad | `03-evidence/tanda-tangan-fathan.jpeg` | 28 November 2026 |
| 3 | M. Dafit Irwansyah | Setuju | M. Dafit Irwansyah | `03-evidence/tanda-tangan-dafit.jpeg` | 28 November 2026 |
| 4 | Ade Henry Febrian | Setuju | Ade Henry Febrian | `03-evidence/tanda-tangan-ade.jpeg` | 28 November 2026 |
| 5 | M. Aovar Ahdan | Setuju | M. Aovar Ahdan | `03-evidence/tanda-tangan-ahdan.jpeg` | 28 November 2026 |

Catatan tambahan / koreksi: ................................................

