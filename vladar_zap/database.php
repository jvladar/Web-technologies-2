<?php

const DB_HOST = 'localhost';
const DB_USER = 'xvladar';
const DB_PASS = 'Mf#$hVFktF1CV1';
const DB_NAME = 'countries';

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

//$query = "INSERT INTO country(name, code) VALUES (" . "'" .$_GET["name"] . "','" . $_GET["code"] . "');";

$query = "INSERT INTO country(name, code) VALUES (:name,:code);";

$insert=$conn->prepare($query);

$insert->bindParam(":name",$_GET["name"]);
$insert->bindParam(":code",$_GET["code"]);


$insert->execute();
var_dump($query);