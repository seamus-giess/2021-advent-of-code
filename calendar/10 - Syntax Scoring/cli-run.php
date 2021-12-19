<?php

ini_set("memory_limit", "14G");
// Get input
//$file = trim(file_get_contents('./inputs/testInput.txt'));
$file = trim(file_get_contents('./inputs/input.txt'));

/** Part One */
/*$lines = explode(PHP_EOL, $file);

$chunks = [
    '(' => ')',
    '[' => ']',
    '{' => '}',
    '<' => '>',
];

$illegalPieceValues = [
    ')' => 3,
    ']' => 57,
    '}' => 1197,
    '>' => 25137,
];

$illegalPieces = [];

foreach ($lines as $lineIndex => $line) {
    $chunkPieces = str_split($line);
    $lineChunks = [];
    foreach ($chunkPieces as $pieceIndex => $piece) {

        if ($pieceIndex !== 0) {
            $previousPiece = array_pop($lineChunks);
        }

        if (in_array($piece, array_keys($chunks)) || $pieceIndex == 0) {
            if (isset($previousPiece)) {
                $lineChunks[] = $previousPiece;
            }
            $lineChunks[] = $piece;
        } elseif ($piece !== $chunks[$previousPiece]) {
//            echo "$lineIndex - $pieceIndex: $piece lineChunks: " . json_encode($lineChunks) . PHP_EOL;
//            echo "Illegal piece: $piece" . PHP_EOL;

            $illegalPieces[] = $piece;
        }
    }
}

$sum = 0;
foreach ($illegalPieces as $piece) {
    $sum += $illegalPieceValues[$piece];
}

echo $sum;*/

/** Part Two */
$lines = explode(PHP_EOL, $file);

$chunks = [
    '(' => ')',
    '[' => ']',
    '{' => '}',
    '<' => '>',
];

$autoCompletePieceValues = [
    ')' => 1,
    ']' => 2,
    '}' => 3,
    '>' => 4,
];

$autoCompleteScores = [];

foreach ($lines as $lineIndex => $line) {
    $chunkPieces = str_split($line);
    $lineChunks = [];
    foreach ($chunkPieces as $pieceIndex => $piece) {
        unset($chunkPieces[$pieceIndex]);
        if (in_array($piece, array_keys($chunks)) || $pieceIndex == 0) {
            $lineChunks[] = $piece;
        } else {
            $previousPiece = array_pop($lineChunks);
            if ($piece === $chunks[$previousPiece]) {
                unset ($chunkPieces[$pieceIndex - 1]);
            } else {
                unset($lines[$lineIndex]);
                continue 2;
            }
        }
    }

    $autoCompletePieces = [];
    foreach ($lineChunks as $piece) {
        array_unshift($autoCompletePieces, $chunks[$piece]);
    }

    $autoCompleteScore = 0;
    foreach ($autoCompletePieces as $piece) {
        $autoCompleteScore = $autoCompleteScore * 5;
        $autoCompleteScore += $autoCompletePieceValues[$piece];
    }
    $autoCompleteScores[] = $autoCompleteScore;
}

sort($autoCompleteScores);
$middle = (count($autoCompleteScores) - 1) / 2;
echo $autoCompleteScores[$middle];