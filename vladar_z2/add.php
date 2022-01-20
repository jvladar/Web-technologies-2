<!DOCTYPE html>
<html lang="sk">

<head>
    <link rel="shortcut icon" href="#">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
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
            <form class="mt-5" action="my_config.php" method="post">
                <button class="btn btn-primary btn-lg btn-block" type="submit" name="back">Späť</button>
                <table class="mt-5 table table-striped">
                    <tbody>

                        <?php
                        session_start();
                        include('my_config.php');
                        $stack = array();
                        $id = $_SESSION['id'];

                        $sql1 = "SELECT * FROM osoby WHERE osoby.id = '$id'";
                        $result1 = $conn->query($sql1);

                        $sql2 = "SELECT oh.city, oh.country, oh.year, oh.id FROM oh;";
                        $result2 = $conn->query($sql2);

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
                        <div class="input-group m-8">
                            <input type="hidden" value="<?php echo $id; ?>" class="form-control" name="person_id">
                        </div>
                        <div class="input-group m-8">
                            <label class="m-2" for="oh_id">Olympiada</label>
                            <select  name="oh_id" id="oh_id" value="<?php echo $id; ?>">
                                <?php while ($row2 = $result2->fetch_assoc()) {
                                    $string = $row2["city"] . " - " . $row2["country"] . ", " . $row2["year"];
                                    $oh_id = $row2["id"];
                                    echo "<option value='$oh_id'>$string</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="input-group m-8">
                            <label class="m-2" for="placing">Umiestnenie</label>
                            <input type="number" class="form-control" id="placing" name="placing">
                        </div>
                        <div class="input-group m-8">
                            <label class="m-2" for="discipline">Disciplína</label>
                            <input type="text" class="form-control" id="discipline" name="discipline">
                        </div>
                        <div class="container">
                            <div class="center">
                                <button type="submit" class="btn btn-primary btn-lg btn-block" name="newResult">Potvrdiť</button>
                            </div>
                        </div>

            
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="script.js"></script>
</body>

</html>