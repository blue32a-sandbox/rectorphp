<?php

declare(strict_types=1);

/**
 * 構文
 */
function demo_syntax(): array
{
    $results = [];
    foreach (['draft', 'published', 'other'] as $status) {
        // PHP 8.5 で非推奨: case / default の後のセミコロン（;）→ コロン（:）
        switch ($status) {
            case 'draft';
                $label = '下書き';
                $editable = true;
                break;
            case 'published';
                $label = '公開';
                $editable = false;
                break;
            default;
                $label = '不明';
                $editable = false;
        }
        $results["switch {$status}"] = "{$label} (editable: " . var_export($editable, true) . ')';
    }

    // PHP 8.5 で非推奨: バッククォート演算子 → shell_exec()
    $results['backticks'] = trim(`echo hello`);

    return $results;
}
