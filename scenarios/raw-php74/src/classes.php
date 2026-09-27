<?php

declare(strict_types=1);

/**
 * クラスの書き方
 *
 * PHP 8.0 でコンストラクタのプロパティ昇格、Stringable インターフェースが追加
 */
final class Money
{
    private int $amount;
    private string $currency;

    public function __construct(int $amount, string $currency)
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function __toString(): string
    {
        return number_format($this->amount) . ' ' . $this->currency;
    }
}

class Report
{
    // PHP 8.0 から: private メソッドに final を付けると Warning
    private final function header(): string
    {
        return '# Report';
    }

    public function render(string $body): string
    {
        return $this->header() . ' / ' . $body;
    }
}

function demo_classes(): array
{
    $money = new Money(1200, 'JPY');
    $report = new Report();

    return [
        'money'  => (string) $money,
        'report' => $report->render('ok'),
    ];
}
