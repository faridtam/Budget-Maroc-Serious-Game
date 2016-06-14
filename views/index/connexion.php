<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
    <meta charset="utf-8">
</head>
<body style="background: #F1F1F1;">
<?php
session_start();

require_once ('libraries/Google/autoload.php');

$client_id = '305993253701-0cfjggd1jsp7u2sqoririiiet0j89j1a.apps.googleusercontent.com'; 
$client_secret = 'DUVlHNEhJ2CQW1L9EabweTWp';
$redirect_uri = 'http://localhost/projet/views/index/connexion.php';

//database
$db_username = "root"; //Database Username
$db_password = ""; //Database Password
$host_name = "localhost"; //Mysql Hostname
$db_name = 'budget'; //Database Name

//incase of logout request, just unset the session var
if (isset($_GET['logout'])) {
  unset($_SESSION['access_token']);
}

$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->addScope("email");
$client->addScope("profile");

$service = new Google_Service_Oauth2($client);

if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
  exit;
}

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
} else {
  $authUrl = $client->createAuthUrl();
}

if (isset($authUrl)){ 
	//show login url
	echo '<div align="center" style="margin: 80px;font-size: x-large;">';
	echo '<h3>Connectez-vous avec votre compte Google</h3>';
	echo '<a class="login" href="' . $authUrl . '"><img src="../views/index/login.png" /></a>';
	echo '</div>';
	
}else {
    
    $user = $service->userinfo->get(); //get user info 
    
    // connect to database
    $mysqli = new mysqli($host_name, $db_username, $db_password, $db_name);
    if ($mysqli->connect_error) {
        die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
    }
    
    //check if user exist in database using COUNT
    $result = $mysqli->query("SELECT COUNT(id_joueur) as usercount FROM joueur WHERE email=$user->email");
    $user_count = $result->fetch_object()->usercount; //will return 0 if user doesn't exist
    
    
    if($user_count) //if user already exist change greeting text to "Welcome Back"
    {
        header("Location:http://localhost/Projet_Inter/index/");
    }
    else //else greeting text "Thanks for registering"
    { 
        echo 'Hi '.$user->name.', Thanks for Registering! [<a href="'.$redirect_uri.'?logout=1">Log Out</a>]';
        $statement = $mysqli->prepare("INSERT INTO google_users (google_id, google_name, google_email, google_link, google_picture_link) VALUES (?,?,?,?,?)");
        $statement->bind_param('issss', $user->id,  $user->name, $user->email, $user->link, $user->picture);
        $statement->execute();
        echo $mysqli->error;
    }
    
    //print user details
    echo '<pre>';
    print_r($user);
    echo '</pre>';
}
?>
</body>
</html>
