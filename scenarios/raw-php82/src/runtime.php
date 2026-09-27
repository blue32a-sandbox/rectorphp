<?php

declare(strict_types=1);

/**
 * 実行時の設定、乱数、リフレクション
 */
final class Counter
{
    public static int $count = 0;
}

function demo_runtime(): array
{
    // PHP 8.3 で非推奨: assert_options() と ASSERT_* 定数
    $assertActive = assert_options(ASSERT_ACTIVE);

    // PHP 8.3 で非推奨: MT_RAND_PHP（偏りのある古い実装）
    mt_srand(42, MT_RAND_PHP);
    $dice = mt_rand(1, 6);

    $property = new ReflectionProperty(Counter::class, 'count');
    // PHP 8.3 で非推奨: 静的プロパティの setValue() に値だけを渡す
    $property->setValue(10);

    return [
        'assert active' => $assertActive,
        'dice'          => $dice,
        'counter'       => Counter::$count,
    ];
}
