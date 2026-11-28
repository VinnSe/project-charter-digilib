# Analisis Penyebab dan Rekomendasi — P12

## Analisis Pareto

Dari 5 test yang gagal di v1:

| Area                    | Test gagal            | Jumlah | Persentase |
|-------------------------|-----------------------|--------|------------|
| Pembatasan akses / role | SYS-02, SYS-03, AC-03 | 3      | 60%        |
| Validasi stok keranjang | INT-04                | 1      | 20%        |
| Penyelesaian transaksi  | INT-05                | 1      | 20%        |

Tiga dari lima kegagalan (60%) berasal dari satu area: pembatasan akses.
Ini sesuai dengan DEF-01 dan menjadi prioritas utama perbaikan.

## Analisis 5 Whys

Masalah: anggota dapat membuka halaman admin `/add-book`.

1. **Why 1** — Kenapa anggota bisa membuka `/add-book`? Karena route tersebut
   hanya memakai middleware `auth`, bukan pembatasan role.
2. **Why 2** — Kenapa hanya memakai `auth`? Karena saat route ditulis, belum ada
   pengelompokan route berdasarkan hak akses.
3. **Why 3** — Kenapa belum ada pengelompokan? Karena requirement role belum
   diterjemahkan menjadi aturan akses yang eksplisit di desain awal.
4. **Why 4** — Kenapa tidak terdeteksi lebih awal? Karena tidak ada checklist
   verifikasi hak akses sebelum aplikasi dianggap selesai.
5. **Why 5** — Kenapa checklist itu tidak ada? Karena kriteria akses tidak
   dimasukkan ke dalam Definition of Done tim.

**Akar penyebab:** kriteria hak akses tidak ditetapkan sebagai bagian dari
kriteria selesai sejak awal. Ini masalah proses, bukan sekadar baris kode yang
terlewat. Karena itu rekomendasinya tidak hanya menambah middleware, tetapi juga
memasukkan uji akses ke dalam checklist rilis.

## Rekomendasi

| ID  | Rekomendasi                                          | Dampak | Usaha  | Pemilik        | Target terukur                  | Tenggat     |
|-----|------------------------------------------------------|--------|--------|----------------|---------------------------------|-------------|
| R-1 | Terapkan pembatasan role dan uji akses tiap rilis    | Tinggi | Sedang | Dafit + Fathan | 0 pelanggaran akses di v2       | 30 Nov 2026 |
| R-2 | Validasi stok sebelum `addCart`                      | Sedang | Rendah | Dafit          | INT-04 lulus di v2              | 30 Nov 2026 |
| R-3 | Set status peminjaman dan hapus session saat selesai | Tinggi | Rendah | Dafit          | INT-05 lulus di v2              | 30 Nov 2026 |
| R-4 | Uji rollback sebelum rilis terbatas                  | Tinggi | Sedang | Aovar          | restore berhasil, ada log       | 30 Nov 2026 |
| R-5 | Isi UAT dan laksanakan pelatihan                     | Sedang | Sedang | Kelvin         | 4 dari 5 penguji + daftar hadir | 30 Nov 2026 |
| R-6 | Tambahkan pengukuran p95 pada tiap rilis             | Rendah | Rendah | Ade            | p95 terekam di dashboard        | 30 Nov 2026 |

R-1 hingga R-3 sudah diterapkan di `v2-fixes` (`7819145`). Pembuktian formalnya
dilakukan pada P13 dengan menjalankan suite yang sama di `v1-baseline` dan
`v2-fixes`. R-4 dan R-5 tetap terbuka dan tidak diisi atas nama orang lain.

## Hubungan dengan P13

Rekomendasi R-1, R-2, dan R-3 langsung menjadi objek regression testing:
masing-masing punya test yang gagal di v1 dan harus lulus di v2, dengan bukti
`E-INT-04.json`, `E-INT-05.json`, `E-SYS-02.json`, `E-SYS-03.json`, dan
`E-AC-03.json`.
