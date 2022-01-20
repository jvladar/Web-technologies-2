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
        <?php
        include('my_config.php');

        $sql = "SELECT osoby.id AS personal_id, osoby.name, osoby.surname, umiestnenia.*, oh.* FROM osoby 
        LEFT JOIN umiestnenia ON umiestnenia.person_id = osoby.id 
        LEFT JOIN oh ON umiestnenia.oh_id = oh.id ORDER BY umiestnenia.id";

        $result = $conn->query($sql);
        ?>

        <table id="table_data" class="table table-striped">
            <thead>
            <tr>
                <th>Meno</th>
                <th>Krajina</th>
                <th>Rok</th>
                <th>Typ</th>
                <th>Disciplína</th>
                <th>Upraviť</th>
                <th>Vymazať</th>
            </tr>

            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()) {
                //if($row['placing'] < 4){
                ?>
                <tr>
                    <td><a href="my_config.php?user=<?php echo $row['personal_id']; ?>"><?php echo $row['name'];?> <?php echo $row['surname']; ?></a></td>
                    <td><?php echo $row['city']; ?>, <?php echo $row['country']; ?></td>
                    <td><?php echo $row['year']; ?></td>
                    <td><?php echo $row['type']; ?></td>
                    <td><?php echo $row['discipline']; ?></td>
                    <td><a href="my_config.php?edit=<?php echo $row['personal_id']; ?>" class="edit_btn">Edit</a></td>
                    <td>
                        <a href="my_config.php?del=<?php echo $row['personal_id']; ?>" class="del_btn">Delete</a>
                    </td>
                </tr>
            <?php  }

            ?>
            </tbody>
        </table>

        <form action="upload.php" method="post" enctype="multipart/form-data">
            <div class="input-group m-8">
                <label class="m-2" for="name">Meno</label>
                <input type="text" class="form-control" name="name" id="name">
            </div>
            <div class="input-group m-8">
                <label class="m-2" for="surname">Priezvisko</label>
                <input type="text" class="form-control" name="surname" id="surname">
            </div>
            <div class="input-group m-8">
                <label class="m-2" for="birth_day">Dátum narodenia</label>
                <input type="text" class="form-control" name="birth_day" id="birth_day">
            </div>
            <div class="input-group m-8">
                <label class="m-2" for="birth_place">Miesto narodenia</label>
                <input type="text" class="form-control" name="birth_place" id="birth_place">
            </div>
            <div class="input-group m-8">
                <label class="m-2" for="birth_country">Krajina</label>
                <input type="text" class="form-control" name="birth_country" id="birth_country">
            </div>
            <div class="container">
                <div class="center">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" name="newUser">Pridať športovca</button>
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