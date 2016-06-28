<?php

include("common/functions.php");
include("common/db.php");
include("common/mailer/email.php");
//include("anet-sdk-php/PaymentTransactions/charge-credit-card.php");

$data = $_REQUEST;
$require_params = array("user_id", "amount", "inst_id", "pay_type", "hash");

foreach($require_params as $rp)
{
	if (!isset($data["$rp"]) || trim($data["$rp"]) == "")
		die(json_encode(array("res" => 301, "msg" => "Require Parameters!!!")));
}

$user_id = $data['user_id'];
$amount = $data['amount'];
$inst_id = $data['inst_id'];
$pay_type = $data['pay_type'];
$hash = $data['hash'];

// Get donator info
$users = get_all("select * from tbl_donator where id='$user_id' and hash='$hash' and active='1'");
if (count($users) == 0) {
    die(json_encode(array("res" => 311, "msg" => "Invalid user!!!")));
}
$donator = $users[0];

// Get institution info
$users = get_all("select * from tbl_institution where id='$inst_id'");
if (count($users) == 0) {
    die(json_encode(array("res" => 311, "msg" => "Invalid institution!!!")));
}
$institution = $users[0];

//log_action("pay2owner", $users[0]['username'] . " paid to $donate_id \$$amount");
// Save log to transaction table
$email = $donator['email'];

$donator_id = $donator['id'];
$total_amount = $amount;
$bucket_489 = '';
$bucket_9511 = '';
$today = date('Y-m-d');
$cur_time = date("H:i:s");  
$confirmation = 0;
$receiver_institution = $institution['legal_name'];
$cc_ach = '';
$cc_brand = '';
$cc = '';
$ach = '';
$bank_name = $institution['bank_name'];

$query = "INSERT INTO tbl_transaction (donator_id, total_amount, bucket_489, bucket_9511, date, time, confirmation, receiver_institution, cc_ach, cc_brand, cc, ach, bank_name) ";
$query .= "VALUES ('". $donator_id ."'";

$query .= ", '" . $total_amount . "'";
$query .= ", '" . $bucket_489 . "'";
$query .= ", '" . $bucket_9511 . "'";
$query .= ", '" . $today . "'";
$query .= ", '" . $cur_time . "'";
$query .= ", '" . $confirmation . "'";
$query .= ", '" . $receiver_institution . "'";
$query .= ", '" . $cc_ach . "'";
$query .= ", '" . $cc_brand . "'";
$query .= ", '" . $cc . "'";
$query .= ", '" . $ach . "'";
$query .= ", '" . $bank_name . "'";

sql($query);
$last_id = mysql_insert_id(); // inserted id for verification after payment processing

/*
// Do payment
if (pay_type == 'credit') { //Credit card case
	//chargeCreditCard_d2i($amount, $card_number, $exp_date, $card_code, $desc='New Donation');
	$ret = chargeCreditCard_d2i($last_id, $amount*0.9511, $institution['bank_acc_number'], "1226", $institution['ein'], 'New Donation');
	if ($ret){ //payment success
		//send payment success mail
		if (pay_success_mail($email, $receiver_institution)) {
			$res = array("res" => 200, "msg" => "Success");
		} else {
			$res = array("res" => 200, "msg" => "Payment Success, but mail send failed");
		}
	} else { // payment false
		die(json_encode(array("res" => 311, "msg" => "Payment error!!!")));
	}

} else if (pay_type == 'bank'){ //Bank case
	/*	
	$ret = debitBankAccount_d2i($last_id, $amount*0.9511, $mloginid, $mtrankey);
	if ($ret){ //payment success
		//send payment success mail
		if (pay_success_mail($email, $receiver_institution)) {
			$res = array("res" => 200, "msg" => "Success");
		} else {
			$res = array("res" => 200, "msg" => "Payment Success, but mail send failed");
		}
	} else { // payment false
		die(json_encode(array("res" => 311, "msg" => "Payment error!!!")));
	}//
} else if (pay_type == 'paypal'){ //Paypal case
	/*	
	$ret = debitBankAccount_d2i($last_id, $amount*0.9511, $mloginid, $mtrankey);
	if ($ret){ //payment success
		//send payment success mail
		if (pay_success_mail($email, $receiver_institution)) {
			$res = array("res" => 200, "msg" => "Success");
		} else {
			$res = array("res" => 200, "msg" => "Payment Success, but mail send failed");
		}
	} else { // payment false
		die(json_encode(array("res" => 311, "msg" => "Payment error!!!")));
	}//
} else if (pay_type == 'applepay'){ //Paypal case
	/*	
	$ret = debitBankAccount_d2i($last_id, $amount*0.9511, $mloginid, $mtrankey);
	if ($ret){ //payment success
		//send payment success mail
		if (pay_success_mail($email, $receiver_institution)) {
			$res = array("res" => 200, "msg" => "Success");
		} else {
			$res = array("res" => 200, "msg" => "Payment Success, but mail send failed");
		}
	} else { // payment false
		die(json_encode(array("res" => 311, "msg" => "Payment error!!!")));
	}//
}//*/
$res = array("res" => 200, "msg" => "Success");
echo json_encode($res);
exit;

?>
