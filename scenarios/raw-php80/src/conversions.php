<?php

declare(strict_types=1);

/**
 * 暗黙の型変換
 */
function demo_conversions(): array
{
    // 評価（小数）を星の数（整数部）ごとに数える想定
    $ratings = [];
    foreach ([4.5, 3.0, 4.8] as $score) {
        // float のキーは小数部が切り捨てられて int になる
        // PHP 8.1 で非推奨: 小数部のある float を int のキーに暗黙に変換する
        $ratings[$score] = ($ratings[$score] ?? 0) + 1;
    }

    // 見つからなかったときに false を返す関数の結果を受け取った想定
    $tags = false;
    // PHP 8.1 で非推奨: false を配列として使い、自動で配列に変換する
    $tags[] = 'new';

    return [
        'ratings' => $ratings,
        'tags'    => $tags,
    ];
}
