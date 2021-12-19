<?php

ini_set("memory_limit", "14G");
// Get input
//$file = trim(file_get_contents('./inputs/testInput.txt'));
$file = trim(file_get_contents('./inputs/input.txt'));

/** Part One */
/*$heightMap = explode(PHP_EOL, $file);
foreach ($heightMap as $row => $columns) {
    $heightMap[$row] = str_split($columns);
}

$lowPoints = [];
foreach ($heightMap as $row => $columns) {
    foreach ($columns as $column => $height) {
        $up = $row !== 0 ? $heightMap[$row - 1][$column] : 9;
        $left = $column !== 0 ? $columns[$column - 1] : 9;
        $right = $column !== count($columns) - 1 ? $columns[$column + 1] : 9;
        $down = $row !== count($heightMap) - 1 ? $heightMap[$row + 1][$column] : 9;
        if (
            $height < $up
            && $height < $left
            && $height < $right
            && $height < $down
        ) {
            $lowPoints[] = $height;
        }
    }
}

$sum = 0;
foreach ($lowPoints as $height) {
    $sum += $height + 1;
}

echo $sum;*/

/** Part Two */
$heightMap = explode(PHP_EOL, $file);
foreach ($heightMap as $row => $columns) {
    $heightMap[$row] = str_split($columns);
}

$basins = [];
foreach ($heightMap as $row => $columns) {
    foreach ($columns as $col => $height) {
        if ($height === "9") {
            continue;
        }

        $pos = [$row, $col];

        $existingBasin = false;
        // Check if position already exists in a basin
        foreach ($basins as $basin => $positions) {
            if (in_array($pos, $positions)) {
                $existingBasin = true;
                break;
            }
        }

        // If not, create a new basin recursively
        if (!$existingBasin) {
            $newBasin = count($basins);
            $basins[$newBasin] = [];

            $positionsToCheck = [$pos];
            while (!empty($positionsToCheck)) {
                foreach ($positionsToCheck as $index => $position) {
                    if (!in_array($position, $basins[$newBasin])) {
                        $basins[$newBasin][] = $position;
                    }
                    unset($positionsToCheck[$index]);

                    // Determine valid adjacent positions
                    $upPos = [$position[0] - 1, $position[1]];
                    if (
                        $position[0] !== 0
                        && $heightMap[$upPos[0]][$upPos[1]] !== "9"
                        && !in_array($upPos, $basins[$newBasin])
                    ) {
                        $positionsToCheck[] = $upPos;
                    }

                    $leftPos = [$position[0], ($position[1] - 1)];
                    if (
                        $position[1] !== 0
                        && $heightMap[$leftPos[0]][$leftPos[1]] !== "9"
                        && !in_array($leftPos, $basins[$newBasin])
                    ) {
                        $positionsToCheck[] = $leftPos;
                    }

                    $rightPos = [$position[0], ($position[1] + 1)];
                    if (
                        $position[1] !== count($columns) - 1
                        && $heightMap[$rightPos[0]][$rightPos[1]] !== "9"
                        && !in_array($rightPos, $basins[$newBasin])
                    ) {
                        $positionsToCheck[] = $rightPos;
                    }

                    $downPos = [($position[0] + 1), $position[1]];
                    if (
                        $position[0] !== count($heightMap) - 1
                        && $heightMap[$downPos[0]][$downPos[1]] !== "9"
                        && !in_array($downPos, $basins[$newBasin])
                    ) {
                        $positionsToCheck[] = $downPos;
                    }
                }
            }
        }
    }
}

$basinSizes = [];
foreach ($basins as $basin => $positions) {
    $basinSizes[$basin] = count($positions);
}
sort($basinSizes);
echo json_encode($basinSizes);

$length = count($basinSizes) - 1;
echo $basinSizes[$length] * $basinSizes[$length - 1] * $basinSizes[$length - 2];