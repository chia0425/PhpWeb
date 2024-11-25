<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ip_Add = htmlspecialchars($_POST['Ip_Address']);
    $Nw_adap = htmlspecialchars($_POST['Network_Adapter']);
    $port_status = htmlspecialchars($_POST['Port_Status']);
}

// Function to apply background color based on port status
function getColorForStatus($status) {
    if ($status === 'Up') {
        return 'background-color: #00FF00;'; // Green for 'Up'
    } elseif ($status === 'Down') {
        return 'background-color: #FF0000;'; // Red for 'Down'
    } else {
        return 'background-color: #FFFF00;'; // Yellow for other statuses
    }
}

// Prepare the HTML table content with additional information
$output = '
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style>
        table { border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 5px; text-align: center; }
        .small-text { font-size: 10px; color: #555; } /* Smaller text for previous month */
    </style>
</head>
<body>
    <table>
        <tr>
            <th>IP Add</th>
            <th>Network Adapter</th>
            <th>Port Status</th>
        </tr>
        <tr>
            <td>' . $ip_Add . '</td>
            <td>' . $Nw_adap . '</td>
            <td style="' . getColorForStatus($port_status) . '">
                ' . $port_status . '
                <div class="small-text">(Prev month: Down)</div>
            </td>
        </tr>
    </table>
</body>
</html>';

// Send headers to force download as HTML file (Excel will open it)
header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
header('Content-Disposition: attachment; filename="report.xls"');

// Output the HTML content
echo $output;
?>