<?php
//if (!session_id()) session_start();

include("common/functions.php");
include("common/db.php");

$data = $_REQUEST;
$require_params = array("email", "hash", "key");
foreach($require_params as $rp)
{
	if (!isset($data["$rp"]) || trim($data["$rp"]) == "")
		die(json_encode(array("res" => 301, "msg" => "Require Parameters!!!")));
}

$email = mysql_escape_string($data['email']); // Set email variable
$hash = mysql_escape_string($data['hash']); // Set hash variable
$key = mysql_escape_string($data['key']); // crypt passsword

$users = get_all("select * from tbl_donator where active='1' and email='".$email."' AND hash='".$hash."'");
if (count($users) > 0) {
    $user = $users[0];

	$query = "UPDATE `tbl_donator` set `password`='".$key."' where `id`='$user_id' limit 1";
	sql($query);
	$res = array("res" => 200, "msg" => "Success", "sql" => $query);
} else {
	$res = array("res" => 302, "msg" => "invalid verification!");
}
    
echo json_encode($res);
exit;
?>
