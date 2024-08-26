<?php

function sms($phoneNumber, $message){

$curl = curl_init();
$transactionId = date('YmdHis');
$sender_id='CLOUD ARM';

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://e-sms.dialog.lk/api/v2/sms',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
"sourceAddress": "'.$sender_id.'",
"message": "'. $message .'",
"transaction_id": "'.$transactionId.'",
"payment_method": "0",
"msisdn": [
{
"mobile": "'.$phoneNumber.'"
}
],
"push_notification_url": " https://xxx/xx?"
}',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6MTMyODAsInVzZXJuYW1lIjoiZXJhbmRhIiwibW9iaWxlIjo3NzkyNTI1OTQsImVtYWlsIjoiZXJhbmRhc2FtcGF0aDIwMDBAZ21haWwuY29tIiwiY3VzdG9tZXJfcm9sZSI6MCwiaWF0IjoxNzI0NjQyMTIyLCJleHAiOjE3MjQ2ODUzMjJ9.bjmyws3yxkioO9qSuomyLRT7whvoNAIzYSsA3SXl_Xk',
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);

$responseData = json_decode($response, true);

return $responseData;

    // Assuming the response contains 'status' and 'comment' keys
    $status = isset($responseData['status']);
    $comment = isset($responseData['comment']);
    $cost = isset($responseData['campaignCost']);

    // Return the status and comment
    return array(
        'status' => $status,
        'comment' => $comment,
        'campaignCost'=>$cost
    );

}
