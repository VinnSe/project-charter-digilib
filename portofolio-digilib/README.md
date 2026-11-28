# Portofolio Testing DIGILIB

## Deskripsi aplikasi

DIGILIB adalah sistem peminjaman buku perpustakaan berbasis Laravel.
Sumber awal: https://github.com/ellenaasari/digilib
Versi kelompok: https://github.com/VinnSe/project-charter-digilib

## Versi yang diuji

| Label | Commit | Keterangan |
|---|---|---|
| `v1-baseline` | `6e30775` | kondisi sebelum perbaikan role |
| `v2-fixes` | `7819145` | kondisi setelah perbaikan role |

Kedua tag saat ini hanya ada di lokal (belum di-push ke GitHub).

## Objek dan alur utama

5 modul: autentikasi & role, katalog buku & kategori, peminjaman, keranjang, laporan.
Alur utama: `login → /borrow → pilih buku → /cart → /add-borrow → /report`.

## Anggota dan peran

| Nama | NIM | Peran | Fokus artefak |
|---|---|---|---|
| Kelvin Septio | 701240049 | Test Lead / koordinator | test plan, konsistensi bukti, presentasi |
| M. Dafit Irwansyah | 701240032 | Integration Tester | INT-01…05, penulis bukti otomatis |
| Fathan Al Mu'thi Arsyad | 701240037 | System Tester | SYS-01…05, AC-01…03, UAT |
| Ade Henry Febrian | 701240036 | Quality Analyst | ISO 25010, checklist, metrik |
| M. Aovar Ahdan | 701240048 | Implementation/Documentation Lead | readiness, rollback, laporan, portofolio |

PDF menentukan 4 peran untuk 4 orang. Kelompok ini beranggotakan 5 orang,
sehingga peran Integration/System Tester didampingi oleh dua anggota.

## Pencatatan kontribusi

Commit dibuat dari satu laptop dengan author `Ade0746`. Setiap commit menyertakan
baris `Co-authored-by` sesuai kontributor, dan tabel di atas menjadi pelengkap
untuk menelusuri kontribusi tiap anggota.

## Cara menelusuri bukti

1. Buka `02-test-case/test-case.md` untuk melihat daftar ID test di v1.
2. Buka `03-evidence/E-<ID>.json` untuk bukti P9, atau
   `03-evidence/P13-v1|v2/E-<ID>.json` untuk bukti regression.
3. Log eksekusi mentah: `03-evidence/E-P9-PHPUnit.log`,
   `03-evidence/P13-v1/E-P13-v1-PHPUnit.log`, dan
   `03-evidence/P13-v2/E-P13-v2-PHPUnit.log`.
4. Kegagalan dan status tertutup ada di `04-defect-log/defect-log.md`.
5. Rantai bukti perbaikan ada di `03-evidence/rantai-bukti-p13.md`.
6. Ringkasan perbandingan ada di `05-laporan/regression-test-report.md` dan
   `06-metrik/perbandingan-v1-v2.md`.

## Struktur folder

- `01-test-plan/` — rencana dan ruang lingkup pengujian
- `02-test-case/` — daftar test case dan form peer review
- `03-evidence/` — bukti hasil eksekusi P9, P12, dan P13
- `04-defect-log/` — daftar defect dan status verifikasinya
- `05-laporan/` — laporan terintegrasi, evidence index, dan regression report
- `06-metrik/` — quality checklist, dashboard KPI, dan perbandingan v1–v2
- `07-refleksi/` — skrip demo, peer assessment, refleksi

## Status singkat

P9–P13 selesai sebagai artefak. P13 membuktikan 3 defect Major dari v1 tertutup
di v2 (pass rate 61,5% → 100%). P14 dan P15 belum dikerjakan. Tanda tangan UAT,
peer review, dan readiness report sengaja dikosongkan sampai diisi orang sungguhan.
