<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
    <title>Registration system PHP and MySQL</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<body>

<div class="container">
    <div class="row align-items-center">


        <?php
        session_start();
        $id = $_SESSION['id'];
        $sql = "SELECT * FROM LOGING LEFT JOIN USERS ON USERS.id = LOGING.user_id WHERE LOGING.user_id = '$id' ";
        $result = $conn->query($sql);
        $sql4 = "SELECT * FROM USERS WHERE id = '$id'";
        $result4 = $conn->query($sql4);
        $row4 = $result4->fetch_assoc();
        ?>

        <h1 class="mt-5">Vitaj <?php echo $row4['login']; ?></h1>
        <h3 class="mt-5">Meno: <?php echo $row4['name']; ?></h3>
        <h3 class="mt-5">Priezvisko: <?php echo $row4['surname']; ?></h3>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>Meno</th>
                <th>Typ prihlásenia</th>
                <th>Čas prihlásenia</th>
            </tr>

            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()) {

                ?>
                <tr>

                    <td><?php echo $row['login']; ?></td>
                    <td><?php echo $row['type']; ?></td>
                    <td><?php echo $row['logdate']; ?></td>
                </tr>
            <?php  }?>
            </tbody>
        </table>

        <?php
        $sql1 = "SELECT COUNT(LOGING.type) AS classic FROM LOGING WHERE LOGING.type = 'classic'";
        $result1 = $conn->query($sql1);
        $sql2 = "SELECT COUNT(LOGING.type) AS ldap FROM LOGING WHERE LOGING.type = 'ldap'";
        $result2 = $conn->query($sql2);
        $sql3 = "SELECT COUNT(LOGING.type) AS google FROM LOGING WHERE LOGING.type = 'google'";
        $result3 = $conn->query($sql3);
        $row1 = $result1->fetch_assoc();
        $row2 = $result2->fetch_assoc();
        $row3 = $result3->fetch_assoc();
        ?>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>Typ prihlásenia</th>
                <th>Počet</th>


            </tr>

            </thead>
            <tbody>
                <tr>
                    <td>Classic</td>
                    <td><?php echo $row1['classic']; ?></td>
                </tr>
                <tr>
                    <td>Ldap</td>
                    <td><?php echo $row2['ldap']; ?></td>
                </tr>
                <tr>
                    <td>Google</td>
                    <td><?php echo $row3['google']; ?></td>
                </tr>
            </tbody>
        </table>
        </table>
        <a class="btn btn-danger "  href="./logout.php ">Odhlásiť sa</a>
    </div>
</div>

</body>
</html>