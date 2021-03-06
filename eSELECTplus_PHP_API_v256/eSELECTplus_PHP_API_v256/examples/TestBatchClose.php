<?php
##
## This program takes 3 arguments from the command line:
## 1. Store id
## 2. api token
## 3. ecr number
##
## Example php -q TestBatchClose.php store1 yesguy 66002173
##

require "../mpgClasses.php";

$store_id='store5';
$api_token='yesguy';
$ecr_number='66002163';

## step 1) create transaction array ###
$txnArray=array('type'=>'batchclose',
         'ecr_number'=>$ecr_number
           );


$mpgTxn = new mpgTransaction($txnArray);

## step 2) create mpgRequest object ###
$mpgReq=new mpgRequest($mpgTxn);

## step 3) create mpgHttpsPost object which does an https post ##
$mpgHttpPost=new mpgHttpsPost($store_id,$api_token,$mpgReq);

## step 4) get an mpgResponse object ##
$mpgResponse=$mpgHttpPost->getMpgResponse();

##step 5) get array of all credit cards
$creditCards = $mpgResponse->getCreditCards($ecr_number);


## step 6) loop through the array of credit cards and get information

for($i=0; $i < count($creditCards); $i++)
 {
  print "\nCard Type = $creditCards[$i]<br>";

  print "\nPurchase Count = "
        . $mpgResponse->getPurchaseCount($ecr_number,$creditCards[$i])."<br>";

  print "\nPurchase Amount = "
        . $mpgResponse->getPurchaseAmount($ecr_number,$creditCards[$i])."<br>";


  print "\nRefund Count = "
        . $mpgResponse->getRefundCount($ecr_number,$creditCards[$i])."<br>";


  print "\nRefund Amount = "
        . $mpgResponse->getRefundAmount($ecr_number,$creditCards[$i])."<br>";



  print "\nCorrection Count = "
        . $mpgResponse->getCorrectionCount($ecr_number,$creditCards[$i])."<br>";

  print "\nCorrection Amount = "
        . $mpgResponse->getCorrectionAmount($ecr_number,$creditCards[$i])."<br>";

 }



?>

