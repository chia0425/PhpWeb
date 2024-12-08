<?php
// // Include the XLSXWriter class
// require_once 'path_to_PHP_XLSXWriter/XLSXWriter.php'; // Adjust the path

// // Check if the request is POST and contains data for downloading
// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'download') {
//     // Check if data is sent in the request
//     if (isset($_POST['data']) && !empty($_POST['data'])) {
//         // Decode the JSON-encoded data sent via AJAX
//         $data = json_decode($_POST['data'], true);
        
//         // Create a new XLSXWriter instance
//         $writer = new XLSXWriter();

//         // Assuming the first row contains the column headers
//         $headers = $data[0]; // First row is headers
//         $writer->writeSheetHeader('Sheet1', array_flip($headers)); // Write the headers

//         // Write the remaining data (excluding the headers)
//         foreach ($data as $index => $row) {
//             // Skip the first row as it's the header
//             if ($index > 0) {
//                 $writer->writeSheetRow('Sheet1', $row);
//             }
//         }

//         // Set the response headers for Excel download
//         header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//         header('Content-Disposition: attachment;filename="financial_data.xlsx"');
//         header('Cache-Control: max-age=0');

//         // Write to PHP output stream
//         $writer->writeToStdOut(); // This sends the Excel file to the browser

//         exit; // Stop further script execution
//     } else {
//         echo "No data received.";
//         exit;
//     }
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Data Viewer</title>
    <link rel="stylesheet" type="text/css" href="SlickGrid-master/SlickGrid-master/slick.grid.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f8f9fa;
        }

        h1 {
            color: #007bff;
            margin-bottom: 20px;
        }

        #search-bar {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 4px;
            display: flex;
            align-items: center;
        }

        #search-input {
            width: 100%;
            max-width: 300px; /* Limiting max width */
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-right: 10px; /* Space between search and download button */
        }

        #download-btn {
            padding: 8px 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        #download-btn:hover {
            background-color: #0056b3;
        }

        #grid {
            width: 100%;
            height: 500px; /* Fixed height */
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #fff;
            overflow-y: auto; /* Enable vertical scroll when content overflows */
        }

        .slick-grid-context-menu {
            position: absolute;
            background: #fff;
            border: 1px solid #ddd;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            display: none;
            z-index: 1000;
            border-radius: 4px;
            width: 150px;
            font-size: 14px;
        }

        .slick-grid-context-menu a {
            padding: 8px 10px;
            display: block;
            cursor: pointer;
            text-decoration: none;
            color: #333;
        }

        .slick-grid-context-menu a:hover {
            background-color: #f8f9fa;
        }

        .slick-header {
            border-bottom: 2px solid #007bff;
        }
    </style>
</head>
<body>
    <h1>Financial Data Viewer</h1>
    <div id="search-bar">
        <label for="search-input">Search Project: </label>
        <input type="text" id="search-input" placeholder="Enter project name or keyword">
        <button id="download-btn">Download</button>
    </div>
    <div id="grid"></div>

    <script src="SlickGrid-master/SlickGrid-master/lib/jquery-1.7.min.js"></script>
    <script src="SlickGrid-master/SlickGrid-master/lib/jquery.event.drag-2.2.js"></script>
    <script src="SlickGrid-master/SlickGrid-master/slick.core.js"></script>
    <script src="SlickGrid-master/SlickGrid-master/slick.grid.js"></script>
    <script>
        // Mock financial data (replace this with actual AJAX fetch from SQL)
        const financialData = [
            { id: 1, project: "Project Alpha", budget: "$100,000", spent: "$75,000", remaining: "$25,000" },
            { id: 2, project: "Project Beta", budget: "$200,000", spent: "$150,000", remaining: "$50,000" },
            { id: 3, project: "Project Gamma", budget: "$300,000", spent: "$270,000", remaining: "$30,000" },
            { id: 4, project: "Project Delta", budget: "$50,000", spent: "$20,000", remaining: "$30,000" },
            { id: 5, project: "Project Epsilon", budget: "$400,000", spent: "$300,000", remaining: "$100,000" },
            { id: 6, project: "Project Zeta", budget: "$120,000", spent: "$100,000", remaining: "$20,000" },
            { id: 7, project: "Project Eta", budget: "$250,000", spent: "$180,000", remaining: "$70,000" },
            { id: 8, project: "Project Theta", budget: "$320,000", spent: "$270,000", remaining: "$50,000" },
            { id: 9, project: "Project Iota", budget: "$540,000", spent: "$460,000", remaining: "$80,000" },
            { id: 10, project: "Project Kappa", budget: "$500,000", spent: "$400,000", remaining: "$100,000" },
            { id: 11, project: "Project Alpha", budget: "$100,000", spent: "$75,000", remaining: "$25,000" },
            { id: 12, project: "Project Beta", budget: "$200,000", spent: "$150,000", remaining: "$50,000" },
            { id: 13, project: "Project Gamma", budget: "$300,000", spent: "$270,000", remaining: "$30,000" },
            { id: 14, project: "Project Delta", budget: "$50,000", spent: "$20,000", remaining: "$30,000" },
            { id: 15, project: "Project Epsilon", budget: "$400,000", spent: "$300,000", remaining: "$100,000" },
            { id: 16, project: "Project Zeta", budget: "$120,000", spent: "$100,000", remaining: "$20,000" },
            { id: 17, project: "Project Eta", budget: "$250,000", spent: "$180,000", remaining: "$70,000" },
            { id: 18, project: "Project Theta", budget: "$320,000", spent: "$270,000", remaining: "$50,000" },
            { id: 19, project: "Project Iota", budget: "$540,000", spent: "$460,000", remaining: "$80,000" },
            { id: 20, project: "Project Kappa", budget: "$500,000", spent: "$400,000", remaining: "$100,000" },
            { id: 21, project: "Project Kappa", budget: "$500,000", spent: "$400,000", remaining: "$100,000" },
            { id: 22, project: "Project Kappa", budget: "$500,000", spent: "$400,000", remaining: "$100,000" },
            { id: 23, project: "Project Kappa", budget: "$500,000", spent: "$400,000", remaining: "$100,000" },
            { id: 24, project: "Project Kappa", budget: "$500,000", spent: "$400,000", remaining: "$100,000" },
        ];

        // Column definitions for SlickGrid
        const columns = [
            { id: "id", name: "ID", field: "id", width: 50 },
            { id: "project", name: "Project", field: "project", width: 150 },
            { id: "budget", name: "Budget", field: "budget", width: 100 },
            { id: "spent", name: "Spent", field: "spent", width: 100 },
            { id: "remaining", name: "Remaining", field: "remaining", width: 100 },
        ];

        // Options for SlickGrid
        const options = {
            enableCellNavigation: true,
            enableColumnReorder: false,
            forceFitColumns: true,
            fullWidthRows: true,
            //autoHeight: true
        };

        // Initialize SlickGrid
        let grid = new Slick.Grid("#grid", financialData, columns, options);

        // Search functionality
        document.getElementById("search-input").addEventListener("input", function () {
            const query = this.value.toLowerCase();
            const filteredData = financialData.filter(row => 
                row.project.toLowerCase().includes(query)
            );
            grid.setData(filteredData);
            grid.render();
        });

        // Download functionality
        document.getElementById("download-btn").addEventListener("click", function () {
            // Get the data from the table (including headers)
            var tableData = [];
            var rows = document.querySelectorAll("#grid .slick-row");

            // Get column headers
            var headers = [];
            document.querySelectorAll("#grid .slick-header-columns .slick-header-column").forEach(function(header) {
                headers.push(header.textContent.trim());
            });

            // Extract row data
            rows.forEach(function(row) {
                var rowData = [];
                row.querySelectorAll(".slick-cell").forEach(function(cell) {
                    rowData.push(cell.textContent.trim());
                });
                tableData.push(rowData);
            });

            // Add headers as the first row
            tableData.unshift(headers);

            // Send the data via AJAX to PHP for Excel generation
            $.ajax({
                url: 'icor.php',  // Same page URL
                type: 'POST',
                data: {
                    action: 'download',
                    data: JSON.stringify(tableData) // Send data as JSON
                },
                success: function(response) {
                    console.log("Download successful");
                },
                error: function() {
                    alert("Error downloading data");
                }
            });
        });
    </script>
</body>
</html>