<?php

namespace Tests\Feature\Pjbl;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class P9IntegrationTest extends TestCase
{
    use RefreshDatabase, P9Data, RecordsEvidence;

    public function test_int_01_login_borrow_membuat_transaksi(): void
    {
        $user = $this->anggota();
        $this->actingAs($user);

        $res = $this->get('/borrow');
        $code = (string) session('code_borrow');
        $borrow = DB::table('borrows')->where('code', $code)->first();
        $location = (string) $res->headers->get('Location');

        $actual = [
            'http' => $res->getStatusCode(),
            'lokasi' => $location,
            'kode_borrow' => $code,
            'status' => $borrow->status ?? null,
        ];
        $pass = $res->getStatusCode() === 302
            && str_contains($location, '/cart')
            && $code !== ''
            && $borrow !== null
            && (string) $borrow->status === '0';

        $this->recordEvidence('INT-01', ['student@gmail.com'], 'redirect /cart, borrows bertambah dengan status 0, session code_borrow terisi', json_encode($actual, JSON_UNESCAPED_UNICODE), $pass, 'Dafit');
        $this->assertTrue($pass, 'INT-01 gagal: transaksi borrow tidak terbentuk sesuai expected.');
    }

    public function test_int_02_add_cart_menambah_detail_dan_stok_dipinjam(): void
    {
        $user = $this->anggota();
        $this->buku();
        $code = $this->mulaiPinjam($user);

        $this->post('/add-cart', ['code' => 'BK-001', 'code_user' => 'U-001']);

        $detail = DB::table('detail_borrows')->where('code_borrow', $code)->where('code_book', 'BK-001')->count();
        $being = DB::table('books')->where('code', 'BK-001')->value('being_borrowed');
        $returnDate = DB::table('borrows')->where('code', $code)->value('return_date');
        $expectedDate = Carbon::today()->addDays(7)->toDateString();

        $actual = ['detail' => $detail, 'being_borrowed' => (int) $being, 'return_date' => $returnDate];
        $pass = $detail === 1 && (int) $being === 1 && substr((string) $returnDate, 0, 10) === $expectedDate;

        $this->recordEvidence('INT-02', ['student@gmail.com', 'BK-001'], 'detail_borrows +1, being_borrowed=1, return_date=H+7', json_encode($actual, JSON_UNESCAPED_UNICODE), $pass, 'Dafit');
        $this->assertTrue($pass, 'INT-02 gagal: add-cart tidak memperbarui detail/stok/tanggal.');
    }

    public function test_int_03_duplikat_buku_ditolak(): void
    {
        $user = $this->anggota();
        $this->buku();
        $code = $this->mulaiPinjam($user);

        // Simulasikan langkah pemilihan anggota yang dilakukan pengguna di UI.
        DB::table('borrows')->where('code', $code)->update(['code_user' => 'U-001']);

        $this->post('/add-cart', ['code' => 'BK-001', 'code_user' => 'U-001']);
        $this->post('/add-cart', ['code' => 'BK-001', 'code_user' => 'U-001']);

        $detail = DB::table('detail_borrows')->where('code_borrow', $code)->where('code_book', 'BK-001')->count();
        $actual = ['jumlah_detail_setelah_dua_kali_submit' => $detail];
        $pass = $detail === 1;

        $this->recordEvidence('INT-03', ['student@gmail.com', 'BK-001', 'submit 2x'], 'jumlah detail tetap 1', json_encode($actual, JSON_UNESCAPED_UNICODE), $pass, 'Dafit');
        $this->assertTrue($pass, 'INT-03 gagal: buku duplikat masuk ke keranjang.');
    }

    public function test_int_04_stok_habis_ditolak(): void
    {
        $user = $this->anggota();
        $this->buku(['stock' => 1, 'being_borrowed' => 1]);
        $code = $this->mulaiPinjam($user);

        $this->post('/add-cart', ['code' => 'BK-001', 'code_user' => 'U-001']);

        $detail = DB::table('detail_borrows')->where('code_borrow', $code)->where('code_book', 'BK-001')->count();
        $actual = ['jumlah_detail' => $detail, 'stok' => 1, 'sedang_dipinjam' => 1];
        $pass = $detail === 0;

        $this->recordEvidence('INT-04', ['student@gmail.com', 'BK-001', 'stock=1, being_borrowed=1'], 'ditolak, tidak ada detail baru', json_encode($actual, JSON_UNESCAPED_UNICODE), $pass, 'Dafit');
        $this->assertTrue($pass, 'INT-04 gagal: buku dengan stok habis tetap bisa ditambahkan.');
    }

    public function test_int_05_selesai_pinjam_mengubah_status(): void
    {
        $user = $this->anggota();
        $this->buku();
        $code = $this->mulaiPinjam($user);

        $this->post('/add-cart', ['code' => 'BK-001', 'code_user' => 'U-001']);
        $this->post('/add-borrow', ['return_date' => 14]);

        $status = DB::table('borrows')->where('code', $code)->value('status');
        $sessionMasihAda = session()->has('code_borrow');
        $actual = ['status' => $status, 'session_code_borrow_masih_ada' => $sessionMasihAda];
        $pass = (string) $status === '1' && !$sessionMasihAda;

        $this->recordEvidence('INT-05', ['student@gmail.com', 'BK-001', 'return_date=14'], 'status=1 dan session code_borrow dihapus', json_encode($actual, JSON_UNESCAPED_UNICODE), $pass, 'Dafit');
        $this->assertTrue($pass, 'INT-05 gagal: peminjaman tidak diselesaikan dengan benar.');
    }
}
