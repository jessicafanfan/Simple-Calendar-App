<?php
header("Content-Type: application/json"); // set the MIME Type to application/json
ini_set("session.cookie_httponly", 1);
session_start();
//Because you are posting the data via fetch(), php has to retrieve it elsewhere.
$json_str = file_get_contents('php://input');
//This will store the data into an associative array
$json_obj = json_decode($json_str, true);

$username = $json_obj['username'];
$password = $json_obj['password'];
//$username = $_POST['username'];
//$password = $_POST['password'];



require 'database.php';

if( !preg_match('/^[\w_\.\-]+$/', $username) ){
    echo json_encode(array(
        "success" => false,
        "message" => "Username is invalid!"
    ));
    exit();
}

$sql = "SELECT * FROM users WHERE user_uid ='$username'";
$result = mysqli_query($mysqli, $sql);
$resultCheck = mysqli_num_rows($result);
if ($resultCheck < 1){
    echo json_encode(array(
        "success" => false,
        "message" => "Username or Password is incorrect!"
    ));
    exit();
}
else {
    if ($row = mysqli_fetch_assoc($result)) {
    //dehash pwd
    $pwdCheck = password_verify($password, $row['user_pwd']);
    if ($pwdCheck == false){
        echo json_encode(array(
            "success" => false,
            "message" => "Username or Password is incorrect!"
        ));
        exit();
    }
    elseif ($pwdCheck == true) {
        //login user start session
        
        $_SESSION['u_id'] = $row['user_id'];
        $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
        
       // $user = $mysqli->query("SELECT * FROM users WHERE user_uid='" . $mysqli->real_escape_string($_POST['username']) . "'");
        $_SESSION['useragent'] = $_SERVER['HTTP_USER_AGENT'];
        $_SESSION['user'] = $username;

        echo json_encode(array(
        "success" => true,
        "token" => $_SESSION['token'],
        "user" => $_SESSION['user'],
        "message" => "Log in successful!"
    ));
        exit();
    }
    }    
}

exit();


?>