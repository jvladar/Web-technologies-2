<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    session_start();
    if (empty($_SESSION['token'])) {
        $_SESSION['token'] = bin2hex(random_bytes(32));
    }
    $token = $_SESSION['token'];
    ?>

    <form method="GET" action="csrfChange.php">
        <label for="lname">Nové heslo:</label><br>
        <input type="text" id="new_pass" name="new_pass">
        <input type="hidden" name="csrf_token" value="<?php echo $token;?>"/>
        <input type="submit" name="Change" value="Submit"/>
    </form>
</body>
</html>