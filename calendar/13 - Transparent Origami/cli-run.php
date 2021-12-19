<?php

ini_set("memory_limit", "14G");
// Get input
//$file = trim(file_get_contents('./inputs/testInput.txt'));
$file = trim(file_get_contents('./inputs/input.txt'));
$file = explode(PHP_EOL . PHP_EOL, $file);

// prepare input
$dots = explode(PHP_EOL, $file[0]);
$dots = array_map(function($dot) {
    $coordinates = explode(',', $dot);
    return ['x' => $coordinates[0], 'y' => $coordinates[1]];
}, $dots);
$folds = explode(PHP_EOL, $file[1]);
$folds = array_map(function($fold) {
    $parts = explode(' ', $fold);
    return explode('=', end($parts));
}, $folds);

/** Part One And Two? (Woops) */
// fold the dots
foreach ($folds as $foldDetails) {
    $orientation = $foldDetails[0];
    $foldPosition = $foldDetails[1];
    foreach ($dots as $index => $dot) {
        if ($dot[$orientation] > $foldPosition) {
            $difference = $dot[$orientation] - $foldPosition;
            $dots[$index][$orientation] = $foldPosition - $difference;
        }
    }
}

// prepare the grid
$gridWidth = 0;
$gridHeight = 0;
foreach ($dots as $dot) {
    $gridWidth = max($gridWidth, $dot['x'] + 1);
    $gridHeight = max($gridHeight, $dot['y'] + 1);
}

$output = [];
for ($y = 0; $y < $gridHeight; $y++) {
    for ($x = 0; $x < $gridWidth; $x++) {
        $output[$y][$x] = '.';
    }
}

// place markings on output
foreach ($dots as $dot) {
    $output[$dot['y']][$dot['x']] = '#';
}

// render the output
foreach ($output as $row) {
    echo implode($row) . PHP_EOL;
}

$dotCount = 0;
array_walk_recursive($output, function($value, $key) {
    if ($value === '#') {
        global $dotCount;
        $dotCount++;
    }
    return $value;
});

echo $dotCount;