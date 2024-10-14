<?php
// delete_file.php

// Check if it's a POST request and the 'filename' is sent
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filename'])) {
    $filename = $_POST['filename'];

    // Check if the file exists
    if (file_exists($filename)) {
        // Try to delete the file
        if (unlink($filename)) {
            echo json_encode(['status' => 'success', 'message' => 'File deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete file']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'File does not exist']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>

function deleteFile(filename) {
            // Make a POST request to call the PHP script
            fetch('delete_file.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded' // Form-urlencoded for sending data
                },
                body: `filename=${encodeURIComponent(filename)}` // Send the filename to PHP
            })
            .then(response => response.json()) // Parse the JSON response
            .then(data => {
                console.log(data.message); // Display the response message
                alert(data.message); // Show an alert with the result
            })
            .catch(error => {
                console.error('Error:', error); // Handle errors
            });