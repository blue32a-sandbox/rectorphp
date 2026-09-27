<?php

declare(strict_types=1);

require __DIR__ . '/../src/classes.php';
require __DIR__ . '/../src/collection.php';
require __DIR__ . '/../src/callables.php';
require __DIR__ . '/../src/strings.php';
require __DIR__ . '/../src/conversions.php';

$demos = [
    'classes'     => 'demo_classes',
    'collection'  => 'demo_collection',
    'callables'   => 'demo_callables',
    'strings'     => 'demo_strings',
    'conversions' => 'demo_conversions',
];

foreach ($demos as $name => $demo) {
    echo "## {$name}", PHP_EOL;
    foreach ($demo() as $label => $value) {
        echo "{$label}: ", var_export($value, true), PHP_EOL;
    }
    echo PHP_EOL;
}
