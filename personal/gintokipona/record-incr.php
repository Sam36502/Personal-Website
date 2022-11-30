<?php

// Constants
require("const.php");

// Select record file
$RECORD_FILE = "";
if ($_GET["person"] == "sam") {
    $RECORD_FILE = $RECORD_FILE_SAM;
} else {
    $RECORD_FILE = $RECORD_FILE_AMIN;
}

// Read and parse file
$lines = file($RECORD_FILE);
$no_today = true;
for ($i=0; $i<count($lines); $i++) {
    $line = $lines[$i];
    $date = explode(",", $line)[0];
    $tallies = explode(",", $line)[1];

    // Add tally to today
    $today = date("Y-m-d");
    if ($date == $today) {
        $no_today = false;
        $lines[$i] = trim($line) . "X\n";
    }
}

// Add today if it doesn't exist
if ($no_today) {
    array_push($lines, $today . ",X\n");
}

// Write changes to file
$record_file = fopen($RECORD_FILE, "w");
foreach ($lines as $line) {
    fwrite($record_file, $line);
}
fclose($record_file);

// Redirect back to main page
header("Location: index.php");

