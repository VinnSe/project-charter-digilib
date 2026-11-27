<?php

namespace Tests\Feature\Pjbl;

trait RecordsEvidence
{
    /**
     * Tulis bukti eksekusi secara otomatis. Dipanggil SEBELUM assertion supaya
     * bukti tetap tersedia walaupun test gagal.
     */
    protected function recordEvidence(
        string $id,
        array $data,
        string $expected,
        string $actual,
        bool $pass,
        string $penguji = 'Tim QA'
    ): void {
        // Label build dikirim dari shell saat eksekusi, bukan diambil via shell_exec,
        // karena PHP di Windows tidak selalu menemukan git di PATH-nya.
        $build = getenv('PJBL_BUILD_LABEL') ?: 'unknown';
        $commit = getenv('PJBL_COMMIT') ?: 'unknown';

        $dir = getenv('PJBL_EVIDENCE_DIR') ?: base_path('portofolio-digilib/03-evidence');
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $payload = [
            'id' => $id,
            'build' => $build,
            'commit' => $commit,
            'data' => $data,
            'expected' => $expected,
            'actual' => $actual,
            'status' => $pass ? 'lulus' : 'gagal',
            'penguji' => $penguji,
            'waktu' => date(DATE_ATOM),
        ];

        file_put_contents(
            $dir . DIRECTORY_SEPARATOR . 'E-' . $id . '.json',
            json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . PHP_EOL
        );
    }
}
