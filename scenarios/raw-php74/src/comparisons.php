<?php

declare(strict_types=1);

/**
 * 文字列と数値の比較
 *
 * PHP 8.0 から: 数値と数値でない文字列を == で比べると、数値を文字列にして比べる
 * （7.4 までは文字列を数値にして比べるので、0 == 'abc' が true になる）
 */
function status_label($status): string
{
    switch ($status) {
        case 'active':
            return 'enabled';
        case 'inactive':
            return 'disabled';
        default:
            return 'unknown';
    }
}

function is_zero($value): bool
{
    return $value == 0;
}

function demo_comparisons(): array
{
    // 未設定のときに 0 が入る値の想定
    $status = 0;
    $input = 'abc';

    return [
        'status label' => status_label($status),
        'is zero'      => is_zero($input),
        'in list'      => in_array($input, [0, 1]),
    ];
}
