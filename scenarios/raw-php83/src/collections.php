<?php

declare(strict_types=1);

/**
 * 配列の検索
 *
 * PHP 8.4 で array_find() / array_find_key() / array_any() / array_all() が追加
 */
function first_adult(array $users): ?array
{
    $found = null;
    foreach ($users as $user) {
        if ($user['age'] >= 20) {
            $found = $user;
            break;
        }
    }

    return $found;
}

function first_adult_key(array $users): int|string|null
{
    foreach ($users as $key => $user) {
        if ($user['age'] >= 20) {
            return $key;
        }
    }

    return null;
}

function has_admin(array $users): bool
{
    foreach ($users as $user) {
        if ($user['role'] === 'admin') {
            return true;
        }
    }

    return false;
}

function all_active(array $users): bool
{
    foreach ($users as $user) {
        if (!$user['active']) {
            return false;
        }
    }

    return true;
}

function demo_collections(): array
{
    $users = [
        'u1' => ['name' => 'alice', 'age' => 17, 'role' => 'member', 'active' => true],
        'u2' => ['name' => 'bob',   'age' => 24, 'role' => 'admin',  'active' => true],
        'u3' => ['name' => 'carol', 'age' => 31, 'role' => 'member', 'active' => false],
    ];

    return [
        'first adult'     => first_adult($users)['name'],
        'first adult key' => first_adult_key($users),
        'has admin'       => has_admin($users),
        'all active'      => all_active($users),
    ];
}
