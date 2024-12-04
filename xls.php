<?php

require 'vendor/autoload.php'; // Include the autoload file if you're using Composer

use XLSXWriter;

// Sample data (with comments and colors)
$data = [
    ['r', 'Red comment'],
    ['g', 'Green comment'],
    ['b', 'Blue comment'],
    ['r', 'Another red comment'],
    ['g', 'Another green comment'],
    ['b', 'Another blue comment'],
];

// Create a new XLSXWriter instance
$writer = new XLSXWriter();

// Define the styles based on colors (only for the first column)
$styles = [
    'r' => ['fill' => 'FF0000'], // Red
    'g' => ['fill' => '00FF00'], // Green
    'b' => ['fill' => '0000FF'], // Blue
];

// Write the header for the sheet
$writer->writeSheetHeader('Sheet1', ['Color' => 'string', 'Comment' => 'string']);

// Iterate through the data and apply color and comments
foreach ($data as $row) {
    $color = $row[0]; // 'r', 'g', or 'b'
    $comment = $row[1]; // The comment associated with the color

    // Apply the style only to the color cell (first column)
    $style = isset($styles[$color]) ? $styles[$color] : [];

    // Write the row: Apply style only to the first cell (color)
    $writer->writeSheetRow('Sheet1', [
        $row[0],    // Color cell with style applied (display 'r', 'g', or 'b')
        $row[1]     // Comment cell without any style
    ], $style);
}

// Output the file to the browser as a download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="output_with_comments.xlsx"');
header('Cache-Control: max-age=0'); // Ensure the browser does not cache the file
$writer->writeToStdOut(); // Output the file to the browser directly

exit; // Ensure the script stops after sending the file

?>