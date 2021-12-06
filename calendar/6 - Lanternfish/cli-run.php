<?php
ini_set("memory_limit","14G");
// Get input
//$file = trim(file_get_contents('./inputs/testInput.txt'));
$file = trim(file_get_contents('./inputs/input.txt'));

$fishies = explode(',', $file);

$day = 0;
$fishCount = [
    0 => 0,
    1 => 0,
    2 => 0,
    3 => 0,
    4 => 0,
    5 => 0,
    6 => 0,
    7 => 0,
    8 => 0
];

foreach ($fishies as $fish) {
    $fishCount[$fish]++;
}

while ($day < 256 ) {
    // Set up the placeholder for the 0-aged fish
    // (as they are transitioning, and don't age in this process)
    $zeros =  $fishCount[0];
    $fishCount[0] = 0;

    // Decrease all fish that currently exist (except 0, which is transitioning)
    foreach ($fishCount as $index => $count) {
        if ($index === 0) {
            continue;
        }
        $fishCount[$index - 1] += $count;
        $fishCount[$index] = 0;
    }

    // Introduced/Reintroduce the appropriate amount of fish based on the previously 0-aged fish
    $fishCount[6] += $zeros;
    $fishCount[8] += $zeros;

    $day++;
}

// Count each and every fish
$sum = 0;
foreach ($fishCount as $fishes) {
    $sum += $fishes;
}

echo "day: $day fishies: ".json_encode($sum);