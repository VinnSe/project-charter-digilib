<?php

namespace Tests\Feature\Pjbl;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class P9SystemTest extends TestCase
{
    use RefreshDatabase, P9Data, RecordsEvidence;

    public function test_sys_01_alur_lengkap_sampai_laporan(): void
    {
        $user = $this->anggota();
        $this->buku();
        $this->mulaiPinjam($user);
        $this->post('/add-cart', ['code' => 'BK-001', 'code_user' => 'U-001']);
        $this->post('/add-borrow', ['return_date' => 7]);

        $res = $this->get('/report');
        $actual = ['http_report' => $res->getStatusCode()];
        $pass = $res->getStatusCode() === 200;

        $this->recordEvidence('SYS-01', ['student@gmail.com', 'BK-001'], 'halaman /report dapat dibuka setelah alur peminjaman', json_encode($actual, JSON_UNESCAPED_UNICODE), $pass, 'Fathan');
        $this->assertTrue($pass, 'SYS-01 gagal: alur lengkap tidak menghasilkan halaman laporan.');
    }

    public function test_sys_02_admin_tidak_boleh_membuka_borrow(): void
    {
        $admin = $this->admin();
        $this->actingAs($admin);

        $res = $this->get('/borrow');
        $actual = ['http' => $res->getStatusCode()];
        $pass = $res->getStatusCode() === 403;

        $this->recordEvidence('SYS-02', ['admin@gmail.com'], 'akses /borrow ditolak dengan 403', json_encode($actual, JSON_UNESCAPED_UNICODE), $pass, 'Fathan');
        $this->assertTrue($pass, 'SYS-02 gagal: admin masih bisa membuka halaman peminjaman.');
    }

    public function test_sys_03_anggota_tidak_boleh_membuka_add_book(): void
    {
        $user = $this->anggota();
        $this->actingAs($user);

        $res = $this->get('/add-book');
        $actual = ['http' => $res->getStatusCode()];
        $pass = $res->getStatusCode() === 403;

        $this->recordEvidence('SYS-03', ['student@gmail.com'], 'akses /add-book ditolak dengan 403', json_encode($actual, JSON_UNESCAPED_UNICODE), $pass, 'Fathan');
        $this->assertTrue($pass, 'SYS-03 gagal: anggota masih bisa membuka halaman admin.');
    }

    public function test_sys_04_waktu_respons_katalog(): void
    {
        $user = $this->anggota();
        $this->buku();
        $this->actingAs($user);

        $waktu = [];
        for ($i = 0; $i < 10; $i++) {
            $mulai = microtime(true);
            $res = $this->get('/book');
            $waktu[] = microtime(true) - $mulai;
            if ($res->getStatusCode() !== 200) {
                break;
            }
        }
        $rata = array_sum($waktu) / count($waktu);
        $actual = ['request' => count($waktu), 'rata_rata_detik' => round($rata, 4)];
        $pass = $rata <= 2.0;

        $this->recordEvidence('SYS-04', ['10 request GET /book', 'lingkungan lokal'], 'rata-rata maksimal 2 detik', json_encode($actual, JSON_UNESCAPED_UNICODE), $pass, 'Fathan');
        $this->assertTrue($pass, 'SYS-04 gagal: waktu respons rata-rata melebihi 2 detik.');
    }

    public function test_sys_05_kelengkapan_elemen_halaman_cart(): void
    {
        $user = $this->anggota();
        $this->buku();
        $this->mulaiPinjam($user);
        $this->post('/add-cart', ['code' => 'BK-001', 'code_user' => 'U-001']);

        $html = $this->get('/cart')->getContent();
        $penanda = ['<form', 'name="code"', 'name="return_date"', '<table', 'add-borrow'];
        $ditemukan = [];
        foreach ($penanda as $p) {
            if (str_contains($html, $p)) {
                $ditemukan[] = $p;
            }
        }
        $jumlah = count($ditemukan);
        $actual = ['ditemukan' => $ditemukan, 'jumlah' => $jumlah];
        $pass = $jumlah >= 4;

        $this->recordEvidence('SYS-05', ['student@gmail.com', 'BK-001'], 'minimal 4 dari 5 elemen antarmuka cart tersedia', json_encode($actual, JSON_UNESCAPED_UNICODE), $pass, 'Fathan');
        $this->assertTrue($pass, 'SYS-05 gagal: elemen halaman cart tidak lengkap.');
    }
}
