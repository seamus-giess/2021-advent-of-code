<?php
// Get inputs
$file = file_get_contents('./inputs/input.txt');

// Do logic
$depths = explode(PHP_EOL, $file);

/** Part One */
/*$depth_increments = 0;
$previous_depth = null;
foreach ($depths as $depth) {
    // Skip first measurement, but still set $previous_depth
    if (!$previous_depth) {
        $previous_depth = $depth;
        continue;
    }

    if ($depth > $previous_depth) {
        $depth_increments++;
    }
    $previous_depth = $depth;
}

echo $depth_increments;*/

/** Part Two */
// Create three-measurement sliding window frames
$frames = [];
foreach ($depths as $frameIndex => $frame) {
    if (
        !array_key_exists($frameIndex + 1, $depths)
        || !array_key_exists($frameIndex + 2, $depths)
    ) {
        continue;
    }

    $frames[$frameIndex] = $frame + $depths[$frameIndex + 1] + $depths[$frameIndex + 2];
}

// Count frames that increment over previous frame
$frameCount = count($frames);
$frame_increments = 0;
foreach ($frames as $frameIndex => $frame) {
    if ($frameIndex === 0) {
        continue;
    }

    if ($frame > $frames[$frameIndex - 1]) {
        $frame_increments++;
    }
}

echo $frame_increments;