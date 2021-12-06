<?php
// Get input
$file = file_get_contents('./inputs/input.txt');
$data = explode(PHP_EOL.PHP_EOL,$file);

$calledNumbers = explode(',', array_splice($data,  0, 1)[0]);

$tables = array_map(function($tableString) {
    $tableRows = explode(PHP_EOL, $tableString);
    foreach ($tableRows as $index => $row) {
        $tableRows[$index] = explode(' ',trim(str_replace('  ', ' ', trim($row))));
    }
    return $tableRows;
}
, $data);

// Implement counter to keep track of which row or column would win
$tableRows = array_keys($tables);
$tableColumns = array_keys($tables);

foreach($tables as $table => $rows) {
    $keys = array_map(fn($value) => 0, array_flip(array_keys($rows)));
    $tableRows[$table] = $keys;
    $tableColumns[$table] = $keys;
}
/** Part One */
/*// Determine the winner
foreach ($calledNumbers as $number) {
    foreach ($tables as $table => $rows) {
        foreach ($rows as $row => $columns) {
            foreach ($columns as $column => $value) {
                if ($number === $value) {
                    $tableRows[$table][$row]++;
                    $tableColumns[$table][$column]++;
                    $tables[$table][$row][$column] = "marked";
                    if($tableRows[$table][$row] === 5 || $tableColumns[$table][$column] === 5) {
                        echo "Winner: Table $table" . PHP_EOL;
                        $sum = 0;
                        foreach ($tables[$table] as $winningRows) {
                            foreach ($winningRows as $winningValue) {
                                if ($winningValue !== "marked") {
                                    $sum += $winningValue;
                                }
                            }
                        }
                        echo $sum * $number;
                        break 4;
                    }
                }
            }
        }
    }
}*/

/** Part Two */
// Determine the winner
$lastTable = false;
$latestWinnerTable = [];
$latestWinnerNumber = null;
// For each number
foreach ($calledNumbers as $number) {
    // Check through each table
    foreach ($tables as $table => $rows) {
        // By checking each row
        foreach ($rows as $row => $columns) {
            // And each value ('column') in that row
            foreach ($columns as $column => $value) {
                if ($number === $value) {
                    $tableRows[$table][$row]++;
                    $tableColumns[$table][$column]++;
                    $tables[$table][$row][$column] = "marked";

                    if($tableRows[$table][$row] >= 5 || $tableColumns[$table][$column] >= 5) {
                        echo "Winner: $table Tables Left: " . count($tables) . PHP_EOL;
                        $latestWinner = $table;
                        $latestWinnerTable = $tables[$table];
                        $latestWinnerNumber = $number;
                        unset($tables[$table]);
                    }
                    break 2;
                }
            }
        }
    }
}

$sum = 0;
foreach ($latestWinnerTable as $rows) {
    foreach ($rows as $value) {
        if ($value !== 'marked') {
            $sum += $value;
        }
    }
}
echo json_encode($latestWinnerTable) . PHP_EOL;
echo "Sum: $sum ". PHP_EOL;
echo "Last Winner: $latestWinner" . PHP_EOL;
echo "Last Winning Number: $latestWinnerNumber" . PHP_EOL;
echo $sum * $latestWinnerNumber;