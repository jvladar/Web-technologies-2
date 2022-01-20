<?php
    require_once 'PHPGangsta/GoogleAuthenticator.php';
    $secret = 'BL5OGQMGRIXDPH2B';
 
    if (isset($_POST['code'])) {
        $code = $_POST['code'];
 
        $ga = new PHPGangsta_GoogleAuthenticator();
        $result = $ga->verifyCode($secret, $code);
 
        if ($result == 1) {
            echo $result;
        } else {
            echo 'Login failed';
        }
    }
?>
