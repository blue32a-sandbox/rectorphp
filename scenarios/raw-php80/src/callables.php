<?php

declare(strict_types=1);

/**
 * callable とリフレクション
 *
 * PHP 8.1 で first-class callable（strlen(...)）が追加
 */
final class Slugger
{
    public function slug(string $value): string
    {
        return strtolower(str_replace(' ', '-', $value));
    }

    public function slugAll(array $values): array
    {
        return array_map([$this, 'slug'], $values);
    }
}

final class Secret
{
    public function __construct(
        private string $token,
    ) {
    }
}

function demo_callables(): array
{
    $slugger = new Slugger();
    $upper = Closure::fromCallable('strtoupper');

    $property = new ReflectionProperty(Secret::class, 'token');
    // PHP 8.1 から不要（何もしない）。PHP 8.5 で非推奨
    $property->setAccessible(true);

    return [
        'slugs'  => $slugger->slugAll(['Hello World', 'Rector PHP']),
        'upper'  => $upper('php'),
        'secret' => $property->getValue(new Secret('abc')),
    ];
}
