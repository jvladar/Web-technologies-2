<?php
header('Content-type: application/json');
$json = file_get_contents('php://input');
?>

<?php
$data = json_decode($json);
var_dump($data);

$graph_params_file = file_get_contents('graph_params.json');
$graph_params = json_decode($graph_params_file, true);

if (isset($data->a) && $data->a > 0) {
    $graph_params['a'] = $data->a;
}
if (isset($data->sin)) {
    $graph_params['sin'] = $data->sin;
}
if (isset($data->cos)) {
    $graph_params['cos'] = $data->cos;
}
if (isset($data->sin_cos)) {
    $graph_params['sin_cos'] = $data->sin_cos;
}

file_put_contents('graph_params.json', json_encode($graph_params));