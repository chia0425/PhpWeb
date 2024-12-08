<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Data Display</title>
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
            max-width: 400px; /* Limiting max width */
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        #grid {
            width: 100%;
            height: 500px;  /* Set height for scrollable area */
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #fff;
            overflow-y: auto; /* Enable vertical scroll */
        }

        /* Right-click menu styles */
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

        /* Adding blue line under the header row */
        .slick-header {
            border-bottom: 2px solid #007bff; /* Blue line under header row */
        }
    </style>
</head>
<body>
    <h1>Financial Data Viewer</h1>

    <!-- Search Bar -->
    <div id="search-bar">
        <label for="search-input"><strong>Search Project:</strong></label>
        <input type="text" id="search-input" placeholder="Enter project name or keyword">
    </div>

    <!-- SlickGrid Container -->
    <div id="grid"></div>

    <!-- Right-Click Context Menu -->
    <div id="context-menu" class="slick-grid-context-menu">
        <a id="toggle-column">Hide Column</a>
    </div>

    <!-- Include SlickGrid Dependencies -->
    <script src="SlickGrid-master/SlickGrid-master/lib/jquery-1.7.min.js"></script>
    <script src="SlickGrid-master/SlickGrid-master/lib/jquery.event.drag-2.2.js"></script>
    <script src="SlickGrid-master/SlickGrid-master/slick.core.js"></script>
    <script src="SlickGrid-master/SlickGrid-master/slick.grid.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Sample financial data
            const financialData = [
                { id: 1, project: "Project Alpha", budget: "$100,000", spent: "$75,000", remaining: "$25,000" },
                { id: 2, project: "Project Beta", budget: "$200,000", spent: "$150,000", remaining: "$50,000" },
                { id: 3, project: "Project Gamma", budget: "$300,000", spent: "$270,000", remaining: "$30,000" },
                { id: 4, project: "Project Delta", budget: "$50,000", spent: "$20,000", remaining: "$30,000" },
                { id: 5, project: "Project Epsilon", budget: "$150,000", spent: "$100,000", remaining: "$50,000" },
                { id: 6, project: "Project Zeta", budget: "$500,000", spent: "$350,000", remaining: "$150,000" },
                { id: 7, project: "Project Eta", budget: "$80,000", spent: "$60,000", remaining: "$20,000" },
                { id: 8, project: "Project Theta", budget: "$120,000", spent: "$90,000", remaining: "$30,000" },
                { id: 9, project: "Project Iota", budget: "$200,000", spent: "$120,000", remaining: "$80,000" },
                { id: 10, project: "Project Kappa", budget: "$600,000", spent: "$500,000", remaining: "$100,000" },
                // Add more data if needed
            ];

            // Define columns for SlickGrid, setting id to visible: false to hide it
            let columns = [
                { id: "id", name: "ID", field: "id", width: 50, visible: false }, // Set visible to false
                { id: "project", name: "Project", field: "project", width: 150, visible: true },
                { id: "budget", name: "Budget", field: "budget", width: 100, visible: true },
                { id: "spent", name: "Spent", field: "spent", width: 100, visible: true },
                { id: "remaining", name: "Remaining", field: "remaining", width: 100, visible: true },
            ];

            // Grid options
            const options = {
                enableCellNavigation: true,
                enableColumnReorder: false,
                forceFitColumns: true,
            };

            // Initialize SlickGrid
            let visibleColumns = columns.filter(col => col.visible);
            let grid = new Slick.Grid("#grid", financialData, visibleColumns, options);

            // Search functionality
            document.getElementById("search-input").addEventListener("input", function () {
                const query = this.value.toLowerCase();
                const filteredData = financialData.filter(row =>
                    row.project.toLowerCase().includes(query)
                );
                grid.setData(filteredData);
                grid.render();
            });

            // Context menu (right-click) functionality
            let contextMenu = document.getElementById("context-menu");
            let selectedColumnIndex = -1;

            // Show context menu on right-click over column header
            $(grid.getHeaderRow()).on("contextmenu", ".slick-header-column", function (e) {
                e.preventDefault();
                selectedColumnIndex = $(this).index();
                let column = columns[selectedColumnIndex];

                // Toggle text based on column visibility
                if (column.visible) {
                    $("#toggle-column").text("Hide Column");
                } else {
                    $("#toggle-column").text("Show Column");
                }

                contextMenu.style.left = `${e.pageX}px`;
                contextMenu.style.top = `${e.pageY}px`;
                contextMenu.style.display = "block";
            });

            // Hide/unhide column when menu item is clicked
            document.getElementById("toggle-column").addEventListener("click", function () {
                if (selectedColumnIndex !== -1) {
                    let column = columns[selectedColumnIndex];
                    column.visible = !column.visible;

                    // Update grid columns
                    visibleColumns = columns.filter(col => col.visible);
                    grid.setColumns(visibleColumns);

                    // Hide context menu
                    contextMenu.style.display = "none";
                }
            });

            // Close context menu when clicking elsewhere
            $(document).on("click", function (e) {
                if (!$(e.target).closest("#context-menu").length) {
                    contextMenu.style.display = "none";
                }
            });
        });
    </script>
</body>
</html>
