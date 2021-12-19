<?php

// Get input
//$file = trim(file_get_contents('./inputs/testInput.txt'));
$file = trim(file_get_contents('./inputs/input.txt'));
$file = explode(PHP_EOL . PHP_EOL, $file);

// process insertion input
$insertionStrings = explode(PHP_EOL, $file[1]);
$insertions = [];
foreach ($insertionStrings as $index => $insertionString) {
    $insertion = explode(' -> ', $insertionString);
    $insertions[$insertion[0]] = $insertion [1];
}

// process template input
$charCount = [];
$pairCount = [];
$template = str_split($file[0]);
foreach ($template as $index => $character) {
    if(!isset($charCount[$character])) {
        $charCount[$character] = 1;
    } else {
        $charCount[$character]++;
    }
    if ($index === 0) {
        continue;
    }
    $pair = $template[$index - 1] . $character;
    if(!isset($pairCount[$pair])) {
        $pairCount[$pair] = 1;
    } else {
        $pairCount[$pair]++;
    }
}

/** Part One */
$step = 1;
$limit = 40;
while ($step <= $limit) {
    foreach ($pairCount as $pair => $count) {
        // skip if no pairs exist
        if ($count === 0) {
            continue;
        }

        // determine character to insert, and increase the count for that character
        $insertedCharacter = $insertions[$pair];
        if(!isset($charCount[$insertedCharacter])) {
            $charCount[$insertedCharacter] = $count;
        } else {
            $charCount[$insertedCharacter] += $count;
        }

        // generate the new pairs
        $splitPair = str_split($pair);

        $firstPair = $splitPair[0] . $insertedCharacter;
        $secondPair = $insertedCharacter . $splitPair[1];
        if(!isset($pairCount[$firstPair])) {
            $pairCount[$firstPair] = $count;
        } else {
            $pairCount[$firstPair] += $count;
        }
        if(!isset($pairCount[$secondPair])) {
            $pairCount[$secondPair] = $count;
        } else {
            $pairCount[$secondPair] += $count;
        }

        // reduce the count of the previously existing pair
        $pairCount[$pair] -= $count;
    }
    $step++;
}

echo max($charCount) - min($charCount);