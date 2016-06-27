<?php

include("functions.php");
include("db.php");

$data = $_REQUEST;
$require_params = array("user_id", "amount", "donate_id", "hash");

foreach($require_params as $rp)
{
	if (!isset($data["$rp"]) || trim($data["$rp"]) == "")
		die(json_encode(array("res" => 301, "msg" => "Require Parameters!!!")));
}

$user_id = $data['user_id'];
$amount = $data['amount'];
$donate_id = $data['donate_id'];
$hash = $data['hash'];

$users = get_all("select * from tbl_user where id='$user_id' and hash='$hash' and active='1'");
if (count($users) == 0) {
    die(json_encode(array("res" => 311, "msg" => "Invalid user!!!")));
}
log_action("pay2owner", $users[0]['username'] . " paid to $donate_id \$$amount");

$query = "INSERT INTO tbl_pay2owner (user_id, amount, donate_id, time) ";
$query .= "VALUES ('$user_id', '$amount', '$donate_id', '" . get_time() . "')";

sql($query);

$res = array("res" => 200, "msg" => "Success");
echo json_encode($res);
exit;

?>