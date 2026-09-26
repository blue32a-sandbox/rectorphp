<?php

declare(strict_types=1);

require __DIR__ . '/../src/nullable.php';
require __DIR__ . '/../src/csv.php';
require __DIR__ . '/../src/rounding.php';
require __DIR__ . '/../src/collections.php';
require __DIR__ . '/../src/errors.php';
require __DIR__ . '/../src/casts.php';

$demos = [
    'nullable'    => demo_nullable(...),
    'csv'         => demo_csv(...),
    'rounding'    => demo_rounding(...),
    'collections' => demo_collections(...),
    'errors'      => demo_errors(...),
    'casts'       => demo_casts(...),
];

foreach ($demos as $name => $demo) {
    echo "## {$name}", PHP_EOL;
    foreach ($demo() as $label => $value) {
        echo "{$label}: ", var_export($value, true), PHP_EOL;
    }
    echo PHP_EOL;
}
