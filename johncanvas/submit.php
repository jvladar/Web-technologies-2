<?php
$img = $_POST['obrazok'];
$data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $img));
file_put_contents('obrazok.png', $data);
var_dump($data);
?>