<?php
//if (!session_id()) session_start();

include("common/functions.php");
include("common/db.php");
include("common/mailer/email.php");

$data = $_REQUEST;
$require_params = array("firstname", "lastname", "username", "email", "phone", "password");

foreach($require_params as $rp)
{
	if (!isset($data["$rp"]) || trim($data["$rp"]) == "")
		die(json_encode(array("res" => 301, "msg" => "Require Parameters!!!")));
}

$firstname = $data['firstname'];
$lastname = $data['lastname'];
$username = $data['username'];
$email = $data['email'];
$phone = $data['phone'];
$password = $data['password'];

$users = get_all("select * from tbl_donator where email='$email' or username='$username'");

if (count($users) > 0) {
    $user = $users[0];
    $user_id = $user['id'];
    if ($user['active'] == 1)
      die(json_encode(array("res" => 311, "msg" => "Already signed up.")));
      
    sql("delete from tbl_donator where id='$user_id'");
	
}
//log_action("signup", "$username signup");
$hash = md5( rand(0,1000) );
   

//Send Verify mail
$title = "Sign-Up Confirmation";
$message = '
 
Thank you for being part of our journey, contributing to the better cause using a secure and simplified process.
You can now start contributing and sharing to the world.
Your deeds will be notable and appreciated for all in need. 

Please click this link to activate your account:
http://52.37.98.78/deedio/api_new/verify.php?email='.$email.'&hash='.$hash.'

Sincerely,  
Deedio

--------------------------------------------------------------------------------------------
This email was sent to ' . $username . ' by Deedio.
Deedio is a product of Deedio LLC., 801 Idaho Ave., Unit 9, Santa Monica, CA 90403.
You are receiving this email because you are subscribed to one or more of Deedio’s services.
'; // Our message above including the link

$addr = array();
$addr[] = $email;
if (!send_mail1($title, $message, "", $addr)) {
    die(json_encode(array("res" => 331, "msg" => "Mail error!!!")));
}

// Save userinfo to db
$query = "INSERT INTO tbl_donator (name_first, name_last, username, email, phone, password, hash) VALUES (";
$query .= "'" . mysql_escape_string($firstname) . "',";
$query .= "'" . mysql_escape_string($lastname) . "',";
$query .= "'" . mysql_escape_string($username) . "',";
$query .= "'" . mysql_escape_string($email) . "',";
$query .= "'" . mysql_escape_string($phone) . "',";
$query .= "'" . mysql_escape_string(md5($password)) . "',";
$query .= "'" . mysql_escape_string($hash) . "' )";

sql($query);
$user_id = mysql_insert_id();

// return response
$res = array("res" => 200, "msg" => "Success", "user_id" => "$user_id", "hash" => "$hash");
echo json_encode($res);
exit;

?>
