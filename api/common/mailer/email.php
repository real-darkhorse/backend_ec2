<?php

require 'PHPMailerAutoload.php';

function send_mail1 () {

	$email = new PHPMailer ();
    $email->isSMTP ();
    $email->SMTPDebug = 0;
    $email->Debugoutput = 'html';
    $email->Host = "smtp.mail.com";
    $email->Port = 25;
    //$email->SMTPSecure = 'ssl';
    $email->SMTPAuth = true;
    $email->Username = "darkhorse8088@mail.com";
    $email->Password = "aaaAAA111!!!";

    $email->setFrom("darkhorse8088@mail.com", '');
    $email->Subject = "title";
    $email->msgHTML = "body";
    $email->Body = "body";

    $email->AddAddress ('darkhorse.star@yahoo.com', '');



    if (!$email->send ()) {
        echo "Email was not sent!" . PHP_EOL;
        echo "Mailer error : " . $email->ErrorInfo . PHP_EOL;
        return false;
    } else {
        echo "Message has been sent!" . PHP_EOL;
    }

    return true;

}

function send_mail () {

	$mail = new PHPMailer(); // create a new object
	$mail->IsSMTP(); // enable SMTP
	$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
	$mail->SMTPAuth = true; // authentication enabled
	//$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 465; // or 587
	$mail->IsHTML(true);
	$mail->Username = "confirmation@deedio.co";
	$mail->Password = "De3dio@123";
	$mail->SetFrom("confirmation@deedio.co");
	$mail->Subject = "Test";
	$mail->Body = "hello";
	$mail->AddAddress("darkhorse.topstar@yahoo.com");

	 if(!$mail->Send()) {
		echo "Mailer Error: " . $mail->ErrorInfo;
	 } else {
		echo "Message has been sent";
	 }

}
?>