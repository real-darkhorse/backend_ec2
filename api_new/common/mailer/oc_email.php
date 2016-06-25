<?php




function email($title, $body, $att) {
//Create a new PHPMailer instance
    $mail = new PHPMailer;
//Tell PHPMailer to use SMTP
    $mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
    $mail->SMTPDebug = 2;
//Ask for HTML-friendly debug output
    $mail->Debugoutput = 'html';
//Set the hostname of the mail server
    $mail->Host = "smtp.emailsrvr.com";
//Set the SMTP port number - likely to be 25, 465 or 587
    $mail->Port = 25;
//Whether to use SMTP authentication
    $mail->SMTPAuth = true;
//Username to use for SMTP authentication
    $mail->Username = "ap@alphamerchant.com";
//Password to use for SMTP authentication
    $mail->Password = "P@4in001";
//Set who the message is to be sent from
    $mail->setFrom('ap@alphamerchant.com', '');
//Set an alternative reply-to address
#$mail->addReplyTo('replyto@example.com', 'First Last');
//Set who the message is to be sent to
#$mail->addAddress(_EMAIL1_, '');

    $mail->addAddress(_EMAIL1_, 'Customer Service Manager');
    $mail->addAddress(_EMAIL2_, '');
    $mail->addAddress(_EMAIL3_, '');
    $mail->addAddress(_EMAIL4_, '');
    $mail->addAddress(_EMAIL5_, '');
    $mail->addAddress(_EMAIL6_, '');

#$mail->addAddress(_EMAIL5_, 'datafeeds@nycappliance.com');

//Set the subject line
    $mail->Subject = $title;
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
    $mail->msgHTML($body);
//Replace the plain text body with one created manually
#$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
    if (strlen($att) > 0) {

        $mail->addAttachment($att);
    }
//send the message, check for errors
    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        echo "Message sent!";
    }
}