<?php

declare(strict_types=1);

/**
 * ディレクトリの一覧
 */
function demo_files(): array
{
    $dir = sys_get_temp_dir() . '/raw-php81-files';
    if (!is_dir($dir)) {
        mkdir($dir);
    }
    touch("{$dir}/a.txt");
    touch("{$dir}/b.txt");

    // PHP 8.2 から: フラグを指定すると SKIP_DOTS が自動では付かない
    $iterator = new FilesystemIterator($dir, FilesystemIterator::KEY_AS_FILENAME | FilesystemIterator::CURRENT_AS_PATHNAME);
    $names = array_keys(iterator_to_array($iterator));
    sort($names);

    return [
        'files' => $names,
    ];
}
