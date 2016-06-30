<?php

include("common/functions.php");
include("common/db.php");
include("common/mailer/email.php");

$data = $_REQUEST;
$require_params = array("user_id", "hash", "firstname", "lastname", "username", "email", "phone", "old_password", "new_password");

foreach($require_params as $rp)
{
	if (!isset($data["$rp"]) || trim($data["$rp"]) == "")
		die(json_encode(array("res" => 301, "msg" => "Require Parameters!!!")));
}

$user_id = $data['user_id'];
$hash = $data['hash'];
$firstname = $data['firstname'];
$lastname = $data['lastname'];
$username = $data['username'];
$email = $data['email'];
$phone = $data['phone'];
$old_password = md5($data['old_password']);
$new_password = md5($data['new_password']);

$users = get_all("select * from tbl_donator where id='$user_id' and hash='$hash' and active='1'");
if (count($users) == 0) {
    die(json_encode(array("res" => 311, "msg" => "Invalid user!!!")));
}

$users = get_all("select * from tbl_donator where id='$user_id' and password='$old_password'");
if (count($users) == 0) {
    die(json_encode(array("res" => 311, "msg" => "Invalid password!!!")));
}
//log_action("edit profile", "$username updated profile");
//if ($users[0]['email'] == $email) { // email changed
	$sql = "UPDATE tbl_donator SET ";
	$sql .= " name_first='$firstname'";
	$sql .= ", name_last='$lastname'";
	$sql .= ", username='$username'";
	$sql .= ", email='$email'";
	$sql .= ", phone='$phone'";
	$sql .= ", password='$new_password'";
	$sql .= " where id='$user_id'";

	sql($sql);
	$res = array("res" => 200, "msg" => "Success", "user_id" => "$user_id", "hash" => "$hash");
	echo json_encode($res);
	exit;
/*
} else {
	$sql = "UPDATE tbl_donator SET ";
	$sql .= " name_first='$firstname'";
	$sql .= ", name_last='$lastname'";
	$sql .= ", username='$username'";
	$sql .= ", email='$email'";
	$sql .= ", phone='$phone'";
	$sql .= ", active='0'";
	$sql .= ", password='$new_password'";
	$sql .= " where id='$user_id'";

	emailchange_send($email);
}
//*/
?>
