<?php

declare(strict_types=1);

/**
 * エラー処理と乱数
 */
function demo_errors(): array
{
    // PHP 8.4 で非推奨: E_STRICT 定数（PHP 8.0 から使われていない）
    $level = E_ALL & ~E_STRICT;

    $caught = null;
    set_error_handler(
        function (int $errno, string $message) use (&$caught): bool {
            $caught = $message;

            return true;
        },
        E_USER_ERROR,
    );
    // PHP 8.4 で非推奨: trigger_error() に E_USER_ERROR を渡す → 例外を投げるか exit する
    trigger_error('設定ファイルが見つかりません', E_USER_ERROR);
    restore_error_handler();

    // PHP 8.4 で非推奨: lcg_value() → Random\Randomizer::getFloat() など
    $random = lcg_value();

    return [
        'error level'    => $level,
        'user error'     => $caught,
        'random in 0..1' => $random >= 0 && $random < 1,
    ];
}
