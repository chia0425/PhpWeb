<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SlickGrid with Export to Excel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slickgrid@2.4.17/slick.grid.css">
</head>
<body>
    <div id="myGrid" style="width:100%;height:500px;"></div>
    <button id="download">Download as XLSX</button>

    <!-- jQuery and SlickGrid dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.event.drop/2.2/jquery.event.drop.min.js"></script>
    <script src="jquery.event.drag.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.event.drop/2.2/jquery.event.drop.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slickgrid@2.4.17/slick.core.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slickgrid@2.4.17/slick.grid.js"></script>

    <!-- SheetJS Community Version -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script> <!-- For Excel generation -->

    <script>
        // SlickGrid Data and Column Definitions
        var grid;
        var columns = [
            { id: "name", name: "Name", field: "name" },
            { id: "age", name: "Age", field: "age" },
            { id: "score", name: "Score", field: "score" }
        ];

        var options = {
            enableCellNavigation: true,
            enableColumnReorder: false
        };

        var data = [
            { name: "John", age: 25, score: 88 },
            { name: "Jane", age: 30, score: 95 },
            { name: "Tom", age: 22, score: 75 }
        ];

        // Initialize SlickGrid
        $(function () {
            grid = new Slick.Grid("#myGrid", data, columns, options);
        });

        // Convert SlickGrid data to an array of arrays (for SheetJS)
        function slickgridToSheet() {
            var rowData = [];
            var headers = columns.map(col => col.name);

            rowData.push(headers); // Adding headers as the first row

            // Adding data from SlickGrid
            for (var i = 0; i < data.length; i++) {
                var row = [];
                for (var j = 0; j < columns.length; j++) {
                    row.push(data[i][columns[j].field]);
                }
                rowData.push(row);
            }

            return rowData;
        }

        // Download XLSX file (without styling, just plain data)
        function downloadXlsx() {
            console.log('Download button clicked'); // Check if button click is registering
            var wb = XLSX.utils.book_new(); // Create a new workbook
            var wsData = slickgridToSheet(); // Convert grid data to sheet data
            var ws = XLSX.utils.aoa_to_sheet(wsData); // Convert array of arrays to sheet

            // Append worksheet to the workbook
            XLSX.utils.book_append_sheet(wb, ws, "SlickGrid Data");

            // Write workbook to file
            XLSX.writeFile(wb, "SlickGridData.xlsx");
        }

        // Event listener for the Download button
        document.getElementById("download").addEventListener("click", function() {
            downloadXlsx();
        });
    </script>
</body>
</html>