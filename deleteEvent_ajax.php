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

if(!hash_equals($_SESSION['token'], $_POST['token'])){
      echo json_encode(array(
            "success" => false,
            "message" => "Request Forgery Detected!"
        ));
        exit();
    }

 $event_id = htmlentities($_POST['event_id']);


 $stmt = $mysqli->prepare("DELETE FROM events WHERE event_id = ?");
    $stmt->bind_param('i', $event_id);
    $stmt->execute();

if(!$stmt){
  echo json_encode(array(
    "success" => false,
    "message" => "Failed to delete event!"
));
exit();
}

echo json_encode(array(
  "success" => true,
  "message" => "Event deleted successfully!"
));