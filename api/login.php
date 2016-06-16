<?php
include("functions.php");
include("db.php");

$data = $_REQUEST;
$require_params = array("username", "password");
foreach($require_params as $rp)
{
	if (!isset($data[$rp]) || trim($data[$rp]) == "")
		die(json_encode(array("res" => 301, "msg" => "Require Parameters!!!")));
}

$username = $data['username'];
$password = $data['password'];

$users = get_all("select * from tbl_user where username='$username' and active='1'");
if (count($users) == 0) {
    die(json_encode(array("res" => 311, "msg" => "Invalid user!!!")));
}

$sql = "select * from tbl_user ";
$sql .= " where username='$username' ";
$sql .= " and password='$password' ";
$sql .= " and active='1' ";

$users = get_all($sql);
if (count($users) > 0) { 
    $hash = $users[0]['hash'];
    $user_id = $users[0]['id'];
	$firstname = $users[0]['firstname'];
	$lastname = $users[0]['lastname'];
	$username = $users[0]['username'];
	$email = $users[0]['email'];
	$mobile = $users[0]['mobile'];

    $res = array("res" => 200, "msg" => "Success", "user_id" => "$user_id", "hash" => "$hash", "firstname" => "$firstname", "lastname" => "$lastname", "username" => "$username", "email" => "$email", "mobile" => "$mobile");

	log_action("login", "$username login");
}
else 
    $res = array("res" => 301, "msg" => "Invalid password!!!");

echo json_encode($res);
?>
