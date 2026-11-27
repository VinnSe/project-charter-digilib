# STATUS PJBL MK35 — DIGILIB

Diperbarui: 27 Nov 2026.

## Posisi

- Objek: DIGILIB, sumber `ellenaasari/digilib`, versi kelompok `VinnSe/project-charter-digilib`
- Alur utama: `login → /borrow → pilih buku → /cart → /add-borrow → /report`
- 5 modul: autentikasi/role, katalog buku & kategori, peminjaman, keranjang, laporan
- Objek sudah disetujui dosen
- Tag lokal: `v1-baseline` = `6e30775`, `v2-fixes` = `7819145` (belum di-push)
- HEAD kerja: `2c3d97c`, remote masih `7819145`, belum ada push artefak PJBL

## Keputusan kelompok

| Topik | Keputusan |
|---|---|
| Peran | Kelvin Test Lead; Dafit INT; Fathan SYS+AC; Ade Quality Analyst; Aovar Implementation/Dokumentasi |
| Commit | author `Ade0746` dari satu laptop + `Co-authored-by` per kontributor + tabel di README |
| Perbaikan P13 | memakai perbaikan role yang sudah ada di v2 (bukan perbaikan baru) |
| Data uji | akun demo + 5 kategori + 6 buku `BK-001…BK-006`, dinyatakan rekaan |
| Hasil uji | asli dari eksekusi, defect tidak disembunyikan |

## P9 — selesai

Commit `ddb9c1c`. Test dijalankan di worktree `D:\digilib-pjbl-v1` pada `v1-baseline`:
13 test, 27 assertion, 8 lulus, 5 gagal (pass rate 61,5%).

Defect: DEF-01 role (SYS-02, SYS-03, AC-03), DEF-02 stok habis (INT-04),
DEF-03 status/session (INT-05). Bukti di `portofolio-digilib/03-evidence/`.

Pengecekan awal di v2: 13/13 lulus (scratch, bukan bukti formal P13).

## P10 — selesai

Commit `2c3d97c`. File `portofolio-digilib/06-metrik/quality-checklist.md`.
ISO/IEC 25010 edisi 2011: 5 product quality + 1 quality in use.
6 indikator: 2 memenuhi, 3 tidak, 1 belum terukur (UAT draft).
Checklist 8 butir: 3 Ya, 4 Tidak, 1 belum terukur.

## P11 — selesai

Commit menyusul. File `05-laporan/implementation-readiness-report.md` dan
`go-live-checklist.md`. Tabel kriteria memakai angka nyata P9: pass rate 61,5%,
3 Major terbuka, 3 pelanggaran akses role. Keputusan usulan: No-Go rilis penuh
→ Conditional Go setelah 5 syarat. Strategi: pilot + mini paralel.
Go-live checklist: 3 dari 10 item selesai. Tanda tangan UAT/PIC sengaja kosong.

## Berikutnya

P12 — Metrik kualitas: dashboard minimal 8 KPI dengan status Hijau/Kuning/Merah,
analisis Pareto dan 5 Whys, serta rekomendasi berpemilik dan bertarget.

## Perintah berguna

```bash
cd /d/digilib-pjbl
PJBL_BUILD_LABEL="v1-baseline" PJBL_COMMIT="6e30775" \
PJBL_EVIDENCE_DIR="D:/digilib-pjbl/portofolio-digilib/03-evidence" \
php vendor/bin/phpunit -c phpunit.pjbl.xml --testdox
```
