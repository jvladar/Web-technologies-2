<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Zadanie 2</title>

</head>
<body>

<nav>
    <a href="index.php">Všetci</a>
    <a href="top.php">TOP 10</a>
    <a href="golden.php">Zlatí</a>
    <div class="animation start-about"></div>
</nav>

<div class="container">
    <div class="row">


        <?php
        include('my_config.php');
        $sql = "SELECT       person_id,osoby.name,osoby.surname,
                COUNT(person_id) AS `value_occurrence` 
                FROM    umiestnenia
                LEFT JOIN osoby ON umiestnenia.person_id = osoby.id 
                LEFT JOIN oh ON umiestnenia.oh_id = oh.id
                GROUP BY person_id
                ORDER BY `value_occurrence` DESC
                LIMIT    10;
                ";
        $result = $conn->query($sql);
        ?>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>Meno</th>
                <th>Počet medailí</th>
            </tr>

            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['name']; ?> <?php echo $row['surname']; ?></td>
                    <td><?php echo $row['value_occurrence']; ?></td>
                </tr>
            <?php }?>
            </tbody>
        </table>


    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0"
        crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="script.js"></script>
</body>
</html>