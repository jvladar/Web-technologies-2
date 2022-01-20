<?php
session_start();
define('MYDIR','../');
require_once(MYDIR."vendor/autoload.php");

$redirect_uri = 'https://wt163.fei.stuba.sk/cv3/oauth2/';

$client = new Google_Client();
$client->setAuthConfig('../configs/credentials.json');
$client->setRedirectUri($redirect_uri);
$client->addScope("email");
$client->addScope("profile");
      
$service = new Google_Service_Oauth2($client);
			
if(isset($_GET['code'])){

  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  $client->setAccessToken($token);
  $_SESSION['upload_token'] = $token;

  // redirect back to the example
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}

// set the access token as part of the client
if (!empty($_SESSION['upload_token'])) {
  $client->setAccessToken($_SESSION['upload_token']);
  if ($client->isAccessTokenExpired()) {
    unset($_SESSION['upload_token']);
  }
} else {
  $authUrl = $client->createAuthUrl();
}

if ($client->getAccessToken()) {
  $servername = "localhost";
  $username = "xvladar";
  $password = 'Mf#$hVFktF1CV1';
  $dbname = "logindb";

  session_start();
  $UserProfile = $service->userinfo->get();
  $_SESSION['userprofile'] = $UserProfile;
  include('../server.php');

// Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql22 = "INSERT INTO LOGING (login,type,logdate) VALUES ('{$row['id']}','google','$date')";
    $result22 = $conn->query($sql22);

    $sql = "SELECT id FROM USERS WHERE USERS.login = '{$UserProfile['id']}'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $date = date('Y-m-d_H-i-s', time());
    $sql3 = "INSERT INTO LOGING (user_id,type,logdate) VALUES ('{$row['id']}','google','$date')";
    $result3 = $conn->query($sql3);


    if(!empty($UserProfile)){
        $output = '<h1>Profile Details </h1>';
        $output .= '<img src="'.$UserProfile['picture'].'">';
        $output .= '<br/>Google ID : ' . $UserProfile['id'];
        $output .= '<br/>Name : ' . $UserProfile['given_name'].' '.$UserProfile['family_name'];
        $output .= '<br/>Email : ' . $UserProfile['email'];
        $output .= '<br/>Locale : ' . $UserProfile['locale'];
        $output .= '<br/><br/>Logout from <a href="logout.php">Google</a>'; 
    }else{
        $output = '<h3 style="color:red">Some problem occurred, please try again.</h3>';
    }   
  } else {
      $authUrl = $client->createAuthUrl();
      $output = '<a href="'.filter_var($authUrl, FILTER_SANITIZE_URL).'"><img src="images/glogin.png" alt=""/></a>';
  }
?>

<div><?php echo $output; ?></div>  
