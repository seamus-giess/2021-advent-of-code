<?php
// Get input
$file = file_get_contents('./inputs/input.txt');

$bitStrings = explode(PHP_EOL, $file);
/** @var Array $bitStrings */
$bitStrings = array_map(fn($bitString) => str_split($bitString), $bitStrings);

/** Part One */
/*$gammaRate = '';
$epsilonRate = '';
for ($i = 0; $i < count($bitStrings[0]); $i++) {
    $zeros = 0;
    $ones = 0;
    foreach ($bitStrings as $bitString) {
        if ($bitString[$i] === "0") {
            $zeros++;
        } else {
            $ones++;
        }
    }

    if ($zeros > $ones) {
        $gammaRate .= '0';
        $epsilonRate .= '1';
    } else {
        $gammaRate .= '1';
        $epsilonRate .= '0';
    }
}

echo bindec($gammaRate) * bindec($epsilonRate);*/

/** Part Two */
// Oxygen Generator Rating
$bitStringLength = count($bitStrings[0]);
$oxygenBitStrings = $bitStrings;
for ($i = 0; $i < $bitStringLength; $i++) {
    $zeros = 0;
    $ones = 0;
    foreach ($oxygenBitStrings as $bitString) {
        if ($bitString[$i] === "0") {
            $zeros++;
        } else {
            $ones++;
        }
    }

    if (count($oxygenBitStrings) === 1) {
        break;
    }
    if ($ones >= $zeros) {
        foreach ($oxygenBitStrings as $stringIndex => $bitString) {
            if ($bitString[$i] !== '1') {
                unset($oxygenBitStrings[$stringIndex]);
            }
        }
    } else {
        foreach ($oxygenBitStrings as $stringIndex => $bitString) {
            if ($bitString[$i] !== '0') {
                unset($oxygenBitStrings[$stringIndex]);
            }
        }
    }
}
$oxygenGeneratorRating = bindec(implode(end($oxygenBitStrings)));

$co2BitStrings = $bitStrings;
for ($i = 0; $i < $bitStringLength; $i++) {
    $zeros = 0;
    $ones = 0;
    foreach ($co2BitStrings as $bitString) {
        if ($bitString[$i] === "0") {
            $zeros++;
        } else {
            $ones++;
        }
    }

    if (count($co2BitStrings) === 1) {
        break;
    }
    if ($ones >= $zeros) {
        foreach ($co2BitStrings as $stringIndex => $bitString) {
            // Keep 0s if 1 is more common
            if ($bitString[$i] !== '0') {
                unset($co2BitStrings[$stringIndex]);
            }
        }
    } else {
        foreach ($co2BitStrings as $stringIndex => $bitString) {
            // Keep 1s if 0 is more common
            if ($bitString[$i] !== '1') {
                unset($co2BitStrings[$stringIndex]);
            }
        }
    }
}
$co2ScrubberRating = bindec(implode(end($co2BitStrings)));

echo $oxygenGeneratorRating * $co2ScrubberRating;