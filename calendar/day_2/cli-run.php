<?php
// Get input
$file = file_get_contents('./inputs/input.txt');
/**
 * Prepare the file into more useable commands
 * $commands[i][0] is the command type
 * $commands[i][1] is the length actioned
 */
$commands = explode(PHP_EOL, $file);
$commands = array_map(
    fn($string) => explode(' ',$string),
    $commands
);

/** Part One */
/*$horizontalPosition = 0;
$verticalPosition = 0;
foreach ($commands as $command) {
    switch ($command[0]) {
        case 'up':
            $verticalPosition -= $command[1];
            break;
        case 'down':
            $verticalPosition += $command[1];
            break;
        case 'forward':
            $horizontalPosition += $command[1];
    }
}

// Get Result
echo $horizontalPosition * $verticalPosition;*/

/** Part Two */
$horizontalPosition = 0;
$verticalPosition = 0;
$aim = 0;
foreach ($commands as $command) {
    switch ($command[0]) {
        case 'up':
            $aim -= $command[1];
            break;
        case 'down':
            $aim += $command[1];
            break;
        case 'forward':
            $horizontalPosition += $command[1];
            $verticalPosition += $aim * $command[1];
    }
}

// Get Result
echo $horizontalPosition * $verticalPosition;