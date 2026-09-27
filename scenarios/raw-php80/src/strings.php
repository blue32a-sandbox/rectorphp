<?php

declare(strict_types=1);

/**
 * 文字列の変換と日付の書式
 */
function demo_strings(): array
{
    $comment = "It's <b>great</b>";

    return [
        // PHP 8.1 から: 既定のフラグが ENT_QUOTES | ENT_SUBSTITUTE になり、' もエスケープする
        'escaped'   => htmlspecialchars($comment),
        // PHP 8.1 で非推奨: FILTER_SANITIZE_STRING
        'sanitized' => filter_var($comment, FILTER_SANITIZE_STRING),
        // PHP 8.1 で非推奨: strftime()
        'date'      => strftime('%Y/%m/%d', 0),
    ];
}
