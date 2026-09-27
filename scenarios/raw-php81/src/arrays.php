<?php

declare(strict_types=1);

/**
 * 配列の並べ替え
 */
function demo_arrays(): array
{
    // 名前と番号が混ざったキー
    $settings = [
        'b'  => 'beta',
        '2'  => 'two',
        'a'  => 'alpha',
        '10' => 'ten',
    ];
    // PHP 8.2 から: 数値と文字列のキーを PHP 8 の比較規則で並べるため、順序が変わる
    ksort($settings);

    return [
        'sorted keys' => array_keys($settings),
    ];
}
