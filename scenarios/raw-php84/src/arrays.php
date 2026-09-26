<?php

declare(strict_types=1);

/**
 * 配列
 */
function demo_arrays(): array
{
    $scores = ['alice' => 80, 'bob' => 65, 'carol' => 92];

    $settings = ['' => 'default', 'theme' => 'dark'];
    $key = null;

    return [
        // PHP 8.5 で array_first() / array_last() が追加
        'first'            => $scores[array_key_first($scores)],
        'last'             => $scores[array_key_last($scores)],
        // PHP 8.5 で非推奨: array_key_exists() のキーに null を渡す
        'key exists null'  => array_key_exists($key, $settings),
        // PHP 8.5 で非推奨: null を配列のキーに使う
        'offset null'      => $settings[$key],
    ];
}
