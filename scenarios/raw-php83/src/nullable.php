<?php

declare(strict_types=1);

/**
 * 引数の型とデフォルト値
 */
final readonly class Greeting
{
    public function __construct(
        private string $prefix,
    ) {
    }

    public function to(string $name): string
    {
        return "{$this->prefix}, {$name}";
    }
}

// PHP 8.4 で非推奨: デフォルト値 null による暗黙の nullable 型 → ?Greeting
function greet(string $name, Greeting $greeting = null): string
{
    $greeting ??= new Greeting('Hello');

    return $greeting->to($name);
}

function demo_nullable(): array
{
    return [
        'default greeting' => greet('alice'),
        'custom greeting'  => greet('bob', new Greeting('Hi')),
        // PHP 8.4 で new の式を括弧で囲まずにメソッドを呼べるようになった
        'chained new'      => (new Greeting('Hey'))->to('carol'),
    ];
}
