<?php
//if (!session_id()) session_start();

include("functions.php");
include("db.php");

$data = $_REQUEST;
$require_params = array("url");
foreach($require_params as $rp)
{
	if (!isset($data["$rp"]) || trim($data["$rp"]) == "")
		die(json_encode(array("res" => 301, "msg" => "Require Parameters!!!")));
}

$url = $data['url'];

$users = get_all("select * from tbl_user where verify_code='$url'");
if (count($users) > 0) {
    $user = $users[0];
    $user_id = $user['user_id'];
    if ($user['active'] == 1)
      die(json_encode(array("res" => 311, "msg" => "Already verifyed.")));
      
 //   sql("delete from tbl_user where user_id='$user_id'");
}
    
//$query = "INSERT INTO tbl_user (firstname, surname, email, mobile, radius, verify_code) ";
//$query .= "VALUES ('$firstname', '$lastname', '$email', '$mobile', '$radius', '$random_hash')";
//$query = "SELECT * FROM tbl_user AS a WHERE a.active='0' AND a.user_id IS '.$user_id'")
$query = "UPDATE `tbl_user` set `active`='1' where `user_id`='$user_id' limit 1";
sql($query);
$res = array("res" => 200, "msg" => "Success", "sql" => $query);
echo json_encode($res);
exit;
?>
