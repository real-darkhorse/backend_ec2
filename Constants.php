<?php
namespace SampleCode;

class Constants
{
	//merchant credentials
	const MERCHANT_LOGIN_ID = "5KP3u95bQpv";//"579pVv3RQ2Zk";//5KP3u95bQpv
	const MERCHANT_TRANSACTION_KEY = "4Ktq966gC55GAX7S";//"3wJ96zs7E52q4J48";//4Ktq966gC55GAX7S
	
	//credit card fields
	const CREDIT_CARD_NUMBER = "4111111111111111";
	const CREDIT_CARD_NUMBER_2 = "4242424242424242";
	const EXPIRY_DATE = "2038-12";
	const CVV = "142";
	
	//bank account fields
	const ROUTING_NUMBER = '125000024';
	const DEBIT_ROUTING_NUMBER = '121042882';
	const ACCOUNT_NUMBER = '125000024';
	const DEBIT_ACCOUNT_NUMBER = '123456789123';
	const NAME_ON_ACCOUNT = 'Jane Doe';
	const BANK_NAME= 'Bank of the Earth';
	
	//order info
	const INVOICE_NUMBER = "101";
	const ORDER_DESCRIPTION = "Golf Shirts";
	//cryptogram
	const CRYPTOGRAM = "EjRWeJASNFZ4kBI0VniQEjRWeJA=";
	
	//transaction-id's used by different samples
	const TRANS_ID_PREVIOUSLY_AUTHORIZED = 2249839471;
	const TRANS_ID_VOID = "2249063130";
	const TRANS_ID_TO_CREATE_CUSTOMER_PROFILE = "2249066517";
	
	//split tender id
	const SPLIT_TENDER_ID = "115901";
	//transaction status constants
	const STATUS_VOID = "voided";
	
	
    //limits
	const MAX_AMOUNT = 99999;

	//miscelaneous variables for individual samples
	const SAMPLE_AMOUNT_REFUND = 32.14;
	const SAMPLE_AMOUNT = 12.23;
	const SAMPLE_AUTH_CODE_AUTHORIZED = "ROHNFQ";
	
	//response
	const RESPONSE_OK = "1";
	
	//Recurring Billing
	const SUBSCRIPTION_ID_CANCEL = "3056945";
	const SUBSCRIPTION_ID_UPDATE = "3056948";
	const SUBSCRIPTION_ID_GET = "2930242";
	const SUBSCRIPTION_INTERVAL_DAYS = 23;
	
	//Customer Profiles
	const TEST_CUSTOMER_EMAIL = "test123@test.com";
    const CUSTOMER_PROFILE_ID = "36152127";
    const CUSTOMER_PROFILE_ID_2 = "36731856";
    const CUSTOMER_PROFILE_ID_HOSTED_PAGE = "123212";
	
	const CUSTOMER_PAYMENT_PROFILE_ID = "32689274";
	const CUSTOMER_PAYMENT_PROFILE_ID_DELETE = "38958129";
	const CUSTOMER_PAYMENT_PROFILE_ID_GET = "33211899";
	const CUSTOMER_SHIPPING_ADDRESS_ID_GET = "36976566";
    const PHONE_NUMBER = "000-000-0000";
	
	//Transaction Reporting
	const TRANS_ID = "2238968786";
	const BATCH_ID = "4532808";
	
	//Paypal express Checkout
	const TRANS_ID_PAYPAL = "2241708986";
	const TRANS_ID_PAYPAL_GET = "2249863278";	
	const PAYER_ID = "6ZSCSYG33VP8Q";
	
	//Visa Checkout related values
	const VC_DATA_DESCRIPTOR = "COMMON.VCO.ONLINE.PAYMENT";
	const VC_DATA_VALUE = "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";
	const VC_DATA_KEY = "JxAB39A9yUsf6wMD0jwGKCuY7mmzWaeEj85MH02AfKGUxOkJ00JK+o8vGG55cUF9voYU4QQ1Jec4p6nKmsxXmTREEaJwmQErotD4fpcFOyoqWTLMZfslrkHgiqbwru/V";	
}
?>

