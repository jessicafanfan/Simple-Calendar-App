<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$db_servername = "ec2-52-15-202-27.us-east-2.compute.amazonaws.com";
$db_username = "wustl_inst";
$db_pwd = "wustl_pass";
$db_name = "calendar_loginsystem";

$mysqli = new mysqli($db_servername, $db_username, $db_pwd, $db_name);

if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
?>