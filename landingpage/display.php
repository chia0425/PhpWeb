<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="includes/displaystyle.css">
    <title>Table Example with Collapsible Columns</title>
    <style>
        /* Styling for the table */
        .styled-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .styled-table th, .styled-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .styled-table th {
            background-color: #f2f2f2;
            position: relative;
        }

        /* Button inside the table header */
        .toggle-button {
            background: none;
            border: none;
            cursor: pointer;
            position: absolute;
            top: 5px;
            right: 5px;
        }

        /* Hidden columns */
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <?php
    // Check if POST variables exist
    $name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : 'Unknown';
    $age = isset($_POST['age']) ? htmlspecialchars($_POST['age']) : 'Unknown';
    $occupation = isset($_POST['occupation']) ? htmlspecialchars($_POST['occupation']) : 'Unknown';
    ?>

    <h2>Sample Table with Collapsible Columns</h2>
    <table class="styled-table">
        <thead>
            <tr>
                <th>Column 1
                    <button class="toggle-button" onclick="toggleColumn(1)">-</button>
                </th>
                <th>Column 2
                    <button class="toggle-button" onclick="toggleColumn(2)">-</button>
                </th>
                <th>Column 3
                    <button class="toggle-button" onclick="toggleColumn(3)">-</button>
                </th>
                <!-- Add more columns as needed -->
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="column-1">John Doe</td>
                <td class="column-2">28</td>
                <td class="column-3">Software Developer</td>
            </tr>
            <tr>
                <td class="column-1">Jane Smith</td>
                <td class="column-2">32</td>
                <td class="column-3">Data Analyst</td>
            </tr>
            <tr>
                <td class="column-1">Samuel Green</td>
                <td class="column-2">45</td>
                <td class="column-3">Project Manager</td>
            </tr>
        </tbody>
    </table>

    <script>
        function toggleColumn(columnIndex) {
            // Get all cells in the table with the specified column class
            const cells = document.querySelectorAll(`.column-${columnIndex}`);
            
            // Toggle the hidden class
            cells.forEach(cell => {
                if (cell.classList.contains('hidden')) {
                    cell.classList.remove('hidden');
                } else {
                    cell.classList.add('hidden');
                }
            });
        }
    </script>
</body>
</html>
