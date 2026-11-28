# Bukti Eksekusi — P9 dan P13

## P9 (baseline v1)

| ID | File | Keterangan |
|---|---|---|
| INT-01…05 | `E-INT-01.json` … `E-INT-05.json` | bukti integration test |
| SYS-01…05 | `E-SYS-01.json` … `E-SYS-05.json` | bukti system test |
| AC-01…03 | `E-AC-01.json` … `E-AC-03.json` | bukti acceptance criteria |
| LOG | `E-P9-PHPUnit.log` | log eksekusi PHPUnit mentah |
| P12-PERF | `E-P12-PERF.json` | profil 20 request `/book`: rata-rata dan p95 |
| LOG | `E-P12-Perf.log` | log eksekusi profil performa |

Setiap file JSON dibuat otomatis oleh test saat dijalankan. Label build pada
bukti adalah `v1-baseline` dengan commit `6e30775`.

## P13 (regression v1 vs v2)

| Folder / file | Isi |
|---|---|
| `P13-v1/` | 13 bukti JSON + `E-P13-v1-PHPUnit.log`, label `v1-baseline` / `6e30775` |
| `P13-v2/` | 13 bukti JSON + `E-P13-v2-PHPUnit.log`, label `v2-fixes` / `7819145` |
| `rantai-bukti-p13.md` | requirement → test → run → defect → commit → retest |
| `P13-screenshots/` | 8 screenshot sebelum/sesudah untuk DEF-01…03 + README metadata |
| `rollback-test.log` | log uji restore database dan bukti `backup-digilib-v2-20261128.sql` |
| `data-conversion-verification.log` | verifikasi 4 akun, 5 kategori, BK-001…BK-006, 0 duplikat |
| `../05-laporan/regression-test-report.md` | analisis dampak, suite, hasil, dan audit bukti |
| `../06-metrik/perbandingan-v1-v2.md` | tabel metrik sebelum/sesudah |

Kedua folder P13 memakai perintah, filter test, dan environment yang identik.
Label build dan commit ditulis oleh shell saat eksekusi, bukan disisipkan manual.
