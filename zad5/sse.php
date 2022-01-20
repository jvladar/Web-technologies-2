<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');


$graph_params = json_decode(file_get_contents('graph_params.json'));
$data = array();
session_start();
$index = $_SESSION['index'];
if ($graph_params->sin) {
    $sin = sin($graph_params->a * $index) * sin($graph_params->a * $index);
    $data['sin'] = $sin;
}
if ($graph_params->cos) {
    $cos = cos($graph_params->a * $index) * cos($graph_params->a * $index);
    $data['cos'] = $cos;
}
if ($graph_params->sin_cos) {
    $sin_cos = sin($graph_params->a * $index) * cos($graph_params->a * $index);
    $data['sin_cos'] = $sin_cos;
}
if ($graph_params->a) {
    $data['a'] = $graph_params->a;
}

$_SESSION['index'] = ++$index;

$data = json_encode($data);

echo "data: {$data}\n\n";
flush();
