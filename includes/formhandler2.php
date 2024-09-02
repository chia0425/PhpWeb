<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstval = htmlspecialchars($_POST["firstval"]);
    $secval = htmlspecialchars($_POST["secval"]);
    $operation = htmlspecialchars($_POST["operation"]);
    $sum = 0;
    if(empty($firstval)){
        echo "Error";
        echo $firstval;
        exit();
        header("Location :  ../index.php");
    }
    echo $firstval;
    echo "<br>";
    echo $secval;
    echo "<br>";
    echo $operation;
    echo "<br>";
    switch($operation) {
        case "add":
            $sum = $firstval + $secval;
            break;
        case "subtract":
            $sum = $firstval - $secval;
            break;
        case "divide":
            $sum = $firstval / $secval;
            break;
        case "multiply":
            $sum = $firstval * $secval;
            break;
        default:
            echo "error has occured";
            header("Location :  ../index.php"); #if error return to index.php
    }
    echo "Result of " ;
    echo $firstval;
    echo " ";
    echo $operation;
    echo " ";
    echo $secval;
    echo " = ";
    echo $sum;
    // header("Location : ../index.php");
}