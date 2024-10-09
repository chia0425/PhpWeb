<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table with Collapsible Columns</title>
    <style>
        /* Styling for the table */
        .styled-table {
            width: 100%;
            border-collapse: collapse;
        }

        .styled-table th, .styled-table td {
            border: 1px solid #ddd;
            padding: 8px;
            position: relative; /* For positioning the toggle button */
        }

        .styled-table th {
            background-color: #f2f2f2;
        }

        /* Hidden columns */
        .hidden {
            display: none;
        }

        /* Toggle button styles */
        .toggle-btn {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            padding: 2px 5px;
            cursor: pointer;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <h2>Sample Table with Collapsible Columns</h2>

    <table class="styled-table">
        <thead>
            <tr>
                <th class="column-1-header">
                    Column 1
                    <button class="toggle-btn" onclick="toggleColumn(1, this)">Hide</button>
                </th>
                <th class="column-2-header">
                    Column 2
                    <button class="toggle-btn" onclick="toggleColumn(2, this)">Hide</button>
                </th>
                <th class="column-3-header">
                    Column 3
                    <button class="toggle-btn" onclick="toggleColumn(3, this)">Hide</button>
                </th>
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
        function toggleColumn(columnIndex, button) {
            // Select both header and cells for the specified column
            const cells = document.querySelectorAll(`.column-${columnIndex}, .column-${columnIndex}-header`);

            // Toggle the hidden class for each cell and header
            cells.forEach(cell => {
                cell.classList.toggle('hidden');
            });

            // Check if the column is now hidden, and update button text accordingly
            const isHidden = cells[0].classList.contains('hidden');
            button.textContent = isHidden ? 'Show' : 'Hide';
        }
    </script>
</body>
</html>
