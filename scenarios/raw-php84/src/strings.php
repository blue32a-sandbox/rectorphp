<?php

declare(strict_types=1);

/**
 * 文字とバイト
 */
function demo_strings(): array
{
    $name = 'あいう';

    return [
        // PHP 8.5 で非推奨: ord() に1バイトでない文字列を渡す
        'ord multibyte' => ord($name),
        // PHP 8.5 で非推奨: chr() に 0〜255 の範囲外の値を渡す
        'chr overflow'  => bin2hex(chr(321)),
    ];
}
