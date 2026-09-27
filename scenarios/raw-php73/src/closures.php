<?php

declare(strict_types=1);

/**
 * クロージャとデフォルト値
 *
 * PHP 7.4 でアロー関数、null 合体代入演算子（??=）が追加
 */
function demo_closures(): array
{
    $prices = [100, 250, 400];
    $rate = 1.1;

    $withTax = array_map(function ($price) use ($rate) {
        return (int) round($price * $rate);
    }, $prices);

    $options = ['currency' => 'JPY'];
    $options['locale'] = $options['locale'] ?? 'ja_JP';

    return [
        'with tax' => $withTax,
        'options'  => $options,
    ];
}
