<?php

declare(strict_types=1);

/**
 * クラスの書き方
 *
 * PHP 8.3 で型付きクラス定数、クラス定数の動的な取得（Size::{$name}）が追加
 */
abstract class Shape
{
    abstract public function area(): float;
}

final class Square extends Shape
{
    public const SIDES = 4;

    public function __construct(
        private readonly float $side,
    ) {
    }

    public function area(): float
    {
        return $this->side ** 2;
    }

    public function parentName(): string|false
    {
        // PHP 8.3 で非推奨: get_parent_class() を引数なしで呼ぶ
        return get_parent_class();
    }
}

final class Size
{
    public const SMALL = 'S';
    public const LARGE = 'L';
}

function size_label(string $name): string
{
    return constant(Size::class . '::' . $name);
}

function demo_classes(): array
{
    $square = new Square(3);

    return [
        'area'        => $square->area(),
        'parent name' => $square->parentName(),
        'sides'       => Square::SIDES,
        'size label'  => size_label('LARGE'),
    ];
}
