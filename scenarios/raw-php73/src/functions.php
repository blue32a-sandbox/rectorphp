<?php

declare(strict_types=1);

/**
 * 非推奨になった関数と使い方
 */
function demo_functions(): array
{
    $user = new stdClass();
    $user->name = 'alice';

    return [
        // PHP 7.4 で非推奨: オブジェクトに array_key_exists() を使う
        'has name'  => array_key_exists('name', $user),
        // PHP 7.4 で非推奨、PHP 8.0 で削除: money_format()
        'amount'    => money_format('%i', 1234.5),
        // PHP 7.4 で非推奨: FILTER_SANITIZE_MAGIC_QUOTES
        'escaped'   => filter_var("O'Reilly", FILTER_SANITIZE_MAGIC_QUOTES),
        // PHP 7.4 で非推奨: mb_strrpos() の3番目の引数にエンコーディングを渡す
        'last dash' => mb_strrpos('JP-13-01', '-', 'UTF-8'),
    ];
}
