<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once './config/database.php';

$xml = simplexml_load_file('assets/meniny.xml');

$countries = [
    'SK' => ['title' => 'Slovensko'],
    // 'SKd' => ['title' => 'Slovensko'],
    'CZ' => ['title' => 'Česká republika'],
    'AT' => ['title' => 'Rakúsko'],
    'HU' => ['title' => 'Maďarsko'],
    'PL' => ['title' => 'Poľsko'],
];

$conn = (new Database())->getConnection();
?>

<!doctype html>
<html lang="end">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>

<body>
    <pre>
        <?php
        $day = '';
        $month = '';
        $stmtDays = $conn->prepare('INSERT IGNORE INTO days (day, month) VALUES (:day, :month)');
        $stmtDays->bindParam(':day', $day, PDO::PARAM_INT);
        $stmtDays->bindParam(':month', $month, PDO::PARAM_INT);

        $code = '';
        $title = '';
        $stmtCountries = $conn->prepare('INSERT IGNORE INTO countries (code, title) VALUES (:code, :title)');

        $stmtCountries->bindParam(':code', $code);
        $stmtCountries->bindParam(':title', $title);

        $day_id = '';
        $country_id = '';
        $value = '';
        $type = '';
        $stmtRecords = $conn->prepare('INSERT IGNORE INTO records (day_id, country_id, value, type) VALUES (:day_id, :country_id, :value, :type)');

        $stmtRecords->bindParam(':day_id', $day_id);
        $stmtRecords->bindParam(':country_id', $country_id);
        $stmtRecords->bindParam(':value', $value);
        $stmtRecords->bindParam(':type', $type);

        foreach ($xml->children() as $row) {
            $day = substr($row->den, 2, 2);
            $month = substr($row->den, 0, 2);

            $stmtDays->execute();

            $d = $conn->prepare('SELECT id FROM days WHERE day = ' . $day . ' AND month = ' . $month);
            $d->execute();
            $day_id = $d->fetchColumn();

            foreach (array_keys(((array) $row)) as $item) {
                if (array_key_exists($item, $countries)) {
                    if (!isset($countries[$item]['id'])) {
                        $code = $item;
                        $title = $countries[$item]['title'];
                        $stmtCountries->execute();

                        $c = $conn->prepare("SELECT id FROM countries WHERE code = '$code'");
                        $c->execute();
                        $country_id = $c->fetchColumn();
                        $countries[$item]['id'] = $country_id;
                    }

                    $type = 'name';
                    $country_id =  $countries[$item]['id'];
                    foreach (explode(',', $row->$item) as $name) {
                        $value = trim($name);
                        $stmtRecords->execute();
                    }
                }
            }
            if ($row->SKd) {
                foreach (explode(',', $row->SKd) as $name) {
                    $value = trim($name);
                    $stmtRecords->execute();
                }
            }
        }
        ?>
</pre>
</body>
<html>