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
    <form class = "mt-5" action="upload.php" method="post" enctype="multipart/form-data">
    <table class="mt-5 table table-striped">
        <tbody>
        <?php
        session_start();
        include('my_config.php');

        $id = $_SESSION['user_id'];
        $sql = "SELECT * FROM osoby WHERE id = '$id'";
        $result = $conn->query($sql);
        $result1 = $conn->query($sql);
        $row = $result->fetch_assoc();
        ?>
        <?php while ($row1 = $result1->fetch_assoc()) { ?>
            <span class="sportsman">
                <?php echo $row1['surname']; ?> <?php echo $row1['name']; ?>,
                <?php echo $row1['birth_day']; ?>, <?php echo $row1['birth_place']; ?>,
                <?php echo $row1['birth_country']; ?>
            </span>
        <?php  } ?>
        
        </tbody>
        </table>
        <a href="my_config.php?add=<?php echo $row['id']; ?>" class="edit_btnn">Pridať nový výsledok</a>
            <div class="input-group m-8">
                <label class="m-2" for="name">Meno</label>
                <input type="text" class="form-control" name="name" id="name" value="<?php echo $row['name'];?>">
            </div>
            <div class="input-group m-8">
                <label class="m-2" for="surname">Priezvisko</label>
                <input type="text" class="form-control" name="surname" id="surname" value="<?php echo $row['surname'];?>">
            </div>
            <div class="input-group m-8">
                <label class="m-2" for="death_day">Dátum úmrtia</label>
                <input type="text" class="form-control" name="death_day" id="death_day" value="<?php echo $row['death_day'];?>">
            </div>
            <div class="input-group m-8">
                <label class="m-2" for="death_place">Miesto úmrtia</label>
                <input type="text" class="form-control" name="death_place" id="death_place" value="<?php echo $row['death_place'];?>">
            </div>
            <div class="input-group m-8">
                <label class="m-2" for="death_country">Krajina úmrtia</label>
                <input type="text" class="form-control" name="death_country" id="death_country" value="<?php echo $row['death_country'];?>">
            </div>
            <div class="container">
                <div class="center">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" name="updateUser">Potvrdiť</button>
                </div>
            </div>
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