<?php 
require_once("server.php");
$conn = new mysqli($servername, $username, $password, $dbname);

if($_SERVER["REQUEST_METHOD"]==$POST){
    var_dump($_POST);
    if(isset($_POST["email"])&&isset($_POST["psw"])&& isset($_POST["psw-repeat"])){
        if(strcmp($_POST["psw"],$_POST["psw-repeat"])==0){
            try{
                $stm = $conn->prepare("INSERT INTO user (login,email,password) VALUES (?,?)");
                $hash = password_hash($_POST["psw"],PASSWORD_DEFAULT);
                $stm->execute([$_POST["email"],$hash]);
                $_SESSION["username"]=$_POST["email"];
                header("Location: index.php");
            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }else{
            echo "hesla a nezhoduju";
        }
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Page</title>
    </head>
<body>
<form action="register.php" method="POST">
  <div class="container">
    <h1>Register</h1>
    <p>Please fill in this form to create an account.</p>
    <hr>

    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="email" id="email" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" id="psw" required>

    <label for="psw-repeat"><b>Repeat Password</b></label>
    <input type="password" placeholder="Repeat Password" name="psw-repeat" id="psw-repeat" required>
    <hr>

    <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>
    <button type="submit" class="registerbtn">Register</button>
  </div>

  <div class="container signin">
    <p>Already have an account? <a href="login.php">Sign in</a>.</p>
  </div>
</form>
</body>
</html>
