<?php
// INCLUDE THE ACCESS TOKEN FILE
include 'accessToken.php';

date_default_timezone_set('Africa/Nairobi');
$processrequestUrl = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
// live link to test the callback url
$callbackurl = '';
// get the pass key from > mpesa express > simulator
$passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';

// paybill no
$BusinessShortCode = '174379';
$Timestamp = date('YmdHis');
// ENCRYPT DATA TO GET PASSWORD
$Password = base64_encode($BusinessShortCode . $passkey . $Timestamp);
// SENDERS PHONE NUMBER
$phone = '254795370669';
$money = '1';
$PartyA = $phone;
// PAYBILL NUMBER
$PartyB = '';
// ACCOUNT NUMBER
$AccountReference = '';
$TransactionDesc = '';
$Amount = $money;
$stkpushheader = ['Content-Type:application;/json', 'Authorization:Bearer ' . $access_token];

// INITIATE THE CURL
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $processrequestUrl);
curl_setopt($curl, CURLOPT_HEADER, $stkpushheader);
$curl_post_data = array(
    "BusinessShortCode": $BusinessShortCode,    
    "Password": $Password,    
    "Timestamp":$Timestamp,    
    "TransactionType": "CustomerPayBillOnline",    
    "Amount": $Amount,    
    "PartyA":$PartyA,    
    "PartyB":$BusinessShortCode,    
    "PhoneNumber":$PartyA,    
    "CallBackURL": $callbackurl,    
    "AccountReference":$AccountReference,    
    "TransactionDesc":$TransactionDesc,
);