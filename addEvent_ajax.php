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

    if (empty(htmlentities($_POST['name'])) || empty(htmlentities($_POST['event_type'])) || empty(htmlentities($_POST['event_date'])) || empty(htmlentities($_POST['start_time']))  || empty(htmlentities($_POST['end_time']))) {
        echo json_encode(array(
            "success" => false,
            "message" => "One or more fields are empty!"
        ));
        exit();
    }
    else{
        //insert event into database
              $sql = "INSERT INTO events (event_name, event_uid, event_type, event_date, start_time, end_time) VALUES ('" . htmlentities($_POST['name']) . "','" . $_SESSION['u_id'] . "','" . htmlentities($_POST['event_type']) . "', '" . htmlentities($_POST['event_date']) . "','" . htmlentities($_POST['start_time']) . "','" . htmlentities($_POST['end_time']) . "');";
              mysqli_query($mysqli, $sql);
                
                echo json_encode(array(
                    "success" => true,
                    "message" => "Event added successfully!"
                ));
            exit;
    }
