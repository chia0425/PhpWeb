<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ip_Add = $_POST['Ip_Address'];
    $Nw_adap = $_POST['Network_Adapter'];
    $port_status = $_POST['Port_Status'];

    
}
$output = '
<table class "table bordered = "1">
        <tr>
            <td>IP Add</td>
            <td>Network Adapter</td>
            <td>Port Status</td>
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
header('Content-type: application/xls');
header('Content-Disposition:attachment;filename=report.xls');
echo $output;