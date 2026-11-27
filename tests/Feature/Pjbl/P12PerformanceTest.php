<?php

namespace Tests\Feature\Pjbl;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class P12PerformanceTest extends TestCase
{
    use RefreshDatabase, P9Data, RecordsEvidence;

    public function test_p12_profil_waktu_respons_katalog(): void
    {
        $user = $this->anggota();
        $this->buku(['code' => 'BK-001', 'stock' => 5, 'being_borrowed' => 0]);
        $this->actingAs($user);

        $waktu = [];
        for ($i = 0; $i < 20; $i++) {
            $mulai = microtime(true);
            $res = $this->get('/book');
            $waktu[] = microtime(true) - $mulai;
            if ($res->getStatusCode() !== 200) {
                break;
            }
        }

        sort($waktu);
        $rata = array_sum($waktu) / count($waktu);
        $indeksP95 = (int) ceil(0.95 * count($waktu)) - 1;
        $p95 = $waktu[max(0, $indeksP95)];

        $actual = [
            'request' => count($waktu),
            'rata_rata_detik' => round($rata, 4),
            'p95_detik' => round($p95, 4),
            'min_detik' => round($waktu[0], 4),
            'maks_detik' => round($waktu[count($waktu) - 1], 4),
        ];
        $pass = $rata <= 2.0;

        $this->recordEvidence('P12-PERF', ['20 request GET /book', 'lingkungan lokal sqlite'], 'rata-rata maksimal 2 detik dan p95 terukur', json_encode($actual, JSON_UNESCAPED_UNICODE), $pass, 'Ade');
        $this->assertTrue($pass, 'P12-PERF gagal: profil waktu respons tidak memenuhi target.');
    }
}
