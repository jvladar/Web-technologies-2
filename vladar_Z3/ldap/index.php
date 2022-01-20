<?php

if(isset($_POST['username'])){
$username = $_POST['username'];
$password = $_POST['password'];

$servername = "localhost";
$username1 = "xvladar";
$password1 = 'Mf#$hVFktF1CV1';
$dbname = "logindb";

// Create connection
    $conn = new mysqli($servername, $username1, $password1, $dbname);
// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

$ldapconfig['host'] = 'ldap.stuba.sk';//CHANGE THIS TO THE CORRECT LDAP SERVER
$ldapconfig['port'] = '389';
$ldapconfig['basedn'] = 'ou=People, dc=stuba, dc=sk';//CHANGE THIS TO THE CORRECT BASE DN
$ldapconfig['usersdn'] = 'cn=users';//CHANGE THIS TO THE CORRECT USER OU/CN
$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);

ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
ldap_set_option($ds, LDAP_OPT_NETWORK_TIMEOUT, 10);

$dn="uid=".$username.",".$ldapconfig['basedn'];
if(isset($_POST['username'])){
if ($bind=ldap_bind($ds, $dn, $password)) {

    $sql = "SELECT * FROM USERS WHERE USERS.login = '$username'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if(!$row['id']){
        $password = password_hash($password,PASSWORD_DEFAULT);
        $sql1 = "INSERT INTO USERS (login,password) VALUES ('$username','$password')";
        $result1 = $conn->query($sql1);
    }

    $sql2 = "SELECT * FROM USERS WHERE USERS.login = '$username'";
    $result2 = $conn->query($sql2);
    $row2 = $result2->fetch_assoc();

    $date = date('Y-m-d_H-i-s', time());
    $sql3 = "INSERT INTO LOGING (user_id,type,logdate) VALUES ('{$row2['id']}','ldap','$date')";
    $result3 = $conn->query($sql3);

    session_start();
    $_SESSION['id'] = $row2['id'];
    header("Location: http://wt163.fei.stuba.sk/cv3/logged.php");
} else {
    echo "Login Failed: Please check your username or password";
}
}
}
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
<form method="post" action="">

    <div class="input-group">
        <label>Username</label>
        <input type="text" name="username" required>
    </div>
    <div class="input-group">
        <label>Password</label>
        <input type="password" name="password" required>
    </div>

    <div class="input-group">
        <button type="submit" class="btn" value="submit">Register</button>
    </div>
</form>
</body>
</html>
