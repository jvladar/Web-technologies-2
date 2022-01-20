<!DOCTYPE html>
<html lang="sk">
<head>
    <link rel="shortcut icon" href="#">
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
    <div class="animation start-home"></div>
</nav>

<div class="container">
    <div class="row">
        <form class = "mt-5" action="my_config.php" method="post">
            <button class="btn btn-primary btn-lg btn-block" type="submit" name="back" >Späť</button>
            <table class="mt-5 table table-striped">
                <thead>
                <tr>
                    <th>Krajina</th>
                    <th>Rok</th>
                    <th>Typ</th>
                    <th>Disciplína</th>
                    <th>Umiestnenie</th>
                </tr>

                </thead>
                <tbody>


                <?php
                session_start();
                include('my_config.php');
                $id = $_SESSION['id'];
                $sql = "SELECT * FROM umiestnenia 
                        INNER JOIN osoby ON umiestnenia.person_id = osoby.id AND osoby.id = '$id'
                        LEFT JOIN oh ON umiestnenia.oh_id = oh.id ORDER BY umiestnenia.id";
                $result = $conn->query($sql);

                $sql1 = "SELECT * FROM osoby WHERE osoby.id = '$id'";
                $result1 = $conn->query($sql1);

                ?>
                <?php while ($row1 = $result1->fetch_assoc())  {?>
                    <a href="my_config.php?add=<?php echo $row1['id']; ?>" class="edit_btnn">Pridať nový výsledok</a>
                    <span class="sportsman">
                    <?php echo $row1['surname'];?> <?php echo $row1['name']; ?>,
                    <?php echo $row1['birth_day']; ?>, <?php echo $row1['birth_place']; ?>, 
                    <?php echo $row1['birth_country']; ?>
                    </span>

                <?php  }?>

                <?php while ($row = $result->fetch_assoc())  {?>

                    <tr>
                        <td><?php echo $row['city']; ?>, <?php echo $row['country']; ?></td>
                        <td><?php echo $row['year']; ?></td>
                        <td><?php echo $row['type']; ?></td>
                        <td><?php echo $row['discipline']; ?></td>
                        <td><?php echo $row['placing']; ?></td>
                    </tr>

                    
                <?php  }?>
                
                </tbody>
            </table>
        </form>


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