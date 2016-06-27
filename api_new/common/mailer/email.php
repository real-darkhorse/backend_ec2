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
?>
