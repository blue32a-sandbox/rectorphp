<?php

declare(strict_types=1);

require __DIR__ . '/../src/classes.php';
require __DIR__ . '/../src/data.php';
require __DIR__ . '/../src/numbers.php';
require __DIR__ . '/../src/increments.php';
require __DIR__ . '/../src/runtime.php';

$demos = [
    'classes'    => demo_classes(...),
    'data'       => demo_data(...),
    'numbers'    => demo_numbers(...),
    'increments' => demo_increments(...),
    'runtime'    => demo_runtime(...),
];

foreach ($demos as $name => $demo) {
    echo "## {$name}", PHP_EOL;
    foreach ($demo() as $label => $value) {
        echo "{$label}: ", var_export($value, true), PHP_EOL;
    }
    echo PHP_EOL;
}
