<?php

declare(strict_types=1);

/**
 * 文字列
 *
 * PHP 8.0 で str_contains() / str_starts_with() / str_ends_with() が追加
 */
function demo_strings(): array
{
    $path = '/admin/users';
    $file = 'report.csv';

    // 地域コード（国コードだけのこともある）の想定
    $region = 'JP';
    // PHP 8.0 から: 開始位置が文字列より後ろでも false ではなく '' を返す
    $prefecture = substr($region, 3);

    // フォームから受け取った、末尾に空白がある数字の想定
    $quantity = '42 ';

    return [
        'is admin'   => strpos($path, '/admin') === 0,
        'has users'  => strpos($path, 'users') !== false,
        'is csv'     => substr($file, -4) === '.csv',
        'prefecture' => $prefecture === false ? '(none)' : $prefecture,
        // PHP 8.0 から: 末尾の空白を許して数値の文字列として扱う
        'numeric'    => is_numeric($quantity),
    ];
}
