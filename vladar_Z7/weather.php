<?php
session_start();

if (!isset($_SESSION['access']) || $_SESSION['access'] == false) {
    header("Location: ./index.php");
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>

    <link rel="stylesheet" href="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<div class="container">
    <div class="row">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" id="weather" href="weather.php">Počasie</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id ="ip_adress" href="ip.php">IP Adresa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id ="countries" href="countries.php">Krajiny</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div id="weather-img"></div>
        <h2>Teplota</h2>
        <p id="temperature"></p>
        <h2>Pocitová teplota</h2>
        <p id="feels_temperature"></p>
        <h2>Východ slnka</h2>
        <p id="sunrise"></p>
        <h2>Západ slnka</h2>
        <p id="sunset"></p>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0"
        crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="weather.js"></script>
</body>
</html>
