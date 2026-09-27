<?php

declare(strict_types=1);

/**
 * 構文
 *
 * PHP 8.0 で削除された構文を含むため、このファイルは PHP 8 以降では読み込めない（構文エラー）
 */
function access_label(bool $isAdmin, bool $isOwner): string
{
    // 管理者か所有者なら許可する（左結合なので ($isAdmin ? true : $isOwner) が先に評価される）
    // PHP 7.4 で非推奨、PHP 8.0 で構文エラー: 括弧のない三項演算子の入れ子（左結合）
    return $isAdmin ? true : $isOwner ? 'allowed' : 'denied';
}

function demo_syntax(): array
{
    $code = 'JP-13';

    // 整数部と小数部を別々に受け取った金額の想定
    $whole = '12';
    $fraction = '50';

    return [
        // PHP 7.4 で非推奨、PHP 8.0 で構文エラー: 波括弧による文字列オフセットの参照
        'first char'   => $code{0},
        // PHP 7.4 で非推奨、PHP 8.0 で削除: (real) キャスト
        'price'        => (real) '19.99',
        'owner'        => access_label(false, true),
        'guest'        => access_label(false, false),
        // 文字列としてつないでから + 0 で数値にする
        // PHP 7.4 で非推奨: . と + を括弧なしで混ぜる（PHP 8.0 で + が先に計算されるようになる）
        'amount'       => $whole . '.' . $fraction + 0,
    ];
}
