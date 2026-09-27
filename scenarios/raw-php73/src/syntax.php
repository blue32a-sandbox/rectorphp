<?php

declare(strict_types=1);

/**
 * 構文
 *
 * PHP 8.0 で削除された構文を含むため、このファイルは PHP 8 以降では読み込めない（構文エラー）
 */
function size_label(int $count): string
{
    // PHP 7.4 で非推奨、PHP 8.0 で構文エラー: 括弧のない三項演算子の入れ子（左結合）
    return $count > 10 ? 'large' : $count > 3 ? 'medium' : 'small';
}

function demo_syntax(): array
{
    $code = 'JP-13';
    $version = '1.';
    $minor = 2;

    return [
        // PHP 7.4 で非推奨、PHP 8.0 で構文エラー: 波括弧による文字列オフセットの参照
        'first char'   => $code{0},
        // PHP 7.4 で非推奨、PHP 8.0 で削除: (real) キャスト
        'price'        => (real) '19.99',
        'size of 5'    => size_label(5),
        'size of 20'   => size_label(20),
        // PHP 7.4 で非推奨: . と + を括弧なしで混ぜる（PHP 8.0 で + が先に計算されるようになる）
        'next version' => $version . $minor + 1,
    ];
}
