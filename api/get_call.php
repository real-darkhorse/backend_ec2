<?php
include("functions.php");
include("db.php");
require_once('PushNotifications.php');
$data = $_REQUEST;
$require_params = array("mobile", "longitude", "latitude");
foreach($require_params as $rp)
{
	if (!isset($data["$rp"]) || trim($data["$rp"]) == "")
		die(json_encode(array("res" => 301, "msg" => "Require Parameters!!!")));
}
$mobile = $data['mobile'];
$longitude = $data['longitude'];
$latitude = $data['latitude'];
$users = get_all("SELECT * FROM tbl_user AS a LEFT JOIN tbl_setting AS b ON a.user_id=b.user_id WHERE a.active='1' AND a.device_token IS NOT NULL AND a.device_token <> ''");

foreach($users as $user)
{
	$item_token = $user['device_token'];
	$item_long = $user['longitude'];
	$item_lat = $user['latitude'];
	$item_radius = $user['radius'];
	
	//echo distance(32.9697, -96.80322, 29.46786, -98.53506, "M") . " Miles<br>";
	//echo distance(32.9697, -96.80322, 29.46786, -98.53506, "K") . " Kilometers<br>";
	
	//if (distance($item_lat, $item_long, $latitude, $longitude, "K") < $item_radius)
	{
	  $title = 'TESS Notification';
	  $body = "latitude: $latitude, longitude: $longitude";
	  
//	  send_notification1($title, $latitude, $longitude, $item_token);
	  send_notification($title, $latitude, $longitude , $item_token);
	}
}


$res = array("res" => 200, "msg" => "Success");
echo json_encode($res);
?>