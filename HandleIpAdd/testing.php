<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../includes/styles.css">
    <title>Document</title>
</head>
<body>
    <main>

        <form id = "LoginForm" action = "HandleIpAdd/handleip.inc.php" method = "post">
            <div class  = "container">
                <label for = "LogIn">Log In </label>
            </div>
            <div class = "container">
                <div class = "val1">
                <input id = "username" type = "text" name = "username" placeholder = "username" required >
                </div>
                
                <div class = "calcButton">
                <button type="submit">Submit</button>
                </div>
                
            </div>
        </form>
    </main>


</body>
</html>