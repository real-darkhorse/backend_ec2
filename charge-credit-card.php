<?php
  require 'autoload.php';
  use net\authorize\api\contract\v1 as AnetAPI;
  use net\authorize\api\controller as AnetController;

  define("AUTHORIZENET_LOG_FILE", "phplog");

  function credit_do2de($card_number, $exp_date, $card_code, $amount, $desc="User payment") {
      // Common setup for API credentials
      $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
      $merchantAuthentication->setName(\SampleCode\Constants::MERCHANT_LOGIN_ID);
      $merchantAuthentication->setTransactionKey(\SampleCode\Constants::MERCHANT_TRANSACTION_KEY);
      $refId = 'ref' . time();

      // Create the payment data for a credit card
      $creditCard = new AnetAPI\CreditCardType();
      $creditCard->setCardNumber($card_number); //"4111111111111111"
      $creditCard->setExpirationDate($exp_date);//"1226"
      $creditCard->setCardCode($card_code);//"123"
      $paymentOne = new AnetAPI\PaymentType();
      $paymentOne->setCreditCard($creditCard);

      $order = new AnetAPI\OrderType();
      $order->setDescription($desc);//"New Donation"

      //create a transaction
      $transactionRequestType = new AnetAPI\TransactionRequestType();
      $transactionRequestType->setTransactionType( "authCaptureTransaction");
      $transactionRequestType->setAmount($amount);
      $transactionRequestType->setOrder($order);
      $transactionRequestType->setPayment($paymentOne);
      

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
			$result['res'] = 'success';
			$result['auth_code'] = $tresponse->getAuthCode();
			$result['trans_id'] = $tresponse->getTransId();
			return $result;
        }
        else
        {
			$result['res'] = 'error';
			$result['code'] = 1;
			$result['error'] = "Charge Credit Card ERROR :  Invalid response";
			return $result;
        }

     }
     else
      {
			$result['res'] = 'error';
			$result['code'] = 2;
			$result['error'] = "Charge Credit card Null response returned";
			return $result;
      }

	return $response;
  }

  /*
  if(!defined('DONT_RUN_SAMPLES'))
      credit_do2de("4111111111111111","1226","123", \SampleCode\Constants::SAMPLE_AMOUNT);
  //*/
?>
