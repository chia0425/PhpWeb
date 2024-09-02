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

        <form id = "LoginForm" action = "includes/formhandler.inc.php" method = "post">
            <div class  = "container">
                <label for = "LogIn">Log In </label>
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
                
            </div>
            <div class = "updateButton">
                <button onclick="window.location.href='update.php';" type="Go Update Page">Go update Page</button>
            </div>
            <div class = "RegisterButton">
                <button onclick="window.location.href='registration.php';" type="Go Register Page">Go regi Page</button>
            </div>
            <div class = "deleteButton">
                <button onclick="window.location.href='delete.php';" type="Go Delete Page">Go del Page</button>
            </div>
        </form>
    </main>


</body>
</html>