<?php
ini_set("memory_limit","14G");
// Get input
//$file = trim(file_get_contents('./inputs/testInput.txt'));
$file = trim(file_get_contents('./inputs/input.txt'));

$crabs = explode(',', $file);

/** Part One */
/*$positionFuelCost = [];
for ($i = min($crabs); $i <= max($crabs); $i++) {
    $positionFuelCost[$i] = 0;

    foreach ($crabs as $crab) {
        $positionFuelCost[$i] += abs($i - $crab);
    }
}

$minFuelPosition = array_keys($positionFuelCost, min($positionFuelCost))[0];
echo "Most Efficient Position: $minFuelPosition Fuel: {$positionFuelCost[$minFuelPosition]}" ;*/

/** Part Two */
$positionFuelCost = [];
for ($i = min($crabs); $i <= max($crabs); $i++) {
    $positionFuelCost[$i] = 0;

    foreach ($crabs as $crab) {
        $distance = abs($i - $crab) + 1;
        // magic addition
        //don't understand why the discrepancy between positions is incremented for this triangular number formula
        // (I'm exhausted as of writing this, I'm sure I could rationalise a reason if I wasn't)
        $triangleValue = ($distance * ($distance - 1)) / 2;
        $positionFuelCost[$i] += $triangleValue;
    }
}

$minFuelPosition = array_keys($positionFuelCost, min($positionFuelCost))[0];
echo "Most Efficient Position: $minFuelPosition Fuel: {$positionFuelCost[$minFuelPosition]}" ;