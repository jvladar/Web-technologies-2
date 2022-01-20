<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
    <title>Registration system PHP and MySQL</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
</head>
<body>
<div class="header">
    <h2>Login</h2>
</div>

<form method="post" action="server.php">
    <div class="input-group">
        <label>Username</label>
        <input type="text" name="login" required>
    </div>
    <div class="input-group">
        <label>Password</label>
        <input type="password" name="password" required>
    </div>
    <div class="input-group">
        <label>2FA Code</label>
        <input type="text" name="2fa" required>
    </div>
    <div class="input-group">
        <button type="submit" class="btn btn-block btn-stuba" name="login_user">Login</button>
    </div>
    <p>
        Not yet a member? <a href="index.php" >Sign up</a>
    </p>
    <a href="./oauth2/index.php" class="btn btn-block btn-google"> <i class="fab fa-google"></i>&nbsp Prihlás sa cez Google</a>
    <br>
    <a href="./ldap/index.php"class="btn btn-block btn-stuba"> <i class="fab fa-stripe-s"></i> &nbsp Prihlás sa cez STUBA</a>
</form>
</body>
</html>