<?php

ini_set("memory_limit", "14G");
// Get input
//$file = trim(file_get_contents('./inputs/testInput.txt'));
$file = trim(file_get_contents('./inputs/input.txt'));

$octopuses = explode(PHP_EOL, $file);
$octopuses = array_map(fn($row) => str_split($row), $octopuses);

/** Part One */
/*$steps = 1;
$flashCount = 0;
while ($steps <= 100) {
    $flashes = 0;
    // Increase each octopus by 1
    foreach ($octopuses as $row => $columns) {
        foreach ($columns as $column => $octopus) {
            $octopuses[$row][$column]++;
        }
    }
    // Flash Cascade
    $highestOctopus = 10;
    while ($highestOctopus >= 10) {
        $highestOctopus = 0;
        foreach ($octopuses as $row => $columns) {
            foreach ($columns as $column => $octopus) {
                if ($octopus >= 10) {
                    $octopuses[$row][$column] = 'F';
                    // Top Left
                    if (isset($octopuses[$row - 1][$column - 1]) && $octopuses[$row - 1][$column - 1] !== 'F') {
                        $octopuses[$row - 1][$column - 1]++;
                    }
                    // Top Middle
                    if (isset($octopuses[$row - 1][$column]) && $octopuses[$row - 1][$column] !== 'F') {
                        $octopuses[$row - 1][$column]++;
                    }
                    // Top Right
                    if (isset($octopuses[$row - 1][$column + 1]) && $octopuses[$row - 1][$column + 1] !== 'F') {
                        $octopuses[$row - 1][$column + 1]++;
                    }
                    // Left
                    if (isset($octopuses[$row][$column - 1]) && $octopuses[$row][$column - 1] !== 'F') {
                        $octopuses[$row][$column - 1]++;
                    }
                    // Right
                    if (isset($octopuses[$row][$column + 1]) && $octopuses[$row][$column + 1] !== 'F') {
                        $octopuses[$row][$column + 1]++;
                    }
                    // Bottom Left
                    if (isset($octopuses[$row + 1][$column - 1]) && $octopuses[$row + 1][$column - 1] !== 'F') {
                        $octopuses[$row + 1][$column - 1]++;
                    }
                    // Bottom Middle
                    if (isset($octopuses[$row + 1][$column]) && $octopuses[$row + 1][$column] !== 'F') {
                        $octopuses[$row + 1][$column]++;
                    }
                    // Bottom Right
                    if (isset($octopuses[$row + 1][$column + 1]) && $octopuses[$row + 1][$column + 1] !== 'F') {
                        $octopuses[$row + 1][$column + 1]++;
                    }
                }
            }
        }

        foreach ($octopuses as $row => $columns) {
            foreach ($columns as $column => $octopus) {
                $highestOctopus = max($octopus, $highestOctopus);
            }
        }
    }

    foreach ($octopuses as $row => $columns) {
        foreach ($columns as $column => $octopus) {
            if ($octopus === 'F') {
                $flashCount++;
                $octopuses[$row][$column] = 0;
            }
        }
    }
    $steps++;
}

foreach ($octopuses as $row) {
    echo implode($row) . PHP_EOL;
}
echo "Flashes: $flashCount" . PHP_EOL . PHP_EOL;*/

/** Part Two */
$steps = 1;
$flashCount = 0;
while (true) {
    $flashes = 0;
    // Increase each octopus by 1
    foreach ($octopuses as $row => $columns) {
        foreach ($columns as $column => $octopus) {
            $octopuses[$row][$column]++;
        }
    }
    // Flash Cascade
    $highestOctopus = 10;
    while ($highestOctopus >= 10) {
        $highestOctopus = 0;
        foreach ($octopuses as $row => $columns) {
            foreach ($columns as $column => $octopus) {
                if ($octopus >= 10) {
                    $octopuses[$row][$column] = 'F';
                    // Top Left
                    if (isset($octopuses[$row - 1][$column - 1]) && $octopuses[$row - 1][$column - 1] !== 'F') {
                        $octopuses[$row - 1][$column - 1]++;
                    }
                    // Top Middle
                    if (isset($octopuses[$row - 1][$column]) && $octopuses[$row - 1][$column] !== 'F') {
                        $octopuses[$row - 1][$column]++;
                    }
                    // Top Right
                    if (isset($octopuses[$row - 1][$column + 1]) && $octopuses[$row - 1][$column + 1] !== 'F') {
                        $octopuses[$row - 1][$column + 1]++;
                    }
                    // Left
                    if (isset($octopuses[$row][$column - 1]) && $octopuses[$row][$column - 1] !== 'F') {
                        $octopuses[$row][$column - 1]++;
                    }
                    // Right
                    if (isset($octopuses[$row][$column + 1]) && $octopuses[$row][$column + 1] !== 'F') {
                        $octopuses[$row][$column + 1]++;
                    }
                    // Bottom Left
                    if (isset($octopuses[$row + 1][$column - 1]) && $octopuses[$row + 1][$column - 1] !== 'F') {
                        $octopuses[$row + 1][$column - 1]++;
                    }
                    // Bottom Middle
                    if (isset($octopuses[$row + 1][$column]) && $octopuses[$row + 1][$column] !== 'F') {
                        $octopuses[$row + 1][$column]++;
                    }
                    // Bottom Right
                    if (isset($octopuses[$row + 1][$column + 1]) && $octopuses[$row + 1][$column + 1] !== 'F') {
                        $octopuses[$row + 1][$column + 1]++;
                    }
                }
            }
        }

        foreach ($octopuses as $row => $columns) {
            foreach ($columns as $column => $octopus) {
                $highestOctopus = max($octopus, $highestOctopus);
            }
        }
    }

    $newFlashes = 0;
    foreach ($octopuses as $row => $columns) {
        foreach ($columns as $column => $octopus) {
            if ($octopus === 'F') {
                $newFlashes++;
                $octopuses[$row][$column] = 0;
            }
        }
    }
    if ($newFlashes === 100) {
        break;
    }
    $steps++;
}

echo $steps;