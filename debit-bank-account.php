<?php
  require 'autoload.php';
  use net\authorize\api\contract\v1 as AnetAPI;
  use net\authorize\api\controller as AnetController;

  //define("AUTHORIZENET_LOG_FILE", "phplog");

  function debit_do2de($amount, $routing_no, $account_no, $name_on_account, $bank_name){
    // Common setup for API credentials
    $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
    $merchantAuthentication->setName(\SampleCode\Constants::MERCHANT_LOGIN_ID);
    $merchantAuthentication->setTransactionKey(\SampleCode\Constants::MERCHANT_TRANSACTION_KEY);
    $refId = 'ref' . time();

    // Create the payment data for a Bank Account
    $bankAccount = new AnetAPI\BankAccountType();
    //$bankAccount->setAccountType('CHECKING');
    $bankAccount->setEcheckType('WEB');
    $bankAccount->setRoutingNumber($routing_no);//\SampleCode\Constants::DEBIT_ROUTING_NUMBER
    $bankAccount->setAccountNumber($account_no);//\SampleCode\Constants::DEBIT_ACCOUNT_NUMBER
    $bankAccount->setNameOnAccount($name_on_account);//\SampleCode\Constants::NAME_ON_ACCOUNT
    $bankAccount->setBankName($bank_name);//\SampleCode\Constants::BANK_NAME

    $paymentBank= new AnetAPI\PaymentType();
    $paymentBank->setBankAccount($bankAccount);


    //create a debit card Bank transaction
    
    $transactionRequestType = new AnetAPI\TransactionRequestType();
    $transactionRequestType->setTransactionType( "authCaptureTransaction"); 
    $transactionRequestType->setAmount($amount);
    $transactionRequestType->setPayment($paymentBank);

    $request = new AnetAPI\CreateTransactionRequest();
    $request->setMerchantAuthentication($merchantAuthentication);
    $request->setRefId( $refId);
    $request->setTransactionRequest( $transactionRequestType);
    $controller = new AnetController\CreateTransactionController($request);
    $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);
	
	$result = array();//result retrun value
    if ($response != null)
    {
      $tresponse = $response->getTransactionResponse();
      if (($tresponse != null) && ($tresponse->getResponseCode()== \SampleCode\Constants::RESPONSE_OK) )   
      {
        //echo  "Debit Bank Account APPROVED  :" . "\n";
        //echo " Debit Bank Account AUTH CODE : " . $tresponse->getAuthCode() . "\n";
        //echo " Debit Banlk Account TRANS ID  : " . $tresponse->getTransId() . "\n";
		
		$result['res'] = 'success';
		$result['auth_code'] = $tresponse->getAuthCode();
		$result['trans_id'] = $tresponse->getTransId();
		return $result;
      }
      elseif (($tresponse != null) && ($tresponse->getResponseCode()=="2") )
      {
        //echo  "Debit Bank Account ERROR : DECLINED" . "\n";
        $errorMessages = $tresponse->getErrors();
        //echo  "Error : " . $errorMessages[0]->getErrorText() . "\n";
		
		$result['res'] = 'error';
		$result['code'] = 1;
		$result['error'] = "Debit Bank Account ERROR : DECLINED";
		$result['error_details'] = $errorMessages[0]->getErrorText();
		return $result;
      }
      elseif (($tresponse != null) && ($tresponse->getResponseCode()=="4") )
      {
		$result['res'] = 'error';
		$result['code'] = '2';
		$result['error'] = "Debit Bank Account ERROR: HELD FOR REVIEW:";
		return $result;
      }
      else
      {
        //echo  "Debit Bank Account 3 response returned";
		$result['res'] = 'error';
		$result['code'] = '3';
		$result['error'] = "Debit Bank Account 3 response returned";
		return $result;
      }
    }
    else
    {
		$result['res'] = 'error';
		$result['code'] = '4';
		$result['error'] = "Debit Bank Account Null response returned";
		return $result;
    }
    return $response;
  }
  //if(!defined('DONT_RUN_SAMPLES'))
    //debitBankAccount( \SampleCode\Constants::SAMPLE_AMOUNT);
?>
