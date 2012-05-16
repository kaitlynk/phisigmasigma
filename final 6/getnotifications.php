<?
session_start();
if(!isset($_SESSION['logged_user']))
	return;
include_once('db.inc');
$mysql = new mysqli($host, $username, $password, $database);
$result = $mysql->query("SELECT type,actionid,datetime FROM notifications WHERE datetime > (SELECT lastRetrieved FROM notificationsViewed WHERE username ='".$_SESSION['logged_user']."') LIMIT 1");
$notification = $result->fetch_assoc();
$type = $notification['type'];
$response = "";
$phptime = strtotime( $notification['datetime'] );
$time = date( 'F d g:ia', $phptime );
if($type == 'photo') {
	$response = '{"notification": "A new <a href=\'photo.php?id='.$notification['actionid'].'\'>photo</a> has been added.", "date": "'.$time.'"}';
	$mysql->query("UPDATE notificationsViewed SET lastRetrieved = NOW() WHERE username ='".$_SESSION['logged_user']."'");
}
elseif($type == 'album') {
	$response = '{"notification": "A new <a href=\'album.php?id='.$notification['actionid'].'\'>album</a> has been added.", "date": "'.$time.'"}';
	$mysql->query("UPDATE notificationsViewed SET lastRetrieved = NOW() WHERE username ='".$_SESSION['logged_user']."'");
}
elseif($type == 'blog') {
	$response = '{"notification": "A new <a href=\'event.php?id='.$notification['actionid'].'\'>blogpost</a> has been added.", "date": "'.$time.'"}';
	$mysql->query("UPDATE notificationsViewed SET lastRetrieved = NOW() WHERE username ='".$_SESSION['logged_user']."'");
}
elseif($type == 'event') {
	$response = '{"notification": "A new <a href=\'event.php?id='.$notification['actionid'].'\'>event</a> has been added.", "date": "'.$time.'"}';
	$mysql->query("UPDATE notificationsViewed SET lastRetrieved = NOW() WHERE username ='".$_SESSION['logged_user']."'");
}
echo $response;
?>