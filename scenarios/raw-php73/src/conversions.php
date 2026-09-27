<?php

declare(strict_types=1);

/**
 * 値の変換と配列の参照
 */
function find_user(array $users, string $name)
{
    foreach ($users as $user) {
        if ($user['name'] === $name) {
            return $user;
        }
    }

    return false;
}

function demo_conversions(): array
{
    // 外部から受け取った色コードの想定（先頭に # が付いている）
    $color = '#ff8800';

    $users = [['name' => 'alice', 'role' => 'admin']];
    $found = find_user($users, 'bob');

    $hash = password_hash('secret', PASSWORD_BCRYPT);

    return [
        // PHP 7.4 で非推奨: 変換できない文字（#）を含む値を渡す
        'red'        => hexdec(substr($color, 0, 3)),
        // PHP 7.4 から Notice: false や null を配列として参照する
        'role'       => $found['role'],
        // PHP 7.4 から: パスワードのアルゴリズムの識別子が整数から文字列になる
        'is bcrypt'  => password_get_info($hash)['algo'] === 1,
    ];
}
