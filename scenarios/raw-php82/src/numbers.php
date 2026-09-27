<?php

declare(strict_types=1);

/**
 * 数値の書式と範囲
 */
function demo_numbers(): array
{
    // フォームなどから文字列で受け取った想定
    $from = '1';
    $to = '5';
    // PHP 8.3 から: 1バイトの文字列同士は文字の範囲として扱われ、要素が文字列になる
    $pages = range($from, $to);

    return [
        // PHP 8.3 から: 負の桁数で整数部を丸める（8.2 までは 0 桁と同じ）
        'hundreds' => number_format(1234.5678, -2),
        'pages'    => $pages,
        'has 3'    => in_array(3, $pages, true),
    ];
}
