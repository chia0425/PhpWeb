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
        <form action = "includes/formhandler.php" method = "post">
            <!-- <label for = "first value"  >First Value?</label> -->
            <div class = "container">
                <div class = "val1">
                <input id = "firstval" type = "number" name = "firstval" placeholder = "FirstValue" required >
                </div>

                <!-- <label for = "operator"  >Operation?</label> -->
                <div class = "val1">
                    <select id = "operator" name = "operation">
                        <option value = "add">Addition</option>
                        <option value = "subtract">Subtract</option>
                        <option value = "divide">Divide</option>
                        <option value = "multiply">Multiply</option>
                    </select>
                </div>


                <!-- <label for = "second value"  >Second Value?</label> -->
                 <div class = "val1">
                <input id = "secondval" type = "number" name = "secval"  placeholder = "SecondValue" required >
                </div>

                <div class = "calcButton">
                <button type="calculate">Submit</button>
                </div>
            </div>
        </form>
    </main>


</body>
</html>