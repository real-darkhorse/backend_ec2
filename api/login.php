<?php

include("common/functions.php");
include("common/db.php");

$data = $_REQUEST;
$require_params = array("username", "password");
foreach($require_params as $rp)
{
	if (!isset($data[$rp]) || trim($data[$rp]) == "")
		die(json_encode(array("res" => 301, "msg" => "Require Parameters!!!")));
}

$username = mysql_escape_string($data['username']);
$password = mysql_escape_string(md5($data['password']));

$users = get_all("select * from tbl_donator where username='$username' and active='1'");
if (count($users) == 0) {
    die(json_encode(array("res" => 311, "msg" => "Invalid user!!!")));
}

$sql = "select * from tbl_donator ";
$sql .= " where username='$username' ";
$sql .= " and password='$password' ";
$sql .= " and active='1' ";

$users = get_all($sql);
if (count($users) == 0) {
    die(json_encode(array("res" => 301, "msg" => "Invalid password!!!")));
}

	$user = $users[0];
    $hash = $user['hash'];
    $user_id = $user['id'];
	$firstname = $user['name_first'];
	$lastname = $user['name_last'];
	$username = $user['username'];
	$email = $user['email'];
	$phone = $user['phone'];


    $res = array("res" => 200, "msg" => "Success", "user_id" => "$user_id", "hash" => "$hash", "firstname" => "$firstname", "lastname" => "$lastname", "username" => "$username", "email" => "$email", "phone" => "$phone");

login_log($user_id);
echo json_encode($res);
?>
