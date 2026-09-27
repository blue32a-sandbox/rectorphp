<?php

declare(strict_types=1);

/**
 * データの検証と復元
 *
 * PHP 8.3 で json_validate() が追加
 */
function is_json(string $value): bool
{
    return json_decode($value, true) !== null && json_last_error() === JSON_ERROR_NONE;
}

function demo_data(): array
{
    // ファイルから読み込んだ想定（末尾に改行が付いている）
    $saved = serialize(['id' => 1, 'name' => 'alice']) . "\n";

    return [
        'valid json'   => is_json('{"id": 1}'),
        'invalid json' => is_json('{id: 1}'),
        'null json'    => is_json('null'),
        // PHP 8.3 から: 末尾に余分なデータがあると unserialize() が Warning を出す
        'restored'     => unserialize($saved),
    ];
}
