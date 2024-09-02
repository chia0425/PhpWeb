<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // $firstval = htmlspecialchars($_POST["firstval"]);
    // $secval = htmlspecialchars($_POST["secval"]);
    // $operation = htmlspecialchars($_POST["operation"]);

    $firstval = filter_input(INPUT_POST, "firstval", FILTER_SANITIZE_NUMBER_FLOAT);
    $secval= filter_input(INPUT_POST, "secval", FILTER_SANITIZE_NUMBER_FLOAT);
    $operation = htmlspecialchars($_POST["operation"]);

    //error handler
    $error = FALSE;
    if(empty($firstval) || empty($secval) || empty($operation) ){
        $error = TRUE;
        echo '<script type="text/javascript">
        alert("Error: One of the values is empty. You will be redirected to the main page.");
        window.location.href = "../index.php";
      </script>';
        exit();
    }
    echo $firstval;
    echo "<br>";
    echo $secval;
    echo "<br>";
    echo $operation;
    echo "<br>";
    if(!$error){
        $sum = 0;
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
                header("Location:  ../index.php"); #if error return to index.php
        }
    }
    echo "Result of " ;
    echo $firstval;
    echo " ";
    echo $operation;
    echo " ";
    echo $secval;
    echo " = ";
    echo $sum;
    sleep(3);
    // header("Location: ../index.php");
}