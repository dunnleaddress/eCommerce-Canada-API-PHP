<?php

##
## Example php -q TestTrack2IndependentRefund.php
##

require "../msrMpgClasses.php";

/**************************** Request Variables *******************************/

$store_id = 'store1';
$api_token = 'yesguy';

/************************* Transactional Variables ****************************/

$orderid = 'ord-'.date("dmy-G:i:s");
$amount = '1.00';
$pan = '';
$expdate = '';
$pos_code = '00';

/************ Swipe card and read Track1 and/or Track2 ***********************/

$stdin = fopen("php://stdin", 'r');

print ("Please swipe your card:\n");
$track1 = fgets ($stdin);

$startDelim = ";";
$firstChar = $track1{0};
$track = '';

if($firstChar==$startDelim)
{
	$track = $track1;
}
else
{
	print ("\nPlease swipe your card again:\n");
	$track2 = fgets ($stdin);
	$track = $track2;
}

##$track = trim($track);

/*********************** Transactional Associative Array **********************/

$txnArray=array(
				 'type' =>'track2_ind_refund',
				 'order_id' =>$orderid,
				 'amount' =>$amount,
				 'track2'=> $track,
				 'pan' =>$pan,
				 'expdate' =>$expdate,
				 'pos_code' =>$pos_code
           		);

/**************************** Transaction Object *****************************/

$mpgTxn = new msrMpgTransaction($txnArray);

/****************************** Request Object *******************************/

$mpgRequest = new msrMpgRequest($mpgTxn);

/***************************** HTTPS Post Object *****************************/

$mpgHttpPost = new msrMpgHttpsPost($store_id,$api_token,$mpgRequest);

/******************************* Response ************************************/

$mpgResponse=$mpgHttpPost->getMpgResponse();

print ("\nCardType = " . $mpgResponse->getCardType());
print("\nTransAmount = " . $mpgResponse->getTransAmount());
print("\nTxnNumber = " . $mpgResponse->getTxnNumber());
print("\nReceiptId = " . $mpgResponse->getReceiptId());
print("\nTransType = " . $mpgResponse->getTransType());
print("\nReferenceNum = " . $mpgResponse->getReferenceNum());
print("\nResponseCode = " . $mpgResponse->getResponseCode());
print("\nISO = " . $mpgResponse->getISO());
print("\nMessage = " . $mpgResponse->getMessage());
print("\nAuthCode = " . $mpgResponse->getAuthCode());
print("\nComplete = " . $mpgResponse->getComplete());
print("\nTransDate = " . $mpgResponse->getTransDate());
print("\nTransTime = " . $mpgResponse->getTransTime());
print("\nTicket = " . $mpgResponse->getTicket());
print("\nTimedOut = " . $mpgResponse->getTimedOut());


?>