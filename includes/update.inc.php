<?php

header('Content-Type: application/json'); // Set content type to JSON

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $pwd = $_POST["password"];
    $email = $_POST["email"];



    try {
        require_once "dbh.inc.php"; //access code in another file

        $query = "UPDATE users SET username = ?, pwd = ?, email = ? WHERE id = 2;";;

        $stmt = $pdo->prepare($query);
        $stmt->execute([$username,$pwd,$email]);

        $pdo = null;
        $stmt = null;
    
        header("Location: ../registration.php");
        die();

        // $query = $query = "INSERT INTO users(username,pwd,email) VALUES  //another way prepare statement
        // (:username,:pwd,:email);";
        // $stmt = $pdo->prepare($query);
        // $stmt->bindParam(":username" , $username)
        // $stmt->bindParam(":pwd" , $pwd)
        // $stmt->bindParam(":email" , $email)
        // $stmt->execute()

    }catch (PDOException $e){
        die(
            "Query failed ". $e->getMessage()
        );
    }
}
else{
    header("Location: ../registration.php");
}