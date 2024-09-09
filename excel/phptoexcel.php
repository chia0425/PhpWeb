<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ip_Add = $_POST['Ip_Address'];
    $Nw_adap = $_POST['Network_Adapter'];
    $port_status = $_POST['Port_Status'];

    
}
$output = '
<table border = "1">
        <tr>
            <th>IP Add</th>
            <th>Network Adapter</th>
            <th>Port Status</th>
        </tr>
        ';
$output.= '
        <tr>
            <td>' .$ip_Add . '</td>
            <td>' .$Nw_adap . '</td>
            <td>' .$port_status. '</td>
        </tr>
';
$output .= '</table>';
//https://www.youtube.com/watch?v=N0kYa5-IkeI&ab_channel=JaydeepSapariya
header('Content-type: application/vnd.ms-excel');
header('Content-Disposition:attachment;filename=report.xls');
echo $output;