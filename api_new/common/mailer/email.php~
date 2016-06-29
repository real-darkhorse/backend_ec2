<?php

require 'PHPMailerAutoload.php';

function send_mail ($title, $body, $attach, $mailbox) { // Yahoo mail send
	$mail = new PHPMailer ();
	$mail->IsSMTP();
	$mail->IsHTML(true);
	$mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
	$mail->SMTPAuth = true; // enable SMTP authentication
	$mail->SMTPSecure = "ssl"; 
	$mail->Host = "plus.smtp.mail.yahoo.com";
	$mail->Port = 465; // set the SMTP port
	$mail->Username = "darkhorse.star@yahoo.com";
	$mail->Password = "aaaAAA111!!!"; 
	$mail->From = "darkhorse.star@yahoo.com";
	$mail->FromName = "Deedio";
	$mail->Subject = $title;
	$mail->Body = $body;
	$mail->msgHTML = $body;

	if ($mailbox != "" && $mailbox != null) {
            foreach ($mailbox as $mailadd) {
	        $mail->AddAddress ($mailadd, '');
	    }
	}
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

function send_mail1 ($title, $body, $attach, $mailbox) { // Gmail send

	$mail = new PHPMailer(); // create a new object
	$mail->IsSMTP(); // enable SMTP
	$mail->IsHTML(true);
	$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
	$mail->SMTPAuth = true; // authentication enabled
	$mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 587; // or 587
	$mail->IsHTML(true);
	$mail->Username = "confirmation@deedio.co";
	$mail->Password = "De3dio@123";
	$mail->SetFrom("confirmation@deedio.co");//"confirmation@deedio.co"

	$mail->Subject = $title;
	$mail->Body = $body;
	$mail->msgHTML = $body;

	if ($mailbox != "" && $mailbox != null) {
        foreach ($mailbox as $mailadd) {
            $mail->AddAddress ($mailadd, '');
        }
    }

	if (strlen ($attach) > 0) {
        $attach_file = "MSO_" . CUSTOMER_CODE . "_" . date ("Ymd") . ".txt";
        $mail->AddAttachment ($attach, $attach_file);
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

//User Sign up confirmation email
function sendmail_usersignup ($email, $firstname, $lastname, $hash) {
	$title = "Sign-Up Confirmation";
	$message = '
Dear '.$firstname.' '.$lastname.'
<br><br>
Thank you for being part of our journey, contributing to the better cause using a secure and simplified process!<br>
You can now start contributing and sharing to the world. Your deeds will be notable and appreciated for all in need. 
<br><br>
Sincerely,<br>  
<A href="deedioapp://deeplink/verify?email='.$email.'&hash='.$hash.'">Deedio</A><br>
<br>
<hr/>
This email was sent to '.$email.' by Deedio.<br>
Deedio is a product of <A href="http://www.deedio.co/">Deedio LLC.</A>, 801 Idaho Ave., Unit 9, Santa Monica, CA 90403.<br>
You are receiving this email because you are subscribed to one or more of Deedio’s services.
'; // Our message above including the link

	$addr = array();
	$addr[] = $email;
	if (!send_mail($title, $message, "", $addr)) {
		return false;
	}
	
	return true;
}

//Forget password confirmation email
function sendmail_forgetpwd ($email, $firstname, $lastname, $hash) {
	$title = "Forget password Confirmation";
	$message = '
Hey '.$firstname.' '.$lastname.'
<br><br>
We were told that you forgot your password on Deedio
<br><br>
To reset your password, please click <A href="deedioapp://deeplink/forget?email='.$email.'&hash='.$hash.'">here</A>
<br><br>
Thanks,<br>
The Deedio Team
'; // Our message above including the link

	$addr = array();
	$addr[] = $email;
	if (!send_mail($title, $message, "", $addr)) {
		return false;
	}
	
	return true;
}

// Payment success mail 
function sendmail_paysuccess($firstname, $lastname, $email, $instname, $confirm_num, $date, $pay_method, $acc_num, $acc_holder, $amount) {
	$title = "Deedio - Contribution confirmation";
	$message = '
Dear '.$firstname.' '.$lastname.'<br>
<br>
On behalf of '.$instname.', Deedio would like to thank you for your in-kind donation.<br>
'.$instname.' relies on the generosity of donors such as yourself and is grateful for your support.<br>
<br>
Contribution details:<br>
Confirmation number: '.$confirm_num.'<br>
Institution Name: '.$instname.'<br>
Date: '.$date.'<br>
Payment method: '.$pay_method.'<br>
Card/Bank Account number: '.$acc_num.' (last four digits) <br>
Card/Bank Account Holder: '.$acc_holder.'<br>
Total Amount of donation: $ '.$amount.'<br>
<br>
Thank you once again.<br>
<br>
Sincerely,<br>
Deedio<br>
<hr/>
This email was sent to '.$email.' by Deedio.<br>
Deedio is a product of <A href="http://www.deedio.co/">Deedio LLC.</A>, 801 Idaho Ave., Unit 9, Santa Monica, CA 90403.<br>
You are receiving this email because you are subscribed to one or more of Deedio’s services.
'; // Our message above including the link

	$addr = array();
	$addr[] = $email;
	if (!send_mail($title, $message, "", $addr)) {
		return false;
	}
	return true;
}
// Email changed verification mail
/*
function emailchange_send ($email) {
	$title = "Email changed";
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
	if (!send_mail($title, $message, "", $addr)) {
		return false;
	}
	
	return true;
}//*/

?>
