<?php

ini_set("memory_limit", "14G");
// Get input
//$file = trim(file_get_contents('./inputs/testInput.txt'));
//$file = trim(file_get_contents('./inputs/testInput2.txt'));
//$file = trim(file_get_contents('./inputs/testInput3.txt'));
$file = trim(file_get_contents('./inputs/input.txt'));

$connections = explode(PHP_EOL, $file);
$connections = array_map(fn($connection) => explode('-', $connection), $connections);

// Get unique caves from possible connections between caves
$caves = array_fill_keys(
    array_unique(
        array_merge(
            array_map(fn($connection) => $connection[0], $connections),
            array_map(fn($connection) => $connection[1], $connections),
        )
    ),
    []
);


// Construct relation of caves to their connected neighbours
foreach ($connections as $connection) {
    $caves[$connection[0]][] = $connection[1];
    $caves[$connection[1]][] = $connection[0];
}

/** Part One */
//$paths = [];
//// From start
//$paths[] = ['start'];
//$stillExploring = true;
//while ($stillExploring) {
//    // for each unfinished path
//    foreach ($paths as $index => $path) {
//        $mostRecentCaveInPath = end($path);
//        if ($mostRecentCaveInPath === 'end') {
//            continue;
//        }
//
//        // Add any viable connected caves
//        // (non-duplicates of lowercase paths, and all uppercase paths)
//        $connectedCaves = $caves[$mostRecentCaveInPath];
//        foreach ($connectedCaves as $connectedCave) {
//            $smallCave = ctype_lower($connectedCave);
//            $alreadyVisited = in_array($connectedCave, $path);
//            if ($smallCave && $alreadyVisited) {
//                continue;
//            }
//
//            // add this new path to the list of paths
//            $newPath = $path;
//            array_push($newPath, $connectedCave);
//            $paths[] = $newPath;
//        }
//
//        unset($paths[$index]);
//    }
//
//    // determine if there are any remaining unfinished paths
//    $stillExploring = false;
//    foreach ($paths as $path) {
//        $lastCave = end($path);
//        if ($lastCave !== 'end') {
//            $stillExploring = true;
//        }
//    }
//}
//
//echo count($paths);

/** Part Two */
$paths = [];
// From start
$paths[] = ['start'];
$stillExploring = true;
while ($stillExploring) {
    // for each unfinished path
    foreach ($paths as $index => $path) {
        $mostRecentCaveInPath = end($path);
        if ($mostRecentCaveInPath === 'end') {
            continue;
        }

        // Add any viable connected caves
        // (non-duplicates of lowercase paths, and all uppercase paths)
        $connectedCaves = $caves[$mostRecentCaveInPath];
        $smallCaveVisitedTwice = false;
        $pathSmallCaves = [];
        foreach ($path as $cave) {
            if (in_array($cave, $pathSmallCaves)) {
                $smallCaveVisitedTwice = true;
                break;
            }
            if (ctype_lower($cave)) {
                $pathSmallCaves[] = $cave;
            }
        }
        foreach ($connectedCaves as $connectedCave) {
            $smallCave = ctype_lower($connectedCave);

            $alreadyVisited = false;
            if ($connectedCave === 'start' || $connectedCave == 'end') {
                $alreadyVisited = in_array($connectedCave, $path);
            } else {
                if (!$smallCaveVisitedTwice && in_array($connectedCave, $path)) {
                    $alreadyVisited = (array_count_values($path)[$connectedCave] >= 2);
                } else {
                    $alreadyVisited = in_array($connectedCave, $path);
                }
            }

            if ($smallCave && $alreadyVisited) {
                continue;
            }

            // add this new path to the list of paths
            $newPath = $path;
            array_push($newPath, $connectedCave);
            $paths[] = $newPath;
        }

        unset($paths[$index]);
    }

    // determine if there are any remaining unfinished paths
    $stillExploring = false;
    foreach ($paths as $path) {
        $lastCave = end($path);
        if ($lastCave !== 'end') {
            $stillExploring = true;
        }
    }
}
$paths = array_map(fn($path) => implode(',', $path), $paths);
$paths = array_unique($paths);

echo count($paths) . PHP_EOL;