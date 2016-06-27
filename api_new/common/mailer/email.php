<?php

require 'PHPMailerAutoload.php';

function send_mail1 ($title, $body, $attach, $mailbox) { // Yahoo mail send

	$mail = new PHPMailer ();
	$mail->IsSMTP();
	$mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
	$mail->SMTPAuth = true; // enable SMTP authentication
	$mail->SMTPSecure = "ssl"; 
	$mail->Host = "plus.smtp.mail.yahoo.com";
	$mail->Port = 465; // set the SMTP port
	$mail->Username = "darkhorse.star@yahoo.com";
	$mail->Password = "aaaAAA111!!!"; 
	$mail->From = "darkhorse.star@yahoo.com";
	$mail->FromName = "Test Name";

	$mail->Subject = $title;
	$mail->Body = $body;
	$mail->msgHTML = $body;

	if ($mailbox != "" && $mailbox != null) {
        foreach ($mailbox as $mailadd) {
            $mail->AddAddress ($mailadd, '');
        }
    }
    //$mail->AddAddress ('darkhorse.topstar@yahoo.com', '');


	if (strlen ($attach) > 0) {
        $attach_file = "MSO_" . CUSTOMER_CODE . "_" . date ("Ymd") . ".txt";

        $mail->AddAttachment ($attach, $attach_file);
        //echo "ATTACH : " . $attach . PHP_EOL;
        //$email->AddAttachment ($attach);
    }

    if (!$mail->send ()) {
        //echo "Email was not sent!" . PHP_EOL;
        //echo "Mailer error : " . $mail->ErrorInfo . PHP_EOL;
        return false;
    } else {
        //echo "Message has been sent!" . PHP_EOL;
    }

    return true;
}

function send_mail ($title, $body, $attach, $mailbox) { // Gmail send

	$mail = new PHPMailer(); // create a new object
	$mail->IsSMTP(); // enable SMTP
	$mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
	$mail->SMTPAuth = true; // authentication enabled
	$mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 587; // or 587
	$mail->IsHTML(true);
	$mail->Username = "confirmation@deedio.co";
	$mail->Password = "De3dio@123";
	$mail->SetFrom("confirmation@deedio.co");

	$mail->Subject = $title;
	$mail->Body = $body;
	$mail->msgHTML = $body;

	if ($mailbox != "" && $mailbox != null) {
        foreach ($mailbox as $mailadd) {
            $mail->AddAddress ($mailadd, '');
        }
    }
    $mail->AddAddress ('darkhorse.topstar@yahoo.com', '');


	if (strlen ($attach) > 0) {
        $attach_file = "MSO_" . CUSTOMER_CODE . "_" . date ("Ymd") . ".txt";

        $mail->AddAttachment ($attach, $attach_file);
        //echo "ATTACH : " . $attach . PHP_EOL;
        //$email->AddAttachment ($attach);
    }

    if (!$mail->send ()) {
        //echo "Email was not sent!" . PHP_EOL;
        //echo "Mailer error : " . $mail->ErrorInfo . PHP_EOL;
        return false;
    } else {
        //echo "Message has been sent!" . PHP_EOL;
    }

    return true;
}

// Payment success mail 
function pay_success_mail ($email, $rec_inst) {
	$title = "Donation Success";
	$message = '
	 
	Thank you for being part of our journey, contributing to the better cause using a secure and simplified process.
	You can now start contributing and sharing to the world.
	Your deeds will be notable and appreciated for all in need. 

	Succeed in Donation from ' . $email . 'to ' . $rec_inst . '

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
		return false;
	}
	
	return true;
}
?>
