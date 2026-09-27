<?php

declare(strict_types=1);

/**
 * 並べ替え
 */
function demo_sorting(): array
{
    $prices = [300, 100, 200];
    // PHP 8.0 で非推奨: 比較関数が bool を返す
    usort($prices, fn ($a, $b) => $a > $b);

    // 登録順に並んだ会員（ランクは gold / silver の2種類）
    $members = [];
    foreach (range(1, 20) as $i) {
        $members[] = ['id' => $i, 'rank' => $i % 2 === 0 ? 'gold' : 'silver'];
    }
    // PHP 8.0 から: 並べ替えが安定になり、同じランクの中では登録順が保たれる
    usort($members, fn ($a, $b) => strcmp($a['rank'], $b['rank']));

    $mixed = ['10', 9, 'abc', 0];
    // PHP 8.0 から: 文字列と数値の比較の変更に合わせて並び順が変わる
    sort($mixed);

    return [
        'prices'  => $prices,
        'members' => implode(',', array_column($members, 'id')),
        'mixed'   => $mixed,
    ];
}
