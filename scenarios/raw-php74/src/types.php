<?php

declare(strict_types=1);

/**
 * 型の情報
 *
 * PHP 8.0 で get_debug_type() が追加
 */
function describe($value): string
{
    return is_object($value) ? get_class($value) : gettype($value);
}

function schedule(DateTimeInterface $at): string
{
    return $at->format('Y-m-d');
}

function demo_types(): array
{
    $param = new ReflectionParameter('schedule', 0);

    return [
        'object' => describe(new DateTimeImmutable('2020-01-01')),
        'int'    => describe(42),
        // PHP 8.0 で非推奨: ReflectionParameter::getClass()
        'param'  => $param->getClass()->getName(),
    ];
}
