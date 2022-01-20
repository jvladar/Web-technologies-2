<?php

session_start();
$_SESSION['index'] = 1;

?>
<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="UTF-8" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
    <title>Zadanie 5</title>
</head>

<body>
    <div class="row">
        <div class="container mt-5">
            <div class="xs-col-12">

                <h3>Goniometrické funkcie</h3>  
                <form method="post" action="index.php" id="formular">              
                        <input type="number" class="form-control"  id="cislo" name="cislo" placeholder="Enter number">
                        <input type="checkbox" name="sin" id="sin" checked="checked"> Sinuus 
                        <input type="checkbox" name="cos" id="cos" checked="checked"> Cosinus 
                        <input type="checkbox" name="sincos" id="sincos" checked="checked"> Sin&Cos 
                        <input type="submit" name="submit">
                </form>  
                <div id="result"></div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="./js/script.js"></script>
</body>
</html>