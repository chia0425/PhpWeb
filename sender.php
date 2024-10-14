<?php
// Check if data was received via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw POST data
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);  // Decode JSON data into an associative array

    // Access the data
    $name = $data['name'] ?? null; // Use null coalescing to avoid undefined index
    $age = $data['age'] ?? null;

    // Process the data (e.g., save to database, etc.)
    // Here, just echoing the response back
    $response = [
        'message' => 'Data received successfully',
    ];
    $fp = fopen('filename.php' , "w");
    // Set the Content-Type header for JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit; // Stop further execution
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Object to PHP</title>
</head>
<body>
    <form id="dataForm">
        <input type="text" id="name" placeholder="Enter Name" required>
        <input type="number" id="age" placeholder="Enter Age" required>
        <input type="submit" value="Submit">
    </form>

    <script>
        document.getElementById('dataForm').addEventListener('submit', function (e) {
            e.preventDefault(); // Prevent the default form submission

            // Create an object from the form input values
            const data = [
    {"DCNAME" : "AUS"  , "CloudCount": "10" , "DecomCount" : "15" , "networkdevicecount" : "10" , iloport : "15" , "dh port"  : "20", "power" : "10" , "ru": "10" , "totalcount": "101"},
    {"DCNAME" : "AUS"  , "CloudCount": "10" , "DecomCount" : "15" , "networkdevicecount" : "10" , iloport : "15" , "dh port"  : "20", "power" : "10" , "ru": "10" , "totalcount": "101"},
    {"DCNAME" : "AUS"  , "CloudCount": "10" , "DecomCount" : "15" , "networkdevicecount" : "10" , iloport : "15" , "dh port"  : "20", "power" : "10" , "ru": "10" , "totalcount": "101"},
    {"DCNAME" : "AUS"  , "CloudCount": "10" , "DecomCount" : "15" , "networkdevicecount" : "10" , iloport : "15" , "dh port"  : "20", "power" : "10" , "ru": "10" , "totalcount": "101"},
    {"DCNAME" : "AUS"  , "CloudCount": "10" , "DecomCount" : "15" , "networkdevicecount" : "10" , iloport : "15" , "dh port"  : "20", "power" : "10" , "ru": "10" , "totalcount": "101"},
    {"DCNAME" : "AUS"  , "CloudCount": "10" , "DecomCount" : "15" , "networkdevicecount" : "10" , iloport : "15" , "dh port"  : "20", "power" : "10" , "ru": "10" , "totalcount": "101"},
    
];
            console.log(data);
            console.log(typeof data);
            console.log(JSON.stringify(data));
            // Send the object as JSON to the PHP script
            fetch('', { // The empty string '' means to post to the same page
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data) // Convert object to JSON
            })
            .then(response => response.json()) // Parse the JSON response
            .then(result => {
                console.log('Success:', result); // Handle success response
            })
            .catch(error => {
                console.error('Error:', error); // Handle error
            });
        });
    </script>
</body>
</html>

<!-- [
    {"DCNAME" : "AUS"  , "CloudCount": "10" , "DecomCount" : "15" , "networkdevicecount" : "10" , iloport : "15" , "dh port"  : "20", "power" : "10" , "ru": "10" , "totalcount": "101"},
    {"DCNAME" : "AUS"  , "CloudCount": "10" , "DecomCount" : "15" , "networkdevicecount" : "10" , iloport : "15" , "dh port"  : "20", "power" : "10" , "ru": "10" , "totalcount": "101"},
    {"DCNAME" : "AUS"  , "CloudCount": "10" , "DecomCount" : "15" , "networkdevicecount" : "10" , iloport : "15" , "dh port"  : "20", "power" : "10" , "ru": "10" , "totalcount": "101"},
    {"DCNAME" : "AUS"  , "CloudCount": "10" , "DecomCount" : "15" , "networkdevicecount" : "10" , iloport : "15" , "dh port"  : "20", "power" : "10" , "ru": "10" , "totalcount": "101"},
    {"DCNAME" : "AUS"  , "CloudCount": "10" , "DecomCount" : "15" , "networkdevicecount" : "10" , iloport : "15" , "dh port"  : "20", "power" : "10" , "ru": "10" , "totalcount": "101"},
    {"DCNAME" : "AUS"  , "CloudCount": "10" , "DecomCount" : "15" , "networkdevicecount" : "10" , iloport : "15" , "dh port"  : "20", "power" : "10" , "ru": "10" , "totalcount": "101"},

] -->