<?php

declare(strict_types=1);

require __DIR__ . '/../src/classes.php';
require __DIR__ . '/../src/strings.php';
require __DIR__ . '/../src/files.php';
require __DIR__ . '/../src/arrays.php';

$demos = [
    'classes' => demo_classes(...),
    'strings' => demo_strings(...),
    'files'   => demo_files(...),
    'arrays'  => demo_arrays(...),
];

foreach ($demos as $name => $demo) {
    echo "## {$name}", PHP_EOL;
    foreach ($demo() as $label => $value) {
        echo "{$label}: ", var_export($value, true), PHP_EOL;
    }
    echo PHP_EOL;
}
