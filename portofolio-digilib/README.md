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

1. Buka `02-test-case/test-case.md` untuk melihat daftar ID test.
2. Buka `03-evidence/E-<ID>.json` untuk melihat data uji, expected, actual, status, penguji, dan build.
3. Log eksekusi mentah ada di `03-evidence/E-P9-PHPUnit.log`.
4. Kegagalan dirangkum di `04-defect-log/defect-log.md`.

## Struktur folder

- `01-test-plan/` — rencana dan ruang lingkup pengujian
- `02-test-case/` — daftar test case dan form peer review
- `03-evidence/` — bukti hasil eksekusi
- `04-defect-log/` — daftar defect dan rantai buktinya
- `05-laporan/` — laporan terintegrasi dan evidence index
- `06-metrik/` — quality checklist dan dashboard KPI
- `07-refleksi/` — skrip demo, peer assessment, refleksi
