<?php
// INCLUDE THE ACCESS TOKEN FILE
include 'accessToken.php';

date_default_timezone_set('Africa/Nairobi');
$processrequestUrl = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';


// live link to test the callback url
$callbackurl = 'https://www.lmkenya.org/callback.php';
// $callbackurl = 'https://umeskiasoftwares.com/darajaapp/callback.php';


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
$PartyB = '174379';
// ACCOUNT NUMBER
$AccountReference = 'Test';
$TransactionDesc = 'Test';
$Amount = $money;
$stkpushheader = ['Content-Type:application/json', 'Authorization:Bearer ' . $access_token ];


// INITIATE THE CURL
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $processrequestUrl);
curl_setopt($curl, CURLOPT_HTTPHEADER, $stkpushheader);
$curl_post_data = array(
    "BusinessShortCode" => "174379",    
    "Password" => $Password,    
    "Timestamp" => $Timestamp,    
    "TransactionType" => "CustomerPayBillOnline",    
    "Amount" => $Amount,    
    "PartyA" => $PartyA,    
    "PartyB" => "174379",    
    "PhoneNumber" => $PartyA,    
    "CallBackURL" => $callbackurl,    
    "AccountReference" => $AccountReference,    
    "TransactionDesc" => $TransactionDesc,
);

$data_string = json_encode($curl_post_data);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
echo $curl_response = curl_exec($curl);

$data = json_decode($curl_response);

$ResponseCode = $data->ResponseCode;
$CheckoutRequestID = $data->CheckoutRequestID;

if($ResponseCode == 0){
    echo $CheckoutRequestID;
}







