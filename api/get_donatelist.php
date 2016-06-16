<?php
include("functions.php");
include("db.php");

$data = $_REQUEST;
$require_params = array("user_id", "hash");

foreach($require_params as $rp)
{
	if (!isset($data["$rp"]) || trim($data["$rp"]) == "")
		die(json_encode(array("res" => 301, "msg" => "Require Parameters!!!")));
}

$user_id = $data['user_id'];
$hash = $data['hash'];
$keyword = $data['keyword'] ? $data['keyword'] : "";

$users = get_all("select * from tbl_user where id='$user_id' and hash='$hash' and active='1'");
if (count($users) == 0) {
    die(json_encode(array("res" => 311, "msg" => "Invalid user!!!")));
}
log_action("donatelist", $users[0]['username'] . " get donatelist");

$rows = get_all("SELECT * FROM tbl_donate where name LIKE '%$keyword%'");

$contents = array();
foreach($rows as $row)
{
	$item = array();
	$item['id'] = $row['id'];
	$item['name'] = $row['name'];
	$contents[] = $item;
}

$res = array("res" => 200, "msg" => "Success", "contents" => $contents);
echo json_encode($res);
?>
