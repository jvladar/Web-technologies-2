<?php
include('my_config.php');
if (isset($_POST['newUser'])) {
    $sql = "INSERT INTO osoby (name, surname, birth_day,birth_place ,birth_country )
            VALUES ('{$_REQUEST['name']}','{$_REQUEST['surname']}','{$_REQUEST['birth_day']}','{$_REQUEST['birth_place']}','{$_REQUEST['birth_country']}')";

    $result = $conn->query($sql);
    header('Location: http://147.175.98.163/cv2/index.php?');
}

if (isset($_POST['updateUser'])){
    session_start();

    $sql = "UPDATE osoby
            set name='{$_POST['name']}', surname='{$_POST['surname']}', death_day='{$_POST['death_day']}',
            death_place='{$_POST['death_place']}', death_country='{$_POST['death_country']}'
            WHERE id='" . $_SESSION['user_id'] . "' ";
    $result = $conn->query($sql);
    header('Location: http://147.175.98.163/cv2/index.php?');

}
?>