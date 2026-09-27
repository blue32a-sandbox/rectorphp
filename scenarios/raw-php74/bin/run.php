<?php

declare(strict_types=1);

require __DIR__ . '/../src/classes.php';
require __DIR__ . '/../src/strings.php';
require __DIR__ . '/../src/comparisons.php';
require __DIR__ . '/../src/sorting.php';
require __DIR__ . '/../src/types.php';
require __DIR__ . '/../src/runtime.php';

$demos = [
    'classes'     => 'demo_classes',
    'strings'     => 'demo_strings',
    'comparisons' => 'demo_comparisons',
    'sorting'     => 'demo_sorting',
    'types'       => 'demo_types',
    'runtime'     => 'demo_runtime',
];

foreach ($demos as $name => $demo) {
    echo "## {$name}", PHP_EOL;
    foreach ($demo() as $label => $value) {
        echo "{$label}: ", var_export($value, true), PHP_EOL;
    }
    echo PHP_EOL;
}
