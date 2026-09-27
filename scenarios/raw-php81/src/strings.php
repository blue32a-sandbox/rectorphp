<?php

declare(strict_types=1);

/**
 * 文字列
 */
function demo_strings(): array
{
    $name = 'alice';
    // PHP 8.2 で非推奨: "${var}" 形式の埋め込み
    $greeting = "Hello, ${name}";

    // 外部から受け取った Latin-1 の文字列の想定
    $latin1 = "caf\xE9";
    // PHP 8.2 で非推奨: utf8_encode() / utf8_decode()
    $utf8 = utf8_encode($latin1);

    // PHP 8.2 で非推奨: mbstring で HTML エンティティを扱う
    $html = mb_convert_encoding('café €', 'HTML-ENTITIES', 'UTF-8');

    // 入力が空だった場合の想定（空なら先頭の文字も空文字列になる）
    $code = '';
    // PHP 8.2 から: 空文字列を渡すと空の配列を返す（8.1 までは [''] を返す）
    $chars = str_split($code);

    return [
        'greeting'   => $greeting,
        'utf8'       => $utf8,
        'round trip' => utf8_decode($utf8) === $latin1,
        'html'       => $html,
        'first char' => $chars[0],
    ];
}
