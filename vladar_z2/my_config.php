<?php
$servername = "localhost";
$username = "xvladar";
$password = 'Mf#$hVFktF1CV1';
$dbname = "zadanie2";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['del'])) {
    $id = $_GET['del'];
    $sql = "DELETE FROM osoby WHERE id= '$id'";
    $result = $conn->query($sql);
    header('Location: http://147.175.98.163/cv2/index.php?');
}
if (isset($_GET['user'])){
    session_start();
    $id = $_GET['user'];
    $_SESSION['id'] = $id;
    header('Location: http://147.175.98.163/cv2/user.php?');
}
if (isset($_GET['add'])){
    session_start();
    $id = $_GET['add'];
    $_SESSION['id'] = $id;
    header('Location: http://147.175.98.163/cv2/add.php?');
}

if (isset($_POST['back'])) {
    header('Location: http://147.175.98.163/cv2/index.php?');
}

if(isset($_GET['edit'])){
    session_start();
    $user_id = $_GET['edit'];
    $_SESSION['user_id'] = $user_id;
    header('Location: http://147.175.98.163/cv2/edit.php?');
}

if (isset($_POST['newResult'])) {
    $sql = "INSERT INTO umiestnenia (person_id, oh_id, placing, discipline)
            VALUES ('{$_REQUEST['person_id']}','{$_REQUEST['oh_id']}','{$_REQUEST['placing']}','{$_REQUEST['discipline']}')";
    $result = $conn->query($sql);

    header("Location: http://147.175.98.163/cv2/user.php?");
}

?>









