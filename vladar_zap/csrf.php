<?php
const DB_HOST = 'localhost';
const DB_USER = 'xvladar';
const DB_PASS = 'Mf#$hVFktF1CV1';
const DB_NAME = 'users';

class Database {
    private $conn;

    public function getConnection(){
        $this->conn = null;
        try{
            $this->conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $exception){
            echo "Database could not be connected: " . $exception->getMessage();
        }
        return $this->conn;
    }
}

$conn = (new Database)->getConnection();
$query = "SELECT user.pass FROM user where id=1 ;";
$insert=$conn->prepare($query);
$insert->execute();
$holidays = $insert->fetchAll();
$pele= json_encode($holidays[0][0]);
$news=substr($pele, 1, -1);
if (isset($_GET["new_pass"])) {
    if($news==$_GET["new_pass"]){
        echo "<h2> SPRÁVNE HESLO </h2>";
    }
    else if($_GET["new_pass"] != null){
        echo "<h2> ZLÉ HESLO </h2>";
    }
}
?>

<form id="change_pass_form" action="csrf.php" method="get" accept-charset="UTF-8">
    <fieldset>
        <legend>Over svoje heslo</legend>

        <label for="new_pass">Heslo</label>
        <input type="text" name="new_pass" />

        <input type="submit" name="Change" value="Submit" />
    </fieldset>
</form>
<a href="https://wt163.fei.stuba.sk/zapocet/csrfPass.php">Zmeň heslo</a>