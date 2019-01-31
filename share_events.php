<?php
ini_set("session.cookie_httponly", 1);
session_start();

$previous_ua = @$_SESSION['useragent'];
$current_ua = $_SERVER['HTTP_USER_AGENT'];

if(isset($_SESSION['useragent']) && $previous_ua !== $current_ua){
	die("Session hijack detected");
}else{
	$_SESSION['useragent'] = $current_ua;
}
   

    require 'database.php';

      //error handlers
    //print_r($_POST);
    if (htmlentities(empty($_POST['name'])) || empty(htmlentities($_POST['event_type'])) || empty(htmlentities($_POST['event_date'])) || empty(htmlentities($_POST['start_time']))  || empty(htmlentities($_POST['end_time']))) {
        echo json_encode(array(
            "success" => false,
            "message" => "One or more fields are empty!"
        ));
        exit();
    }
    else{
         $name = "Shared by " + $_SESSION['user'] +": "+ htmlentities($_POST['name']);
        //insert event into database
              $sql = "INSERT INTO events (event_name, event_uid, event_type, event_date, start_time, end_time) VALUES ('" . $name . "','" . htmlentities($_POST['u_id']) . "','" . htmlentities($_POST['event_type']) . "', '" . htmlentities($_POST['event_date']) . "','" . htmlentities($_POST['start_time']) . "','" . $_POST['end_time'] . "');";
              mysqli_query($mysqli, $sql);
                
                echo json_encode(array(
                    "success" => true
                ));
            exit;
    }
