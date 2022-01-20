<?php
if (isset($_REQUEST["Change"])) {
    $dbhost = 'localhost';
    $dbuser = 'xvladar';
    $dbpass = 'Mf#$hVFktF1CV1';
    $dbname = 'users';

    session_start();
    $con = mysqli_connect($dbhost, $dbuser, $dbpass);
    mysqli_select_db($con, $dbname) or die(mysqli_error($con));

    $new_pass = $_REQUEST["new_pass"];

    if($_GET["csrf_token"] == $_SESSION["token"] && $_GET["csrf_token"]!= null ){
        if ($new_pass) {
            $query = "UPDATE user SET pass='$new_pass' WHERE id=1;";
            $result = mysqli_query($con, $query) or die('<pre>' . mysqli_error($con) . '<pre>');
            if ($result) {
                echo "<h2>Password Changed to" . $new_pass . "</h2>";
            } else {
                echo "<pre><br/>Error. Password doesnt changed.</pre>";
            }
        } else {
            echo "<h2>Password did not match</h2>";
        }
    }
    session_destroy ();
    mysqli_close($con);
}
?>