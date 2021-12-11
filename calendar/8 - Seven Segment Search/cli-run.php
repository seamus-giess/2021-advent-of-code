<?php

ini_set("memory_limit", "14G");
// Get input
//$file = trim(file_get_contents('./inputs/testInput.txt'));
$file = trim(file_get_contents('./inputs/input.txt'));

/** Part One */
/*$entries = explode(PHP_EOL, $file);
$entries = array_map(function($entry) {
    $delimitedEntry = explode(' | ', $entry);
    return [explode(' ', $delimitedEntry[0]), explode(' ', $delimitedEntry[1])];
}, $entries);

$digitsWithUniqueSegments = ['1' =>  2, '4' => '4', '7' => 3, '8' => 7];

$counter = 0;
foreach ($entries as $entry) {
    foreach ($entry[1] as $outputValue) {
        if (in_array(strlen($outputValue), $digitsWithUniqueSegments)) {
            $counter++;
        }
    }
}

echo $counter;*/

/** Part Two */
$entries = explode(PHP_EOL, $file);
$entries = array_map(function ($entry) {
    $delimitedEntry = explode(' | ', $entry);
    return [explode(' ', $delimitedEntry[0]), explode(' ', $delimitedEntry[1])];
}, $entries);

$sum = 0;
// Determine wires for known digits
$digitsWithUniqueSegments = ['1' => 2, '4' => 4, '7' => 3, '8' => 7];
foreach ($entries as $entry) {
    $knownDigitCharacters = [];
    $digitsInEntry = array_merge($entry[0], $entry[1]);

    // Determine the known digits for this entry
    foreach ($digitsInEntry as $digitString) {
        if (in_array(strlen($digitString), $digitsWithUniqueSegments)) {
            $digit = array_keys($digitsWithUniqueSegments, strlen($digitString))[0];
            $knownDigitCharacters[(string)$digit] = str_split($digitString);
        }
    }

    // Determine the unknown digits programmatically
    foreach ($digitsInEntry as $digitString) {
        $splitDigitString = str_split($digitString);
        $digitLength = strlen($digitString);

        if ($digitLength === 6) {
            // 0 will match all segments in 8 but 1 different from 4 (middle segment)
            if (
                !array_diff($splitDigitString, $knownDigitCharacters['8'])
                && count(array_diff($knownDigitCharacters['4'], $splitDigitString)) === 1
                && !array_diff($knownDigitCharacters['1'], $splitDigitString)
            ) {
                $knownDigitCharacters['0'] = $splitDigitString;
            }

            // If digitString has top right segment, it's a 9, else it's a 6
            if (
                !array_diff($knownDigitCharacters['1'], $splitDigitString)
                && !array_diff($knownDigitCharacters['4'], $splitDigitString)
            ) {
                $knownDigitCharacters['9'] = $splitDigitString;
            }
            if (
                count(array_diff($knownDigitCharacters['1'], $splitDigitString)) === 1
            ) {
                $knownDigitCharacters['6'] = $splitDigitString;
            }
        }

        if ($digitLength === 5) {

            // 3 will be 2 segments less than 8, but contain all 1 segments
            if (
                !array_diff($knownDigitCharacters['1'], $splitDigitString)
                && count(array_diff($knownDigitCharacters['8'], $splitDigitString)) === 2
            ) {
                $knownDigitCharacters['3'] = $splitDigitString;
            }

            // 5 will contain 3 segments of 4, 2 unaccounted for, but will not contain all of 1
            if (
                count(array_diff($splitDigitString, $knownDigitCharacters['4'])) === 2
                && count(array_diff($knownDigitCharacters['1'], $splitDigitString)) === 1
            ) {
                $knownDigitCharacters['5'] = $splitDigitString;
            }

            // 2 will contain 2 segments of 4, 3 unaccounted for
            if (
                count(array_diff($splitDigitString, $knownDigitCharacters['4'])) === 3
                && count(array_diff($knownDigitCharacters['1'], $splitDigitString)) === 1
            ) {
                $knownDigitCharacters['2'] = $splitDigitString;
            }
        }
    }

    $outputValue = '';
    foreach ($entry[1] as $outputDigit) {
        foreach ($knownDigitCharacters as $digit => $digitString) {
            $outputDigitString = str_split($outputDigit);
            sort($digitString);
            sort($outputDigitString);
            if ($digitString == $outputDigitString) {
                $outputValue .= $digit;
                break;
            }
        }
    }
    $sum += (int)$outputValue;
}

echo $sum;