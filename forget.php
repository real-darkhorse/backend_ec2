<?php
//if (!session_id()) session_start();

include("common/functions.php");
include("common/db.php");
include("common/mailer/email.php");

$data = $_REQUEST;
$require_params = array("email");

foreach($require_params as $rp)
{
	if (!isset($data["$rp"]) || trim($data["$rp"]) == "")
		die(json_encode(array("res" => 301, "msg" => "Require Parameters!!!")));
}

$email = $data['email'];

$users = get_all("select * from tbl_donator where email='$email' and active='1'");
if (count($users) == 0) {
    die(json_encode(array("res" => 311, "msg" => "Invalid user!!!")));
}

$user = $users[0];

$hash = $user['hash'];
$firstname = $user['name_first'];
$lastname = $user['name_last'];

//Send Verify mail
if (!sendmail_forgetpwd ($email, $firstname, $lastname, $hash)) {
    die(json_encode(array("res" => 331, "msg" => "Mail error!!!")));
}
// return response
$res = array("res" => 200, "msg" => "Success");
echo json_encode($res);
exit;

/*
$data = $_REQUEST;
$require_params = array("email", "password");

foreach($require_params as $rp)
{
	if (!isset($data["$rp"]) || trim($data["$rp"]) == "")
		die(json_encode(array("res" => 301, "msg" => "Require Parameters!!!")));
}

$email = $data['email'];
$pwd = $data['password'];

$users = get_all("select * from tbl_donator where email='$email' and active='1'");
if (count($users) == 0) {
    die(json_encode(array("res" => 311, "msg" => "Invalid user!!!")));
}

$user = $users[0];
$hash = $user['hash'];
$pwd = md5($password);

//Send Verify mail
$title = "Password Reset";
$message = '
 
Thank you for being part of our journey, contributing to the better cause using a secure and simplified process.
You can now start contributing and sharing to the world.
Your deeds will be notable and appreciated for all in need. 

Please click this link to reset your password:
http://52.37.98.78/deedio/api_new/resetpwd.php?email='.$email.'&hash='.$hash.'&key='.$pwd.'

Sincerely,  
Deedio

--------------------------------------------------------------------------------------------
This email was sent to ' . $email . ' by Deedio.
Deedio is a product of Deedio LLC., 801 Idaho Ave., Unit 9, Santa Monica, CA 90403.
You are receiving this email because you are subscribed to one or more of Deedio’s services.
'; // Our message above including the link

$addr = array();
$addr[] = $email;
if (!send_mail1($title, $message, "", $addr)) {
    die(json_encode(array("res" => 331, "msg" => "Mail error!!!")));
}
// return response
$res = array("res" => 200, "msg" => "Success");
echo json_encode($res);
exit;
*/
?>
