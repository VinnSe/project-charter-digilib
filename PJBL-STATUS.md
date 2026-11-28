# STATUS PJBL MK35 — DIGILIB

Diperbarui: 28 Nov 2026.

## Posisi

- Objek: DIGILIB, sumber `ellenaasari/digilib`, versi kelompok `VinnSe/project-charter-digilib`
- Alur utama: `login → /borrow → pilih buku → /cart → /add-borrow → /report`
- 5 modul: autentikasi/role, katalog buku & kategori, peminjaman, keranjang, laporan
- Objek sudah disetujui dosen
- Tag lokal: `v1-baseline` = `6e30775`, `v2-fixes` = `7819145` (belum di-push)
- HEAD kerja: `63e2920` sebelum commit P13; remote masih `7819145`, belum ada push artefak PJBL
- Worktree regression: `D:/digilib-pjbl-v1` (`6e30775`) dan `D:/digilib-pjbl-v2` (`7819145`)

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

## P10 — selesai

Commit `2c3d97c`. File `portofolio-digilib/06-metrik/quality-checklist.md`.
ISO/IEC 25010 edisi 2011: 5 product quality + 1 quality in use.
6 indikator: 2 memenuhi, 3 tidak, 1 belum terukur (UAT draft).
Checklist 8 butir: 3 Ya, 4 Tidak, 1 belum terukur.

## P11 — selesai

Commit `851f756`. File `05-laporan/implementation-readiness-report.md` dan
`go-live-checklist.md`. Tabel kriteria memakai angka nyata P9: pass rate 61,5%,
3 Major terbuka, 3 pelanggaran akses role. Keputusan usulan: No-Go rilis penuh
→ Conditional Go setelah 5 syarat. Strategi: pilot + mini paralel.
Go-live checklist: 3 dari 10 item selesai. Tanda tangan UAT/PIC sengaja kosong.

## P12 — selesai

Commit `dfd302b`. File `06-metrik/dashboard-kpi.md` dan
`analisis-penyebab-dan-rekomendasi.md`.
Bukti performa: `E-P12-PERF.json` (20 request `/book`, rata-rata 0,0130 detik,
p95 0,0116 detik, maks 0,0907 detik) dan `E-P12-Perf.log`.
Dashboard 10 indikator: 4 Hijau, 2 Merah, 4 Kuning. DRE 100% ditandai
provisional (D = 0). Code coverage tidak diukur (Xdebug/PCOV absen).
Pareto: 3 dari 5 kegagalan (60%) pada area akses/role. 5 Whys menemukan akar
proses: kriteria hak akses tidak masuk Definition of Done. 6 rekomendasi
berpemilik dan bertarget 30 Nov 2026.
Koreksi P13: defect density v1 di dashboard diubah dari 1,49 menjadi 1,63
per KLOC karena 2013 baris adalah jumlah baris v2, bukan v1.

## P13 — selesai

Commit: (diisi setelah commit dokumentasi P13).
Suite 13 test yang sama dijalankan di dua worktree dengan environment identik.
Hasil: v1 `6e30775` 8/13 lulus (61,5%), v2 `7819145` 13/13 lulus (100%),
27 assertion di kedua build, 0 defect baru.

File:
- `03-evidence/P13-v1/` dan `P13-v2/` — 13 bukti JSON + log PHPUnit per build
- `03-evidence/rantai-bukti-p13.md` — requirement → test → run → defect → commit → retest
- `05-laporan/regression-test-report.md` — analisis dampak, strategi suite, hasil, audit bukti
- `06-metrik/perbandingan-v1-v2.md` — selisih absolut/relatif dan ancaman validitas
- `04-defect-log/defect-log.md` — status DEF-01…03 berubah menjadi Closed

DEF-01, DEF-02, DEF-03 dinyatakan Closed. Dua syarat Conditional Go (defect
tertutup dan pass rate minimal 95%) sudah terpenuhi. Screenshot visual belum
dibuat karena eksekusi memakai sqlite in-memory; bukti yang diaudit adalah log,
JSON, dan rantai bukti.

## Yang masih harus diselesaikan kelompok sendiri

Belum bisa dikerjakan agent; wajib dilengkapi sebelum submission.

| Item | Waktu terbaik | Alasan |
|---|---|---|
| UAT ditandatangani pemilik aplikasi (form belum dibuat, akan disiapkan kosong) | Sebelum P14 | P11 menyatakan UAT belum; keputusan final butuh status terbaru |
| Daftar hadir pelatihan admin/anggota | Sebelum P14 | syarat Conditional Go, harus masuk sebelum keputusan dikunci |
| Tanda tangan form peer review (`02-test-case/peer-review-form.md`) | Segera, paling lambat sebelum P14 | form sudah jadi sejak P9 |
| Peer assessment tiap anggota | Saat P15 | memang luaran P15 |
| Refleksi individu | Saat P15 | memang luaran P15 |

Kalau semua ditunda sampai setelah P15, P11/P12/P14 harus direvisi agar statusnya konsisten. Hindari itu.

## Item lain di luar lima di atas

| Item | Penanggung | Waktu |
|---|---|---|
| Tanda tangan persetujuan di `implementation-readiness-report.md` (pemilik aplikasi, ketua tim QA, dosen) | orang sungguhan | sebelum P14 |
| Persetujuan keputusan usulan No-Go/Conditional Go dan strategi pilot + mini paralel | pemilik aplikasi/dosen | sebelum P14 |
| Menyampaikan presentasi 15 menit, demo 4 menit, dan tanya jawab 5 menit | anggota kelompok | saat P15 |
| Izin push commit ke GitHub | user | sebelum submission |

Objek DIGILIB sudah disetujui dosen; pembagian peran dan format `Co-authored-by` sudah diputuskan, jadi tidak perlu diulang.

Yang masih bisa dikerjakan agent: uji rollback, konversi laporan ke PDF, dan push commit (dengan izin).

## Rencana sesi berikutnya

1. P14 — pola sama seperti P9–P13: saya jelaskan dulu, user konfirmasi paham, lalu saya kerjakan
2. P15 — pola sama: jelaskan → konfirmasi → kerjakan
3. Setelah itu lanjut ke 9 item Human

Pengingat penting: 5 dari 9 item (UAT, daftar hadir, tanda tangan peer review,
tanda tangan readiness report, persetujuan keputusan/strategi) sebaiknya beres
**sebelum P14 dikunci**. Saya akan mengingatkannya tepat sebelum P14.

## Berikutnya

P14 — Laporan akhir terintegrasi: gabungkan bukti P9–P13, quality checklist,
keputusan readiness, dashboard, dan regresi menjadi satu laporan + evidence index.
Laporan P14 masih berstatus awal sampai tanda tangan dan item Human dilengkapi.

## Perintah berguna

```bash
cd /d/digilib-pjbl-v2
PJBL_BUILD_LABEL="$(git describe --tags --always)" \
PJBL_COMMIT="$(git rev-parse --short HEAD)" \
PJBL_EVIDENCE_DIR="D:/digilib-pjbl/portofolio-digilib/03-evidence/P13-v2" \
php vendor/bin/phpunit -c phpunit.pjbl.xml --filter 'test_(int|sys|ac)_' --testdox
```
