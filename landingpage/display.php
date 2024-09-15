
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="includes/displaystyle.css">
    <title>Table Example</title>
    
</head>
<body>
    
    <?php
    // Check if POST variables exist
    $name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : 'Unknown';
    $age = isset($_POST['age']) ? htmlspecialchars($_POST['age']) : 'Unknown';
    $occupation = isset($_POST['occupation']) ? htmlspecialchars($_POST['occupation']) : 'Unknown';
    ?>
    <div class="image-container">
        <img src="boa.png" alt="Server Image">
    </div>

    <h2>Sample Table</h2>
    <table class = "styled-table">
        <thead>
            <tr>
                <th>Occupation</th>
                <th>Occupation</th>
                <th>Occupation</th>
                <th>Occupation</th>
                <th>Occupation</th>
                <th>Occupation</th>
                <th>Occupation</th>
                <th>Occupation</th>
                <th>Occupation</th>
                <th>Occupation</th>
                <th>Occupation</th>
                <th>Occupation</th>
                <th>Occupation</th>
                <th>Occupation</th>
                <th>Occupation</th>
                <th>Occupation</th>
                <th>Occupation</th>
                <th>Occupation</th>
                <th>Occupation</th>
                <th>Occupation</th>
                <th>Occupation</th>


            </tr>
        </thead>
        <tbody>
            <tr>
                <td>John Doe</td>
                <td>28</td>
                <td>Software Developer</td>
            </tr>
            <tr>
                <td>Jane Smith</td>
                <td>32</td>
                <td>Data Analyst</td>
            </tr>
            <tr>
                <td>Samuel Green</td>
                <td>45</td>
                <td>Project Manager</td>
            </tr>
        </tbody>
    </table>
</body>
</html>