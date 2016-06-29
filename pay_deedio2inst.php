<?php

include("common/functions.php");
include("common/db.php");
include("common/mailer/email.php");
include("anet-sdk-php/vendor/charge-credit-card.php");
include("anet-sdk-php/vendor/debit-bank-account.php");
include("anet-sdk-php/vendor/create-an-apple-pay-transaction.php");


$data = $_REQUEST;
$require_params = array("user_id", "hash", "amount", "inst_id", "pay_type");

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
$firstname = $donator['name_first'];
$lastname = $donator['name_last'];
$email = $donator['email'];
// Get institution info
$insts = get_all("select * from tbl_institution where id='$inst_id'");
if (count($insts) == 0) {
    die(json_encode(array("res" => 311, "msg" => "Invalid institution!!!")));
}
$inst = $insts[0];
$instname = $inst['legal_name'];
$date = date('Y-m-d');
$cur_time = date('H:i:s');


if ($pay_type == 'credit') { //Credit card case
	/////////////////////////////////////////////////////////////////////////////////////
	/// Credit card payment
    /// credit_do2de($card_number, $exp_date, $card_code, $amount, $desc="User payment");
	/////////////////////////////////////////////////////////////////////////////////////

	//Parameter check
	$require_params = array("card_number", "exp_date", "card_code", "amount");

	foreach($require_params as $rp)
	{
		if (!isset($data["$rp"]) || trim($data["$rp"]) == "")
			die(json_encode(array("res" => 301, "msg" => "Require Parameters!!!")));
	}
	$card_number = $data['card_number'];
	$exp_date = $data['exp_date'];
	$card_code = $data['card_code'];
	$amount = $data['amount'];

    //credit_do2de($card_number, $exp_date, $card_code, $amount, $desc="User payment");
	$ret = credit_do2de($card_number, $exp_date, $card_code, $amount); //Do payment from donator to Deedio

	if ($ret['res'] == 'success'){ //payment success
		//Save log to transaction table
		$query = "INSERT INTO tbl_transaction (donator_id, total_amount, bucket_489, bucket_9511, date, time, confirmation, receiver_institution, cc_ach, cc_brand, cc, ach, bank_name) VALUES (";
		$query .= "'" . $user_id . "'";
		$query .= ", '" . $amount . "'";
		$query .= ", '" . $amount*4.89 . "'";
		$query .= ", '" . $amount*95.11 . "'";
		$query .= ", '" . $date . "'";
		$query .= ", '" . $cur_time . "'";
		$query .= ", '" . $ret['trans_id'] . "'";
		$query .= ", '" . $instname . "'";
		$query .= ", '" . $card_number . "'";
		$query .= ", '" . "cc_brand" . "'";
		$query .= ", '" . $card_code . "'";
		$query .= ", '" . "ach" . "'";
		$query .= ", '" . "bank_name" . "')";

		sql($query);
		
		//send payment success mail - sendmail_paysuccess($firstname, $lastname, $email, $instname, $confirm_num, $date, $pay_method, $acc_num, $acc_holder, $amount)
		if (sendmail_paysuccess($firstname, $lastname, $email, $instname, $ret['trans_id'], $date, "Credit Card", $card_number, $card_code, $amount)) {
			$res = array("res" => 200, "msg" => "Success");
		} else {
			$res = array("res" => 200, "msg" => "Payment Success, but mail send failed");
		}
	} else { // payment false
		die(json_encode(array("res" => 311, "msg" => $ret['error'])));
	}


} else if ($pay_type == 'bank'){ //Debit Bank case
	/////////////////////////////////////////////////////////////////////////////////////
	/// Debit bank payment
	/// debit_do2de($amount, $routing_no, $account_no, $name_on_account, $bank_name)
	/////////////////////////////////////////////////////////////////////////////////////
	
	//Parameter check
	$require_params = array("routing_no", "account_no", "name_on_account", "bank_name");

	foreach($require_params as $rp)
	{
		if (!isset($data["$rp"]) || trim($data["$rp"]) == "")
			die(json_encode(array("res" => 301, "msg" => "Require Parameters!!!")));
	}
	$routing_no = $data['routing_no'];
	$account_no = $data['account_no'];
	$name_on_account = $data['name_on_account'];
	$bank_name = $data['bank_name'];

	//debit_do2de($amount, $routing_no, $account_no, $name_on_account, $bank_name)
	$ret = debit_do2de($amount, $routing_no, $acc_no, $name_on_acc, $bank_name);

	if ($ret['res'] == 'success'){ //payment success
		//Save log to transaction table
		$query = "INSERT INTO tbl_transaction (donator_id, total_amount, bucket_489, bucket_9511, date, time, confirmation, receiver_institution, cc_ach, cc_brand, cc, ach, bank_name) VALUES (";
		$query .= "'" . $user_id . "'";
		$query .= ", '" . $amount . "'";
		$query .= ", '" . $amount*4.89 . "'";
		$query .= ", '" . $amount*95.11 . "'";
		$query .= ", '" . $date . "'";
		$query .= ", '" . $cur_time . "'";
		$query .= ", '" . $ret['trans_id'] . "'";
		$query .= ", '" . $instname . "'";
		$query .= ", '" . $account_no . "'";
		$query .= ", '" . $name_on_account . "'";
		$query .= ", '" . $routing_no . "'";
		$query .= ", '" . "ach" . "'";
		$query .= ", '" . $bank_name . "')";

		sql($query);


		//send payment success mail - sendmail_paysuccess($firstname, $lastname, $email, $instname, $confirm_num, $date, $pay_method, $acc_num, $acc_holder, $amount)
		if (sendmail_paysuccess($firstname, $lastname, $email, $instname, $ret['trans_id'], $date, "Bank", $account_no, $name_on_account, $amount)) {
			$res = array("res" => 200, "msg" => "Success");
		} else {
			$res = array("res" => 200, "msg" => "Payment Success, but mail send failed");
		}

	} else { // payment false
		die(json_encode(array("res" => 311, "msg" => $ret['error'])));
	}


} else if ($pay_type == 'applepay'){ // Applepay case
	/////////////////////////////////////////////////////////////////////////////////////
	/// Apple pay payment
	/// createAnApplePayTransaction($amount)
	/////////////////////////////////////////////////////////////////////////////////////

	$ret = createAnApplePayTransaction($amount);

	if ($ret['res'] == 'success'){ //payment success
		//Save log to transaction table
		$query = "INSERT INTO tbl_transaction (donator_id, total_amount, bucket_489, bucket_9511, date, time, confirmation, receiver_institution, cc_ach, cc_brand, cc, ach, bank_name) VALUES (";
		$query .= "'" . $user_id . "'";
		$query .= ", '" . $amount . "'";
		$query .= ", '" . $amount*4.89 . "'";
		$query .= ", '" . $amount*95.11 . "'";
		$query .= ", '" . $date . "'";
		$query .= ", '" . $cur_time . "'";
		$query .= ", '" . $ret['trans_id'] . "'";
		$query .= ", '" . $instname . "'";
		$query .= ", '" . "cc_ach" . "'";
		$query .= ", '" . "cc_brand" . "'";
		$query .= ", '" . "cc" . "'";
		$query .= ", '" . "ach" . "'";
		$query .= ", '" . "bank_name" . "')";

		sql($query);


		//send payment success mail - sendmail_paysuccess($firstname, $lastname, $email, $instname, $confirm_num, $date, $pay_method, $acc_num, $acc_holder, $amount)
		if (sendmail_paysuccess($firstname, $lastname, $email, $instname, $ret['trans_id'], $date, "Apple", "", "", $amount)) {
			$res = array("res" => 200, "msg" => "Success");
		} else {
			$res = array("res" => 200, "msg" => "Payment Success, but mail send failed");
		}

	} else { // payment false
		die(json_encode(array("res" => 311, "msg" => $ret['error'])));
	}

} else if ($pay_type == 'paypal'){ //Paypal case
	/////////////////////////////////////////////////////////////////////////////////////
	
	//Parameter check
	$require_params = array("routing_no", "account_no", "name_on_account", "bank_name");

	foreach($require_params as $rp)
	{
		if (!isset($data["$rp"]) || trim($data["$rp"]) == "")
			die(json_encode(array("res" => 301, "msg" => "Require Parameters!!!")));
	}
	$routing_no = $data['routing_no'];
	$account_no = $data['account_no'];
	$name_on_account = $data['name_on_account'];
	$bank_name = $data['bank_name'];

		//Save log to transaction table
		$query = "INSERT INTO tbl_transaction (donator_id, total_amount, bucket_489, bucket_9511, date, time, confirmation, receiver_institution, cc_ach, cc_brand, cc, ach, bank_name) VALUES (";
		$query .= "'" . $user_id . "'";
		$query .= ", '" . $amount . "'";
		$query .= ", '" . $amount*4.89 . "'";
		$query .= ", '" . $amount*95.11 . "'";
		$query .= ", '" . $date . "'";
		$query .= ", '" . $cur_time . "'";
		$query .= ", '" . "" . "'";
		$query .= ", '" . $instname . "'";
		$query .= ", '" . "" . "'";
		$query .= ", '" . "" . "'";
		$query .= ", '" . "" . "'";
		$query .= ", '" . "ach" . "'";
		$query .= ", '" . "Paypal" . "')";

		sql($query);


		//send payment success mail - sendmail_paysuccess($firstname, $lastname, $email, $instname, $confirm_num, $date, $pay_method, $acc_num, $acc_holder, $amount)
		if (sendmail_paysuccess($firstname, $lastname, $email, $instname, "", $date, "Paypal", "", "", $amount)) {
			$res = array("res" => 200, "msg" => "Success");
		} else {
			$res = array("res" => 200, "msg" => "Payment Success, but mail send failed");
		}
}

//$res = array("res" => 200, "msg" => "Success");
echo json_encode($res);
exit;

?>
