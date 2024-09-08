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

        <form id = "ExcelToPhp" action = "excel/phptoexcel.php" method = "post">
            <div class  = "">
                <label for = "Query">Please Type in Ip Address to test </label>
            </div>
            <div class = "container">
                <div class = "val1">
                <input id = "Ip_Address" type = "text" name = "Ip_Address" placeholder = "Ip_Address" required >
                </div>

                <div class = "val1">
                <input id = "Network_Adapter" type = "text" name = "Network_Adapter" placeholder = "Network_Adapter" required >
                </div>

                <div class = "val1">
                <input id = "Port_Status" type = "text" name = "Port_Status" placeholder = "Port_Status" required >
                </div>

                <div class = "SubmitButton">
                <button type="submit">Submit</button>
                </div>
                
            </div>
           
        </form>
    </main>


</body>
</html>