<?php

namespace Tests\Feature\Pjbl;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class P9AcceptanceTest extends TestCase
{
    use RefreshDatabase, P9Data, RecordsEvidence;

    public function test_ac_1_anggota_memulai_peminjaman(): void
    {
        $user = $this->anggota();
        $this->actingAs($user);

        $res = $this->get('/borrow');
        $code = (string) session('code_borrow');
        $ada = DB::table('borrows')->where('code', $code)->exists();
        $pass = $res->getStatusCode() === 302 && str_contains((string) $res->headers->get('Location'), '/cart') && $ada;

        $this->recordEvidence('AC-01', ['student@gmail.com'], 'Diberikan akun anggota, ketika membuka /borrow, maka transaksi dibuat dan diarahkan ke /cart', 'http=' . $res->getStatusCode() . ', transaksi=' . ($ada ? 'ada' : 'tidak ada'), $pass, 'Fathan');
        $this->assertTrue($pass, 'AC-01 tidak terpenuhi.');
    }

    public function test_ac_2_buku_muncul_di_keranjang(): void
    {
        $user = $this->anggota();
        $this->buku();
        $this->mulaiPinjam($user);

        $this->post('/add-cart', ['code' => 'BK-001', 'code_user' => 'U-001']);
        $html = $this->get('/cart')->getContent();
        $muncul = str_contains($html, 'BK-001');
        $being = DB::table('books')->where('code', 'BK-001')->value('being_borrowed');
        $pass = $muncul && (int) $being === 1;

        $this->recordEvidence('AC-02', ['student@gmail.com', 'BK-001'], 'Diberikan buku tersedia, ketika ditambah ke keranjang, maka muncul di /cart dan Dipinjam +1', 'muncul=' . ($muncul ? 'ya' : 'tidak') . ', being_borrowed=' . $being, $pass, 'Fathan');
        $this->assertTrue($pass, 'AC-02 tidak terpenuhi.');
    }

    public function test_ac_3_anggota_ditolak_di_halaman_admin(): void
    {
        $user = $this->anggota();
        $this->actingAs($user);

        $res = $this->get('/add-book');
        $pass = $res->getStatusCode() === 403;

        $this->recordEvidence('AC-03', ['student@gmail.com'], 'Diberikan akun anggota, ketika membuka /add-book, maka ditolak dengan 403', 'http=' . $res->getStatusCode(), $pass, 'Fathan');
        $this->assertTrue($pass, 'AC-03 tidak terpenuhi.');
    }
}
