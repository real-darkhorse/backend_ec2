<?php
if (!session_id()) session_start();
include("functions.php");
debug($_REQUEST);
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
$data = isset($_REQUEST['data']) ? $_REQUEST['data'] : "";
if (trim($action) == "")
	die(json_encode(array("res" => 301, "msg" => "Require Action!!!")));

if (is_file("$action.php"))
{
	if (is_object($data))
		$data = get_object_vars($data);
	else if (!is_array($data))
		$data = json_clean_decode(str_replace("\\", '', $data));

	include("db.php");
	include("$action.php");
}

echo json_encode($res);
?>
