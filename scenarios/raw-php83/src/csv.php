<?php

declare(strict_types=1);

/**
 * CSV
 */
function demo_csv(): array
{
    $rows = [
        ['id', 'name', 'note'],
        [1, 'alice', 'say "hi"'],
        [2, 'bob', 'C:\\path\\'],
    ];

    $stream = fopen('php://memory', 'r+');
    foreach ($rows as $row) {
        // PHP 8.4 で非推奨: escape 引数を省略する（既定値 "\\" に頼る）
        fputcsv($stream, $row);
    }
    rewind($stream);
    $csv = stream_get_contents($stream);
    fclose($stream);

    $lines = explode("\n", trim($csv));

    return [
        'csv'          => $csv,
        // PHP 8.4 で非推奨: escape 引数を省略する（既定値 "\\" に頼る）
        'parsed row 1' => str_getcsv($lines[1]),
        'parsed row 2' => str_getcsv($lines[2]),
    ];
}
