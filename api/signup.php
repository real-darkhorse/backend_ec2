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

//Send Verify mail
/*
$to      = $email; // Send email to our user
$subject = 'Signup | Verification'; // Give the email a subject 
$message = '
 
Thanks for signing up!
Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
 
------------------------
Username: '.$firstname.' '.$lastname.'
Password: '.$password.'
------------------------
 
Please click this link to activate your account:
http://192.168.3.60/verify.php?email='.$email.'&hash='.$hash.'
 
'; // Our message above including the link
                     
$headers = 'From:noreply@yourwebsite.com' . "\r\n"; // Set from headers
mail($to, $subject, $message, $headers); // Send our email
//*/
send_mail();

$res = array("res" => 200, "msg" => "Success", "user_id" => "$user_id", "hash" => "$hash");
echo json_encode($res);
exit;
?>
