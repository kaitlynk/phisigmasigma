<?php
session_start();
include_once('db.inc');
$mysql = new mysqli($host, $username, $password, $database);
$result = $mysql->query("SELECT type FROM notifications WHERE datetime > (SELECT lastViewed FROM notificationsViewed WHERE username ='".$_SESSION['logged_user']."') LIMIT 1");
$notification = $result->fetch_assoc();
$type = $notification['type'];
$response = "";
if($type == 'photo') {
	$response = "A new photo has been added.";
	$mysql->query("UPDATE notificationsViewed SET lastViewed = NOW() WHERE username ='".$_SESSION['logged_user']."'");
}
echo $response;
?>