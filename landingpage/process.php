<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ip_addresses = $_POST['ip-addresses'];
    $ip_list = preg_split("/\r\n|\n|\r/", $ip_addresses);

    // Filter out empty lines
    $ip_list = array_filter($ip_list, 'trim');

    // Now $ip_list contains an array of IP addresses
    print_r($ip_list);

    foreach($ip_list as $x=>$y){
        print(gettype($y));
        print("<br>");
        print($y);
    }
}