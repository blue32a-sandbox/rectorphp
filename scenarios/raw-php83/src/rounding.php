<?php

declare(strict_types=1);

/**
 * 丸め
 */
function demo_rounding(): array
{
    // PHP 8.4 で RoundingMode 列挙型が追加（PHP_ROUND_* 定数の代わり）
    return [
        'half up'   => round(2.5, 0, PHP_ROUND_HALF_UP),
        'half down' => round(2.5, 0, PHP_ROUND_HALF_DOWN),
        'half even' => round(2.5, 0, PHP_ROUND_HALF_EVEN),
        'half odd'  => round(2.5, 0, PHP_ROUND_HALF_ODD),
    ];
}
