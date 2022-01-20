<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
    <title>Registration system PHP and MySQL</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="header">
    <h2>Register</h2>
</div>

<form method="post" action="server.php">
    <div class="input-group">
        <label>Name</label>
        <input type="text" name="name" value="" required>
    </div>
    <div class="input-group">
        <label>Surname</label>
        <input type="text" name="surname" value="" required>
    </div>
    <div class="input-group">
        <label>Username</label>
        <input type="text" name="login" value="" required>
    </div>
    <div class="input-group">
        <label>Email</label>
        <input type="email" name="email" value="" required>
    </div>
    <div class="input-group">
        <label>Password</label>
        <input type="password" name="password_1" required>
    </div>
    <div class="input-group">
        <label>Confirm password</label>
        <input type="password" name="password_2" required>
    </div>
    <?php
    session_start();
    require_once '2FA/PHPGangsta/GoogleAuthenticator.php';
    $websiteTitle = 'JanVladar';
    $ga = new PHPGangsta_GoogleAuthenticator();
    $secret = $ga->createSecret();
    $_SESSION['secret'] = $secret;
    $qrCodeUrl = $ga->getQRCodeGoogleUrl($websiteTitle, $secret);
    echo 'Google Charts URL QR-Code:<br /><img src="'.$qrCodeUrl.'" />';
    ?>
    <div class="input-group">
        <label>2FA Code</label>
        <input type="text" name="2fa" required>
    </div>
    <div class="input-group">
        <button type="submit" class="btn" name="reg_user">Register</button>
    </div>
    <p>
        Already a member? <a href="login.php">Sign in</a>
    </p>
</form>
</body>
</html>