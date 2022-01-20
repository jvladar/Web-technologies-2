<?php
require_once './get_data.php';
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <title>Zadanie 4</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.0.1/chart.min.js" integrity="sha512-2uu1jrAmW1A+SMwih5DAPqzFS2PI+OPw79OVLS4NJ6jGHQ/GmIVDDlWwz4KLO8DnoUmYdU8hTtFcp8je6zxbCg==" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./style.css">

</head>
<body>
    <!-- The Modal -->
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content" id="pele">
            <span class="close">&times;</span>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <table id="table_data" class="table table-striped">
                <thead>
                    <tr>
                        <th>Meno študenta</th>
                        <?php
                        require_once './config/database.php';

                        $conn = (new Database())->getConnection();
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $query = 'SELECT * FROM lecture';
                        $stmt = $conn->prepare($query);
                        $stmt->execute();
                        $lectures = $stmt->fetchAll();
                        foreach ($lectures as $item) {
                            echo '<th>' . substr($item['name'], 0, 8) . '</th>';
                        }
                        ?>
                        <th>Celkový počet účastí</th>
                        <th>Celkový počet minút</th>
                    </tr>

                </thead>
                <tbody>
                    <?php

                    try {
                        $query = 'SELECT DISTINCT name FROM user_action';
                        $stmt2 = $conn->prepare($query);
                        $stmt2->execute();
                        $students = $stmt2->fetchAll();

                        $student_query = 'SELECT action, timestamp FROM user_action WHERE lecture_id = :lecture_id AND name = :name';

                        foreach ($students as $student) {
                            $count = 0;
                            $total_time = 0;
                            echo '<tr>';
                            echo '<td>' . $student['name'] . '</td>';
                            foreach ($lectures as $lecture) {
                                $stmt3 = $conn->prepare($student_query);
                                $stmt3->bindParam(':name', $student['name']);
                                $stmt3->bindParam(':lecture_id', $lecture['id'], PDO::PARAM_INT);
                                $stmt3->execute();
                                $users_actions = $stmt3->fetchAll();

                                $joined = array();
                                $left = array();
                                $p = array();
                                foreach ($users_actions as $action) {
                                    $time = substr($action['timestamp'], 11);
                                    if (strcmp($action['action'], 'JOINED') == 0) {
                                        array_push($joined, $time);
                                        array_push($p, $time." JOINED <br>");
                                    } else {
                                        array_push($left, $time);
                                        array_push($p, $time." LEFT <br>");
                                    }
                                }
                                $total_joined = 0;
                                $total_left = 0;
                                $lecture_time = 0;

                                for ($i = 0; $i < count($left); $i++) {
                                    $total_joined += strtotime($joined[$i]);
                                    $total_left += strtotime($left[$i]);
                                }
                                $lecture_time = $total_left - $total_joined;
                                echo '<script>';
                                echo 'var x = ' . json_encode($p) . ';';
                                echo '</script>';

                                if (count($left) == 0) {
                                    if (count($joined) != 0) {
                                        $count++;
                                    }
                                    echo '<td style = "background-color: #ff8080">' . '0' . '</td>';
                                } else if (count($joined) != count($left)) {
                                    echo '<td style = "background-color: #ff8080"><a href="#" onclick="openModal(x)">' . round($lecture_time / 60) . '</a></td>';
                                    $count++;
                                } else {
                                    echo '<td><a href="#" onclick="openModal(x)">' . round($lecture_time / 60) . '</a></td>';
                                    $count++;
                                }

                                $total_time += $lecture_time;
                            }
                            echo '<td>' . $count . '</td>';
                            echo '<td>' . round($total_time / 60) . '</td>';
                        }
                    } catch (PDOException $e) {
                        return json_encode($e);
                    } catch (Exception $e) {
                        return json_encode("Unknown error");
                    }
                    ?>
                </tbody>
            </table>

            <div class="container">
                <canvas id="myChart"></canvas>
            </div>

            <script>
                <?php

                $lecture_users_count_query = 'SELECT count(DISTINCT name) AS count FROM user_action WHERE lecture_id = :lecture_id';
                $stmt4 = $conn->prepare($lecture_users_count_query);
                $lectures_attandance = array();
                $lectures_names = array();
                foreach ($lectures as $lct) {
                    $stmt4->bindParam(':lecture_id', $lct['id']);
                    $stmt4->execute();
                    $lecture_users_count = $stmt4->fetch();
                    array_push($lectures_attandance, $lecture_users_count['count']);
                    array_push($lectures_names, substr($lct['name'], 0, 8));
                }

                ?>
                var data = <?php echo json_encode($lectures_attandance); ?>;
                var lectures_names = <?php echo json_encode($lectures_names); ?>;

                var ctx = document.getElementById('myChart');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: lectures_names,
                        datasets: [{
                            label: 'count of attendees',
                            data: data,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.5)',
                                'rgba(54, 162, 235, 0.5)',
                                'rgba(255, 206, 86, 0.5)',
                                'rgba(75, 192, 192, 0.5)',
                                'rgba(153, 102, 255, 0.5)',
                                'rgba(255, 159, 64, 0.5)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>


        </div>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.css">
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
    <script src="./js/script.js"></script>
</body>
</html>