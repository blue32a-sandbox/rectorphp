<?php

declare(strict_types=1);

/**
 * シリアライズとデバッグ表示
 */
final class Session
{
    private ?string $token = null;

    public function __construct(
        private readonly string $user,
    ) {
        $this->token = bin2hex(random_bytes(4));
    }

    public function user(): string
    {
        return $this->user;
    }

    public function hasToken(): bool
    {
        return $this->token !== null;
    }

    // PHP 8.5 で __sleep() / __wakeup() から __serialize() / __unserialize() への移行が推奨
    // （実行時の Deprecated 警告は出ない）
    public function __sleep(): array
    {
        // トークンは保存しない
        return ['user'];
    }

    public function __wakeup(): void
    {
        $this->token = null;
    }
}

final readonly class Secret
{
    public function __construct(
        private string $value,
    ) {
    }

    public function __debugInfo(): ?array
    {
        // 値は表示しない
        // PHP 8.5 で非推奨: __debugInfo() から null を返す → 空配列
        return null;
    }
}

function demo_serialization(): array
{
    $session = new Session('alice');
    $serialized = serialize($session);
    $restored = unserialize($serialized);

    // 変換前に保存されたデータ（例: DB やキャッシュに残っているもの）
    $stored = 'O:7:"Session":1:{s:13:"' . "\0" . 'Session' . "\0" . 'user";s:5:"alice";}';
    $fromStorage = unserialize($stored);

    return [
        'serialized'           => str_replace("\0", '\0', $serialized),
        'restored user'        => $restored->user(),
        'restored has token'   => $restored->hasToken(),
        'stored data user'     => $fromStorage->user(),
        'debug info'           => print_r(new Secret('p@ssw0rd'), true),
    ];
}
