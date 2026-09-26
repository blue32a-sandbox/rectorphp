<?php

declare(strict_types=1);

/**
 * 型キャストの書き方
 */
function demo_casts(): array
{
    $input = '42.5';

    // PHP 8.5 で非推奨: (integer) / (boolean) / (double) / (binary) の別名キャスト
    // → (int) / (bool) / (float) / (string)
    return [
        'integer' => (integer) $input,
        'boolean' => (boolean) $input,
        'double'  => (double) $input,
        'binary'  => (binary) $input,
    ];
}
