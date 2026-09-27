<?php

declare(strict_types=1);

/**
 * クラスとオブジェクト
 *
 * PHP 8.2 で readonly クラスが追加
 */
final class Money
{
    public function __construct(
        public readonly int $amount,
        public readonly string $currency,
    ) {
    }

    public function format(): string
    {
        return number_format($this->amount) . ' ' . $this->currency;
    }
}

final class Profile
{
    public function __construct(
        public string $name,
    ) {
    }
}

final class Formatter
{
    public static function bracket(string $value): string
    {
        return "[{$value}]";
    }

    public function applyAll(string $method, array $values): array
    {
        // PHP 8.2 で非推奨: "self::method" 形式の callable
        return array_map("self::{$method}", $values);
    }
}

function demo_classes(): array
{
    $price = new Money(1200, 'JPY');

    $profile = new Profile('alice');
    // PHP 8.2 で非推奨: 宣言していないプロパティ（動的プロパティ）を作る
    $profile->nickname = 'ali';

    $formatter = new Formatter();

    return [
        'price'    => $price->format(),
        'nickname' => $profile->nickname,
        'brackets' => $formatter->applyAll('bracket', ['a', 'b']),
    ];
}
