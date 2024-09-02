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

        <form id = "registrationForm" action = "includes/formhandler.inc.php" method = "post">
            <div class  = "container">
                <label for = "SignUP">SIGN UP </label>
            </div>
            <div class = "container">
                <div class = "val1">
                <input id = "username" type = "text" name = "username" placeholder = "username" required >
                </div>

                <div class = "val1">
                <input id = "password" type = "password" name = "password" placeholder = "password" required >
                </div>

                <div class = "val1">
                <input id = "email" type = "text" name = "email" placeholder = "email" required >
                </div>

                <div class = "calcButton">
                <button type="submit">Submit</button>
                </div>
                
            </div>
        <div class = "loginButton">
            <button onclick="window.location.href='login.php';" type="Go Login Page">Go Login Page</button>
        </div>
        <div class = "updatebutton">
            <button onclick="window.location.href='update.php';" type="Go update Page">Go update Page</button>
        </div>
        <div class = "deleteButton">
            <button onclick="window.location.href='delete.php';" type="Go delete Page">Go del Page</button>
        </div>
        </form>
    </main>


</body>
</html>