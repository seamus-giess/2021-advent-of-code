<?php

ini_set("memory_limit", "14G");
// Get input
//$file = trim(file_get_contents('./inputs/testInput.txt'));
$file = trim(file_get_contents('./inputs/input.txt'));

$grid = explode(PHP_EOL, $file);
$grid = array_map(fn($row) => str_split($row), $grid);

/** Part One */
//// Initialise helper variables for exploration assistance (edge detection)
//$gridWidth = count($grid[0]);
//$gridHeight = count($grid);
//
//// Initialise tracking for shortest path deduction
//$cellShortestPaths = [];
//$cellShortestPaths[0][0] = 0;
//
//// These are utility arrays for back tracking and loop prevention
//// Their values will be initialised as arrays to mirror the grid's position definitions
//$cellOrigins = [];
//$cellVisited = [];
//
//$pathFound = false;
//
//$x = 0;
//$y = 0;
//$count = 0;
//function exploreCell($newX, $newY) {
//    // Arrays are access [row][col], so [$y][$x].
//    // Going to try and keep all other logic $x, $y.
//    global $grid;
//    global $x;
//    global $y;
//    global $cellShortestPaths;
//    global $cellOrigins;
//    global $cellVisited;
//
//    $newWeight = $grid[$newY][$newX] + $cellShortestPaths[$y][$x];
//    if (!isset($cellShortestPaths[$newY][$newX])) {
//        $previousWeight = INF;
//    } else {
//        $previousWeight = $cellShortestPaths[$newY][$newX];
//    }
//    $newWeightIsLess = $previousWeight > $newWeight;
//    $cellNotVisited = !isset($cellVisited[$newY][$newX]);
//    if ( $newWeightIsLess && $cellNotVisited ) {
//        $cellShortestPaths[$newY][$newX] = $newWeight;
//        $cellOrigins[$newY][$newX] = [$x, $y];
//    }
//}
//
//$shortestPathWeight = INF;
//while (!$pathFound) {
//    /** Exploration phase */
//    // Explore x + 1
//    if ($x < $gridWidth - 1) {
//        exploreCell($x + 1, $y);
//    }
//    // Explore x - 1
//    if ($x > 0) {
//        exploreCell($x - 1, $y);
//    }
//    // Explore y + 1
//    if ($y < $gridHeight - 1) {
//        exploreCell($x, $y + 1);
//    }
//    // Explore y - 1
//    if ($y > 0) {
//        exploreCell($x, $y - 1);
//    }
//
//    $cellVisited[$y][$x] = true;
//
//    // Find the shortest path
//    $shortestPathWeight = INF;
//    foreach ($cellShortestPaths as $pathY => $row) {
//        foreach ($row as $pathX => $weight) {
//            if (isset($cellVisited[$pathY][$pathX])) {
//                continue;
//            }
//            if ($weight < $shortestPathWeight) {
//                $shortestPathWeight = $weight;
//                $x = $pathX;
//                $y = $pathY;
//            }
//        }
//    }
//    // exit if we've made it to the final destination with the shortest path.
//    if (
//        $x === $gridWidth - 1
//        && $y === $gridHeight - 1
//    ) {
//        $pathFound = true;
//    }
//}
//
//echo "Finished! Shortest path has a risk of: $shortestPathWeight";

/** Part Two */
// Initialise helper variables for exploration assistance (edge detection)
$gridWidth = count($grid[0]);
$gridHeight = count($grid);

$newGrid = [];
for ($tileRow = 0; $tileRow < 5; $tileRow++) {
    for ($tileCol = 0; $tileCol < 5; $tileCol++) {
        foreach ($grid as $y => $gridColumns) {
            if ($y >= $gridHeight) {
                continue;
            }
            foreach ($gridColumns as $x => $risk) {
                if ($x >= $gridWidth) {
                    continue;
                }
                $tileY = $gridHeight * $tileRow;
                $tileX = $gridWidth * $tileCol;

                $newRisk = (($risk + $tileRow + $tileCol - 1) + 9) % 9 + 1;

                $grid[$y + $tileY][$x + $tileX] = $newRisk;
            }
        }
    }
}

$gridWidth = count($grid[0]);
$gridHeight = count($grid);

// Initialise tracking for shortest path deduction
$cellShortestPaths = [];
$cellShortestPaths[0][0] = 0;

// These are utility arrays for back tracking and loop prevention
// Their values will be initialised as arrays to mirror the grid's position definitions
$cellOrigins = [];
$cellVisited = [];

$pathFound = false;

$x = 0;
$y = 0;
$count = 0;
function exploreCell($newX, $newY) {
    // Arrays are access [row][col], so [$y][$x].
    // Going to try and keep all other logic $x, $y.
    global $grid;
    global $x;
    global $y;
    global $cellShortestPaths;
    global $cellOrigins;
    global $cellVisited;

    $newWeight = $grid[$newY][$newX] + $cellShortestPaths[$y][$x];
    if (!isset($cellShortestPaths[$newY][$newX])) {
        $previousWeight = INF;
    } else {
        $previousWeight = $cellShortestPaths[$newY][$newX];
    }
    $newWeightIsLess = $previousWeight > $newWeight;
    $cellNotVisited = !isset($cellVisited[$newY][$newX]);
    if ( $newWeightIsLess && $cellNotVisited ) {
        $cellShortestPaths[$newY][$newX] = $newWeight;
        $cellOrigins[$newY][$newX] = [$x, $y];
    }
}

$shortestPathWeight = INF;
while (!$pathFound) {
    /** Exploration phase */
    // Explore x + 1
    if ($x < $gridWidth - 1) {
        exploreCell($x + 1, $y);
    }
    // Explore x - 1
    if ($x > 0) {
        exploreCell($x - 1, $y);
    }
    // Explore y + 1
    if ($y < $gridHeight - 1) {
        exploreCell($x, $y + 1);
    }
    // Explore y - 1
    if ($y > 0) {
        exploreCell($x, $y - 1);
    }

    $cellVisited[$y][$x] = true;
    $count++;

    // Find the shortest path
    $shortestPathWeight = INF;
    foreach ($cellShortestPaths as $pathY => $row) {
        foreach ($row as $pathX => $weight) {
            if (isset($cellVisited[$pathY][$pathX])) {
                continue;
            }
            if ($weight < $shortestPathWeight) {
                $shortestPathWeight = $weight;
                $x = $pathX;
                $y = $pathY;
            }
        }
    }
    // exit if we've made it to the final destination with the shortest path.
    if (
        $x === $gridWidth - 1
        && $y === $gridHeight - 1
    ) {
        $pathFound = true;
    }
    echo "\r#$count: Current Weight: $shortestPathWeight, Position: $x, $y                                              ";
}

echo PHP_EOL . "Finished! Shortest path has a risk of: $shortestPathWeight";