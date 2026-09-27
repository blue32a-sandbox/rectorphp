<?php

declare(strict_types=1);

/**
 * 文字列と数値の比較
 *
 * PHP 8.0 から: 数値と数値でない文字列を == で比べると、数値を文字列にして比べる
 * （7.4 までは文字列を数値にして比べるので、'' == 0 が true になる）
 */
function quantity_label($quantity): string
{
    switch ($quantity) {
        case 0:
            return 'none';
        case 1:
            return 'single';
        default:
            return 'multiple';
    }
}

function is_zero($value): bool
{
    return $value == 0;
}

function demo_comparisons(): array
{
    // フォームから受け取った数量の想定（空欄は 0 として扱う）
    $empty = '';
    $one = '1';

    return [
        'label of empty' => quantity_label($empty),
        'label of one'   => quantity_label($one),
        'empty is zero'  => is_zero($empty),
    ];
}
