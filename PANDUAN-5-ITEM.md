# Panduan Menyelesaikan 5 Item Human — DIGILIB

Panduan ini untuk Kelompok 4. Urutan yang disarankan: selesaikan kelima item ini
dulu, baru agent menulis P14. Alasannya: P14 mengunci keputusan, angka, dan
evidence index; kalau kelima item belum beres, P11/P12/P14 harus direvisi.

Yang sudah disiapkan agent: form kosong dan template. Yang belum boleh diisi
agent: hasil UAT, nama/tanda tangan orang, dan status persetujuan.

## 1. UAT ditandatangani pemilik aplikasi

File: `02-test-case/uat-form.md`
Penanggung: pemilik aplikasi.

Langkah:
1. Pemilik aplikasi menjalankan DIGILIB v2 (`7819145`) dan mencoba 5 skenario di form.
2. Isi kolom Hasil (`Ya`/`Tidak`) dan Catatan per skenario.
3. Isi ringkasan, nama, tanda tangan, tanggal, dan keputusan UAT di bagian Penutup.
4. Target: minimal 4 dari 5 bernilai `Ya`.

Selesai jika: semua kolom hasil terisi dan ada tanda tangan pemilik aplikasi.
Dampak ke P14: go-live checklist item 6 berubah dari Belum menjadi Selesai.

## 2. Daftar hadir pelatihan admin/anggota

File: `05-laporan/daftar-hadir-pelatihan.md`
Penanggung: kelompok selaku penyelenggara; peserta menandatangani sendiri.

Langkah:
1. Tentukan tanggal, jam, tempat/platform, narasumber, dan materi.
2. Isi tabel peserta: nama, peran, dan tanda tangan.
3. Tulis jumlah hadir di bawah tabel.

Selesai jika: pelatihan benar-benar terjadi dan daftar hadir berisi tanda tangan
peserta. Dampak ke P14: go-live checklist item 10 berubah menjadi Selesai dan
syarat kelima Conditional Go terpenuhi.

## 3. Tanda tangan form peer review P9

File: `02-test-case/peer-review-form.md`
Penanggung: Kelvin, Fathan, Dafit, Ade, Aovar (sesuai pembagian di dalam form).

Langkah:
1. Baca observation pada baris yang menjadi tanggung jawabmu.
2. Isi Status konfirmasi: Setuju / Setuju dengan catatan / Perlu koreksi.
3. Tulis nama, tanda tangan, dan tanggal di barismu.
4. Kalau ada koreksi, tuliskan di kolom Saran konkret atau catatan tambahan.

Catatan: peer review ini internal kelompok sesuai arahan dosen, bukan antar
kelompok lain. Selesai jika kelima reviewer sudah mengonfirmasi dan menandatangani.

## 4. Tanda tangan persetujuan Implementation Readiness Report

File: `05-laporan/implementation-readiness-report.md` bagian 10
Penanggung: pemilik aplikasi, ketua tim QA, dosen pembimbing.

Langkah:
1. Baca kembali ringkasan dan kriteria Go/No-Go di bagian 1–4.
2. Masing-masing peran mengisi kolom Nama, Tanda tangan, Tanggal.
3. Biarkan kosong kalau belum menandatangani; jangan diwakilkan.

Selesai jika ketiga kolom sudah terisi oleh orangnya sendiri. Dampak ke P14:
bagian persetujuan laporan akhir tidak lagi berstatus draft.

## 5. Persetujuan keputusan usulan dan strategi peralihan

File: `05-laporan/persetujuan-keputusan.md`
Penanggung: pemilik aplikasi dan dosen pembimbing.

Langkah:
1. Baca usulan: No-Go rilis penuh → Conditional Go, strategi pilot + mini paralel.
2. Isi Status persetujuan: Disetujui / Disetujui dengan catatan / Ditolak.
3. Tulis catatan kalau ada syarat tambahan.
4. Isi nama, tanda tangan, tanggal.

Selesai jika status persetujuan terisi. Kalau hasilnya bukan "Disetujui",
agent harus merevisi keputusan di P14 sebelum laporan dikunci.

## Urutan ringkas

1. UAT → 2. Pelatihan → 3. Peer review → 4. Tanda tangan readiness → 5. Persetujuan keputusan.

Setelah kelima item selesai, beri tahu agent. Agent lalu memperbarui go-live
checklist, dashboard, dan menulis P14 dengan status final.

Hal yang masih bisa dikerjakan agent sambil menunggu: uji rollback dan konversi
laporan ke PDF. Push ke GitHub sudah dilakukan.
