<?
session_start();
include_once('db.inc');
$mysql = new mysqli($host, $username, $password, $database);
$mysql->query("UPDATE notificationsViewed SET lastViewed = NOW() WHERE username = '".$_SESSION['logged_user']."'");
?>