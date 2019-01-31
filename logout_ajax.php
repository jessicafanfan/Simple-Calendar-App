<?php
    //echo ("got here");
    header("Content-Type: application/json");
    ini_set("session.cookie_httponly", 1);
    session_start();
    unset($_SESSION['user']);
    unset($_SESSION['u_id']);
    unset($_SESSION['token']);
    session_unset();
    session_destroy();
    echo json_encode(array(
  		"success" => true
      ));
      
    exit();
?>