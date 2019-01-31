<?php
ini_set("session.cookie_httponly", 1);
session_start();

require 'database.php';
if(isset($_SESSION['u_id'])){
$events = $mysqli->query("SELECT * FROM events where event_uid=".$_SESSION['u_id']);

$rows = [];

while($row = $events->fetch_object()) {

  $rows[] = $row;

}

echo json_encode($rows);
}
else {
  echo json_encode(array(
    "success" => false,
    "message" => "Something went wrong"
));
}