<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

$servername = "localhost";
$username = "xvladar";
$password = 'Mf#$hVFktF1CV1';
$dbname = "logindb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// REGISTER USER
if (isset($_POST['reg_user'])) {
    if ($_POST['password_1'] == $_POST['password_2']) {
        session_start();
        require_once '2FA/PHPGangsta/GoogleAuthenticator.php';
        $ga = new PHPGangsta_GoogleAuthenticator();
        $result = $ga->verifyCode($_SESSION['secret'], $_POST['2fa']);

        $sql12 = "SELECT * FROM USERS WHERE USERS.login = '{$_REQUEST['login']}'";
        $result12 = $conn->query($sql12);
        $row12 = $result12->fetch_assoc();
        if(!empty($row12)){
            ?>
            <script type="text/javascript">
                alert('Toto používatelské meno je už obsadené');
                window.location.href = "index.php";
            </script>
            <?php
        }
        if($result == 1){
            session_start();
            $password = password_hash($_POST["password_1"],PASSWORD_DEFAULT);
            $sql = "INSERT INTO USERS (name,surname,login,email,password,token) VALUES ('{$_REQUEST['name']}','{$_REQUEST['surname']}','{$_REQUEST['login']}','{$_REQUEST['email']}','{$password}','{$_SESSION['secret']}')";
            $result = $conn->query($sql);
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['success'] = "You are now logged in";
            header("Location: http://wt163.fei.stuba.sk/cv3/login.php");
        }
    }
    else{
        echo ("Zla registracia");
    }
}

if($_SESSION['userprofile']){
    session_start();
    $sql = "INSERT INTO USERS (login,email) VALUES ('{$_SESSION['userprofile']['id']}','{$_SESSION['userprofile']['email']}')";
    $result = $conn->query($sql);
}
// LOGIN USER
if (isset($_POST['login_user'])) {
    $login = $_POST['login'];
    $sql = "SELECT id,password,token FROM USERS WHERE USERS.login = '$login'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $password = password_hash($_POST["password"],PASSWORD_DEFAULT);

    if (password_verify($_POST['password'], $row['password'])) {

        require_once '2FA/PHPGangsta/GoogleAuthenticator.php';
        $ga = new PHPGangsta_GoogleAuthenticator();
        $result = $ga->verifyCode($row['token'], $_POST['2fa']);
        if($result == 1){
            session_start();
            $date = date('Y-m-d_H-i-s', time());
            $sql = "INSERT INTO LOGING (user_id,type,logdate) VALUES ('{$row['id']}','classic','$date')";
            $result = $conn->query($sql);
            $_SESSION['id'] = $row['id'];
            header("Location: http://wt163.fei.stuba.sk/cv3/logged.php");
        }
        else{
            echo("zle 2fa");
        }

    } else {
        echo ("Heslo sa nezhoduje");
    }
}
?>