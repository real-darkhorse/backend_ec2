<?php
include("functions.php");
include("db.php");

$users = get_all("SELECT * FROM tbl_user where active='1'");

$contents = array();
foreach($users as $user)
{
	$item = array();
	$item['id'] = $user['user_id'];
	$item['name'] = $user['firstname']." ".$user['surname'];
	$contents[] = $item;
}

$res = array("res" => 200, "msg" => "Success", "contents" => $contents);
echo json_encode($res);
?>