<?php

declare(strict_types=1);

/**
 * 数値の範囲
 */
function demo_numbers(): array
{
    // フォームなどから文字列で受け取った想定
    $from = '1';
    $to = '5';
    // PHP 8.3 から: 1バイトの文字列同士は文字の範囲として扱われ、要素が文字列になる
    $pages = range($from, $to);

    return [
        'pages' => $pages,
        'has 3' => in_array(3, $pages, true),
    ];
}
