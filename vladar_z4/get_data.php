<?php
require_once './config/database.php';

$conn = (new Database())->getConnection();
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$lecture_query = 'INSERT INTO lecture (name, timestamp) VALUES (:name, :timestamp)';
$stmt = $conn->prepare($lecture_query);

$all_files_curl = curl_init('https://api.github.com/repos/apps4webte/curldata2021/contents');

curl_setopt($all_files_curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($all_files_curl, CURLOPT_USERAGENT, 'php');

$all_files_from_curl = curl_exec($all_files_curl);
$all_files = json_decode($all_files_from_curl, true);

foreach ($all_files as $file) {
    $lecture_name = $file['name'];
    $lecture_timestamp = substr($lecture_name, 0, 8);
    $download_url = $file['download_url'];

    try {
        $stmt->bindParam(':name', $lecture_name);
        $stmt->bindParam(':timestamp', $lecture_timestamp);
        $stmt->execute();

        $ch = curl_init($download_url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($ch);
        $output = mb_convert_encoding($output, 'utf-8', 'utf-16le');
        var_dump($output);
        $lines = explode(PHP_EOL, $output);

        $stmt2 = $conn->prepare('INSERT INTO user_action (lecture_id, name, action, timestamp) 
                                VALUES (:lecture_id, :name, :action, :timestamp)');

        $stmt2->bindParam(':name', $name);
        $stmt2->bindParam(':action', $action);
        $stmt2->bindParam(':timestamp', $timestamp);
        $lecture_id = $conn->lastInsertId();
        $stmt2->bindParam(':lecture_id', $lecture_id, PDO::PARAM_INT);

        array_shift($lines);
        array_pop($lines);

        foreach ($lines as $index => $line) {
            $lineArray = str_getcsv($line, "\t");
            $name = $lineArray[0];
            $action = $lineArray[1];
            $ts = str_replace(' AM', '', $lineArray[2]);
            $timestamp = date('Y-m-d H:i:s', date_create_from_format('d/m/Y, H:i:s', $ts)->getTimestamp());
            $stmt2->execute();
        }
    } catch (PDOException $e) {
        //var_dump('PDO' . $e);
    } catch (Exception $e) {
        var_dump('Exception' . $e);
    }
}