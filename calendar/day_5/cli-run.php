<?php

// Get input
//$file = file_get_contents('./inputs/testInput.txt'); // TODO swap test input to live input
$file = file_get_contents('./inputs/input.txt');

/** Part One */
/*// Create the lines from the data
$lines = explode(PHP_EOL, $file);
$formattedLines = [];
$gridWidth = 0;
$gridHeight = 0;
foreach ($lines as $lineIndex => $line) {
    $lineCoordinates = explode(' -> ', $line);
    foreach ($lineCoordinates as $coordinateIndex => $coordinates) {
        $coordinates = explode(',', $coordinates);
        $formattedLines[$lineIndex][$coordinateIndex] = $coordinates;

        if ($coordinates[0] > $gridWidth) {
            $gridWidth = $coordinates[0];
        }
        if ($coordinates[1] > $gridHeight) {
            $gridHeight = $coordinates[1];
        }
    }
}

// Construct the grid
$grid = [];
for ($x = 0; $x <= $gridWidth; $x++) {
    for ($y = 0; $y <= $gridHeight; $y++) {
        $grid[$x][$y] = '.';
    }
}

// Populate the grid with lines
foreach ($formattedLines as $line) {
    if (
        $line[0][0] !== $line[1][0]
        && $line[0][1] === $line[1][1]
    ) {
        $y = $line[0][1];
        $x1 = $line[0][0];
        $x2 = $line[1][0];

        $smallX = $x1 < $x2 ? $x1 : $x2;
        $bigX = $x1 < $x2 ? $x2 : $x1;
        for ($length = $smallX; $length <= $bigX; $length++) {
            $grid[$length][$y] =
                ($grid[$length][$y] === '.'
                    ? 1
                    : $grid[$length][$y] + 1);
        }
    } elseif (
        $line[0][1] !== $line[1][1]
        && $line[0][0] === $line[1][0]
    ) {
        $x = $line[0][0];
        $y1 = $line[0][1];
        $y2 = $line[1][1];

        $smallY = $y1 < $y2 ? $y1 : $y2;
        $bigY = $y1 < $y2 ? $y2 : $y1;

        for ($length = $smallY; $length <= $bigY; $length++) {
            // Set or increment at this grid position
            $grid[$x][$length] =
                ($grid[$x][$length] === '.'
                    ? 1
                    : $grid[$x][$length] + 1);
        }
    }
}

$riskCount = 0;
foreach ($grid as $x => $column) {
    foreach ($column as $y => $value) {
        if ($value >= 2) {
            $riskCount++;
        }
    }
}

echo $riskCount;*/

/** Part Two */
// Create the lines from the data
$lines = explode(PHP_EOL, $file);
$formattedLines = [];
$gridWidth = 0;
$gridHeight = 0;
foreach ($lines as $lineIndex => $line) {
    $lineCoordinates = explode(' -> ', $line);
    foreach ($lineCoordinates as $coordinateIndex => $coordinates) {
        $coordinates = explode(',', $coordinates);
        $formattedLines[$lineIndex][$coordinateIndex] = $coordinates;

        if ($coordinates[0] > $gridWidth) {
            $gridWidth = $coordinates[0];
        }
        if ($coordinates[1] > $gridHeight) {
            $gridHeight = $coordinates[1];
        }
    }
}

// Construct the grid
$grid = [];
for ($x = 0; $x <= $gridWidth; $x++) {
    for ($y = 0; $y <= $gridHeight; $y++) {
        $grid[$x][$y] = '.';
    }
}

// Populate the grid with lines
foreach ($formattedLines as $line) {
    if (
        $line[0][0] !== $line[1][0]
        && $line[0][1] === $line[1][1]
    ) {
        $y = $line[0][1];
        $x1 = $line[0][0];
        $x2 = $line[1][0];

        $smallX = $x1 < $x2 ? $x1 : $x2;
        $bigX = $x1 < $x2 ? $x2 : $x1;
        for ($length = $smallX; $length <= $bigX; $length++) {
            $grid[$length][$y] =
                ($grid[$length][$y] === '.'
                    ? 1
                    : $grid[$length][$y] + 1);
        }
    } elseif (
        $line[0][1] !== $line[1][1]
        && $line[0][0] === $line[1][0]
    ) {
        $x = $line[0][0];
        $y1 = $line[0][1];
        $y2 = $line[1][1];

        $smallY = $y1 < $y2 ? $y1 : $y2;
        $bigY = $y1 < $y2 ? $y2 : $y1;

        for ($length = $smallY; $length <= $bigY; $length++) {
            // Set or increment at this grid position
            $grid[$x][$length] =
                ($grid[$x][$length] === '.'
                    ? 1
                    : $grid[$x][$length] + 1);
        }
    } else {
        $x1 = $line[0][0];
        $y1 = $line[0][1];
        $x2 = $line[1][0];
        $y2 = $line[1][1];

        $x = $x1;
        $y = $y1;
        if ($x1 < $x2 && $y1 < $y2) {
            while ( $x <= $x2 && $y <= $y2) {
                $grid[$x][$y] =
                    ($grid[$x][$y] === '.'
                        ? 1
                        : $grid[$x][$y] + 1);
                $x++;
                $y++;
            }
        } elseif ($x1 < $x2 && $y2 < $y1) {
            while ( $x <= $x2 && $y >= $y2) {
                $grid[$x][$y] =
                    ($grid[$x][$y] === '.'
                        ? 1
                        : $grid[$x][$y] + 1);
                $x++;
                $y--;
            }
        } elseif ($x2 < $x1 && $y1 < $y2) {
            while ( $x >= $x2 && $y <= $y2) {
                $grid[$x][$y] =
                    ($grid[$x][$y] === '.'
                        ? 1
                        : $grid[$x][$y] + 1);
                $x--;
                $y++;
            }
        } elseif ($x2 < $x1 && $y2 < $y1) {
            while ( $x >= $x2 && $y >= $y2) {
                $grid[$x][$y] =
                    ($grid[$x][$y] === '.'
                        ? 1
                        : $grid[$x][$y] + 1);
                $x--;
                $y--;
            }
        }
    }
}

$riskCount = 0;
foreach ($grid as $x => $column) {
    foreach ($column as $y => $value) {
        if ($value >= 2) {
            $riskCount++;
        }
    }
}

echo json_encode($grid) . PHP_EOL;
echo $riskCount;