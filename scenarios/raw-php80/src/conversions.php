<?php

declare(strict_types=1);

/**
 * 暗黙の型変換
 */
function demo_conversions(): array
{
    // 計算結果を配列のキーに使う想定
    $ratings = [];
    foreach ([4.5, 3.0, 4.8] as $score) {
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
