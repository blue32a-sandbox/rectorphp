<?php

declare(strict_types=1);

/**
 * クラスの書き方
 *
 * PHP 8.1 で readonly プロパティが追加
 */
final class Order
{
    public function __construct(
        private string $id,
        private int $total,
    ) {
    }

    public function summary(): string
    {
        return "{$this->id}: {$this->total}";
    }
}

class Sequence
{
    public function next(): int
    {
        static $count = 0;

        return ++$count;
    }
}

final class InvoiceSequence extends Sequence
{
}

function demo_classes(): array
{
    $order = new Order('A-1', 1200);

    $orders = new Sequence();
    $orders->next();
    $orders->next();
    $invoices = new InvoiceSequence();

    return [
        'summary'      => $order->summary(),
        // PHP 8.1 から: メソッド内の static 変数を子クラスと共有する（8.0 までは別々）
        'invoice next' => $invoices->next(),
    ];
}
