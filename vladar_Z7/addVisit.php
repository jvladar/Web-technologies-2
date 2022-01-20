<?php
require_once ('database.php');

header('Content-type: application/json');
$json = file_get_contents('php://input');
$data = json_decode($json);

$conn = (new Database())->getConnection();
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$lat = $data->lat;
$lng = $data->lng;
$ip = $data->ip_adress;
$country = $data->country;
$city = $data->city;
$type = $data->type;

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ipp = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ipp = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ipp = $_SERVER['REMOTE_ADDR'];
}

$ipInfo = file_get_contents('http://ip-api.com/json/' . $ipp);
$ipInfo = json_decode($ipInfo);
$timezone = $ipInfo->timezone;
date_default_timezone_set($timezone);
echo date_default_timezone_get();
$date = date("Y-m-d H:i:s");

$query2 = "SELECT MAX(visites.local_time) AS 'ip' FROM visites WHERE ip_adress = :ip_adress GROUP BY visites.ip_adress ";

$stmt2 = $conn->prepare($query2);
$stmt2->bindParam(':ip_adress', $ip);
$stmt2->execute();
$last_visit = $stmt2->fetch();

$currentTime = time();
$time = strtotime($last_visit['ip']);


if(($currentTime-$time) >= 86400) {
    $query = "INSERT INTO visites (ip_adress,country,local_time,city,type,latitude,longitude) VALUES (:ip_adress,:country,:date,:city,:type,:latitude,:longitude ) ";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':ip_adress', $ip);
    $stmt->bindParam(':country', $country);
    $stmt->bindParam(':city', $city);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':type', $type);
    $stmt->bindParam(':latitude', $lat);
    $stmt->bindParam(':longitude', $lng);

    $stmt->execute();
}

echo (json_encode($data, JSON_UNESCAPED_UNICODE));



