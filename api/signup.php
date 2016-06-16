<?php
//if (!session_id()) session_start();

include("functions.php");
include("db.php");

$data = $_REQUEST;
$require_params = array("firstname", "lastname", "username", "email", "mobile", "password");

foreach($require_params as $rp)
{
	if (!isset($data["$rp"]) || trim($data["$rp"]) == "")
		die(json_encode(array("res" => 301, "msg" => "Require Parameters!!!")));
}

$firstname = $data['firstname'];
$lastname = $data['lastname'];
$username = $data['username'];
$email = $data['email'];
$mobile = $data['mobile'];
$password = $data['password'];

$users = get_all("select * from tbl_user where email='$email' or username='$username'");

if (count($users) > 0) {
    $user = $users[0];
    $user_id = $user['id'];
    if ($user['active'] == 1)
      die(json_encode(array("res" => 311, "msg" => "Already signed up.")));
      
    sql("delete from tbl_user where id='$user_id'");
	
}
log_action("signup", "$username signup");

// generate confirmation code 16byte
$hash = substr(md5(uniqid(rand(), true)), 16, 16);
    
$query = "INSERT INTO tbl_user (firstname, lastname, username, email, mobile, password, hash, active) ";
$query .= "VALUES ('$firstname', '$lastname', '$username', '$email', '$mobile', '$password', '$hash', '1')";

sql($query);
$user_id = mysql_insert_id();

$res = array("res" => 200, "msg" => "Success", "user_id" => "$user_id", "hash" => "$hash");
echo json_encode($res);
exit;
?>
