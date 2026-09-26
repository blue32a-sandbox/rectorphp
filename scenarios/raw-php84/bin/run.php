<?php

declare(strict_types=1);

require __DIR__ . '/../src/casts.php';
require __DIR__ . '/../src/syntax.php';
require __DIR__ . '/../src/strings.php';
require __DIR__ . '/../src/arrays.php';
require __DIR__ . '/../src/serialization.php';
require __DIR__ . '/../src/extensions.php';

$demos = [
    'casts'         => demo_casts(...),
    'syntax'        => demo_syntax(...),
    'strings'       => demo_strings(...),
    'arrays'        => demo_arrays(...),
    'serialization' => demo_serialization(...),
    'extensions'    => demo_extensions(...),
];

foreach ($demos as $name => $demo) {
    echo "## {$name}", PHP_EOL;
    foreach ($demo() as $label => $value) {
        echo "{$label}: ", var_export($value, true), PHP_EOL;
    }
    echo PHP_EOL;
}
