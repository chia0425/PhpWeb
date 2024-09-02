<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="includes/styles.css">
    <title>Document</title>
</head>
<body>
    <main>

        <form id = "searchForm" action = "includes/search.inc.php" method = "POST">
            <div class  = "container">
                <label for = "SignUP">search Account</label>
            </div>
            <div class = "container">
                <div class = "val1">
                <input id = "username" type = "text" name = "username" placeholder = "username" required >
                </div>

                <div class = "val1">
                <input id = "password" type = "password" name = "password" placeholder = "password" required >
                </div>

                <div class = "calcButton">
                <button type="submit">Submit</button>
                </div>
            <div class = "loginButton">
                <button onclick="window.location.href='login.php';" type="Go Login Page">Go Login Page</button>
            </div>
            <div class = "RegisterButton">
                <button onclick="window.location.href='registration.php';" type="Go Register Page">Go register Page</button>
            </div>
            <div class = "deleteButton">
                <button onclick="window.location.href='delete.php';" type="Go delete Page">Go del Page</button>
            </div>