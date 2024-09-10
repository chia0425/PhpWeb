<?php

$pwd = $_POST["username"];
$pwd.=" ";
print($pwd);
$res = [] ;
$count = 0;
$var = "";
for ($i = 0 ; $i < strlen($pwd) ; $i++){
    if($var == "NULL"){
        array_push($res , $var);
        $count = 0;
        $var="";
        continue; //on space continue
    }
    if($pwd[$i] == "."){
        $count++;
    }
    if($count == 3){
        if($pwd[$i] == " "){
            array_push($res , $var);
            $count = 0;
            $var="";
            continue; //on space continue
        }
    }
    $var.=$pwd[$i];
}
print("<br>");
foreach($res as $x){
    print($x);
    print("<br>");
}