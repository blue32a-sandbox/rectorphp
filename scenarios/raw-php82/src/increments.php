<?php

declare(strict_types=1);

/**
 * 文字列のインクリメント・デクリメント
 *
 * PHP 8.3 で str_increment() / str_decrement() が追加
 */
function next_code(string $code): string
{
    // PHP 8.5 で非推奨: 英数字の文字列に ++ を使う
    $code++;

    return $code;
}

function demo_increments(): array
{
    $count = '';
    foreach (['a', 'b', 'c'] as $item) {
        // PHP 8.3 で非推奨: 空文字列に ++ を使う
        $count++;
    }

    $version = 'rc2';
    // PHP 8.3 で非推奨: 数値でない文字列に -- を使う（何も起きない）
    $version--;

    return [
        'next code' => next_code('Az'),
        'count'     => $count,
        'version'   => $version,
    ];
}
