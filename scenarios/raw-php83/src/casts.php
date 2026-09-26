<?php

declare(strict_types=1);

/**
 * 型キャストとリソースの解放
 */
function demo_casts(): array
{
    $input = '42.5';

    // curl（通信はしない）
    $curl = curl_init('https://example.com');
    $url = curl_getinfo($curl, CURLINFO_EFFECTIVE_URL);
    // PHP 8.5 で非推奨: curl_close()（PHP 8.0 から何もしない）
    curl_close($curl);

    // PHP 8.5 で非推奨: (integer) / (double) の別名キャスト → (int) / (float)
    return [
        'integer'  => (integer) $input,
        'double'   => (double) $input,
        'curl url' => $url,
    ];
}
