<?php
header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json

//Because you are posting the data via fetch(), php has to retrieve it elsewhere.
$json_str = file_get_contents('php://input');
//This will store the data into an associative array
$json_obj = json_decode($json_str, true);


require 'database.php';
ini_set("session.cookie_httponly", 1);
session_start();
$previous_ua = @$_SESSION['useragent'];
$current_ua = $_SERVER['HTTP_USER_AGENT'];

if(isset($_SESSION['useragent']) && $previous_ua !== $current_ua){
	die("Session hijack detected");
}else{
	$_SESSION['useragent'] = $current_ua;
}


error_reporting(E_ALL);
ini_set("display_errors", "On");
    //error handlers
    
    //check for empty fields
    $name = $json_obj['name'];
    $user = $json_obj['event_username'];
    $event_type = $json_obj['event_type'];
    $event_date = $json_obj['event_date'];
    $start_time = $json_obj['start_time'];
    $end_time = $json_obj['end_time'];
    $event_id = $json_obj['event_id'];
    $group_event_username = $json_obj['group_event_username'];

    if(!hash_equals($_SESSION['token'], $json_obj['token'])){
        echo json_encode(array(
              "success" => false,
              "message" => "Request Forgery Detected!",
              "stoken" => $_SESSION['token'],
              "jtoken" => $json_obj['token']
          ));
          exit();
      }
      
    if (empty($json_obj['name']) || empty($json_obj['event_type']) || empty($json_obj['event_date']) ||  empty($json_obj['start_time'])  || empty($json_obj['end_time'])) {
        echo json_encode(array(
            "success" => false,
            "message" => "One or more fields are empty!"
        ));
        exit();
    }
    else{
        //update event into database
        $stmt = $mysqli->prepare("UPDATE events SET event_name=?, event_uid=?, event_type=?, event_date=?, start_time=?, end_time=? WHERE event_id=?");
        $stmt->bind_param('ssssssi', $name,$_SESSION['u_id'], $event_type, $event_date, $start_time, $end_time, $event_id);
        if(!$stmt->execute()){
                 
            echo json_encode(array(
                "success" => false,
                "message" => "Unable to save your changes!"
            ));
            $stmt->close();
            exit();
        }
        else {
            $stmt->close();
            if($group_event_username!='') {
            //check if username taken
            $sql = "SELECT * FROM users WHERE user_uid='" . $mysqli->real_escape_string($group_event_username) . "'";
            $result = mysqli_query($mysqli, $sql);
            $resultCheck = mysqli_num_rows($result);
            
              if ($resultCheck > 0) {
              
                 //echo "SELECT * FROM users where user_uid=".$group_event_username;
                 $sharedUser = $mysqli->query("SELECT * FROM users where user_uid='".$group_event_username."'");
  
                 $rows = [];
                 
                  while($row = $sharedUser->fetch_object()){
                      $sharedUid = $row->user_id;
                      $sharename = "Shared by ". $_SESSION['user'].": ".$name;
                      $sql = "INSERT INTO events (event_name, event_uid, event_type, event_date, start_time, end_time) VALUES ('" . $sharename . "','" . $sharedUid. "','" . $event_type . "', '" . $event_date . "','" . $start_time . "','" . $end_time . "');";
                      mysqli_query($mysqli, $sql);
                  }
                
              echo json_encode(array(
                  "success" => true,
                  "message" => "Changes saved successfully!"
              ));
              exit();
            }
            else{
              echo json_encode(array(
                    "success" => false,
                    "message" => "Username doesnt exist!"
                ));
                exit();
            }
          }
          else{
            echo json_encode(array(
                  "success" => true,
                  "message" => "Changes saved successfully!"
              ));
              exit();
          }
        }
    
    }

    ?>