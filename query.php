<?php
// INCLUDE THE ACCESS TOKEN FILE
include 'accessToken.php';

date_default_timezone_set('Africa/Nairobi');
$query_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpushquery/v1/query';
$BusinessShortCode = '174379';
$Timestamp = date('YmdHis');

$passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
$Password = base64_encode($BusinessShortCode . $passkey . $Timestamp);
$CheckoutRequestID = 'ws_CO_17052023112533894795370669';
$queryheader = ['Content-Type:application/json', 'Authorization:Bearer ' . $access_token ];

// initiating the transaction
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $query_url);
curl_setopt($curl, CURLOPT_HTTPHEADER, $queryheader);
$curl_post_data = array(
    'BusinessShortCode' => $BusinessShortCode,
    'Password' => $Password,
    'Timestamp' => $Timestamp,
    'CheckoutRequestID' => $CheckoutRequestID
);

$data_string = json_encode($curl_post_data);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
$curl_response = curl_exec($curl);

$data_to = json_decode($curl_response);

$message = '';

if (isset($data_to->ResultCode)) {
    $ResultCode = $data_to->ResultCode;
    if ($ResultCode == '1037') {
        $message = "Timeout in completing transaction";
    } elseif ($ResultCode == '1032') {
        $message = "Transaction has cancelled by user";
    } elseif ($ResultCode == '1') {
        $message = "The balance is insufficient for the transaction";
    } elseif ($ResultCode == '0') {
        $message = "The transaction is successful";
    }
}

echo $message;