<?php
require 'database.php';
if(!empty($_REQUEST['eventid'])){
$events = $mysqli->query("SELECT * FROM events WHERE event_id =".$_REQUEST['eventid']);
$row = $events->fetch_object();
echo json_encode(array(
  "success" => true,
  "event_id" => $row->event_id,
  "event_name" => $row->event_name,
  "event_type" => $row->event_type,
  "event_date" => $row->event_date,
  "start_time" => $row->start_time,
  "end_time" => $row->end_time));
}
else {
  echo json_encode(array(
    "success" => false,
    "message" => "Event error!"
));
exit();
}