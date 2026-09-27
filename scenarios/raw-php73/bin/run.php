<?php

declare(strict_types=1);

require __DIR__ . '/../src/syntax.php';
require __DIR__ . '/../src/functions.php';
require __DIR__ . '/../src/closures.php';
require __DIR__ . '/../src/conversions.php';

$demos = [
    'syntax'      => 'demo_syntax',
    'functions'   => 'demo_functions',
    'closures'    => 'demo_closures',
    'conversions' => 'demo_conversions',
];

foreach ($demos as $name => $demo) {
    echo "## {$name}", PHP_EOL;
    foreach ($demo() as $label => $value) {
        echo "{$label}: ", var_export($value, true), PHP_EOL;
    }
    echo PHP_EOL;
}
