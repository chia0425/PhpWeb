<?php

// header('Content-Type: application/json'); // Set content type to JSON

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $pwd = $_POST["password"];
    // $email = $_POST["email"];



    try {
        require_once "dbh.inc.php"; //access code in another file

        $query = "SELECT * FROM users WHERE username = ? AND pwd = ? ;";

        $stmt = $pdo->prepare($query);
        $stmt->execute([$username,$pwd]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC); // Fetches the result as an associative array
        if ($result) {
            echo "User found: " . $result['username'] . " with email " . $result['email'];
        }
        else {
            echo "No user found with that username.";
        }

        $query2 = "SELECT * FROM comments WHERE username = ?;";
        $stmt = $pdo->prepare($query2);
        $stmt->execute([$username]);
        $result2 = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetches the result as an associative array

        $pdo = null;
        $stmt = null;
        // header("Location: ../registration.php");
        // die();

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<h3>
    Search Results : 
</h3>
<?php

    if ($result) {
            echo "User found: " . $result['username'] . " with email " . $result['email'];
            echo "<div>";
            echo "<p> username : " .  htmlspecialchars($result['username'], ENT_QUOTES, 'UTF-8'). " </p>";
            echo "<p> email : " .   htmlspecialchars($result['email'], ENT_QUOTES, 'UTF-8') . " </p>";
            echo "</div>";
            // var_dump($result2);
            foreach( $result2 as $row){
                echo "<div>";
                echo "<h3> ID : " . $row['id'] . "</h3>";
                echo "<p> Username : " . $row['username'] . "</p>";
                echo "<p> Comments : " . $row["comments"] . "</p>";
                echo "<p><b> Created At : " . $row["created_at"] . " </b></p>";
                echo "<p> User ID : " . $row["user_id"] . "</p>";
                echo "</div>";
                
            }
        }
        else {
            echo "No user found with that username.";
        }
    ?>
    
</body>
</html>