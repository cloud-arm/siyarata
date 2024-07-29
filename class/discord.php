<?php

function discord($message, $header = "", $table = '')
{
    $response = ['message' => 'Invalid Host', 'status' => 'failed'];

    if ($_SERVER['SERVER_NAME'] != 'localhost') {

        $server = $_SERVER['SERVER_NAME'];

        if (empty($header)) {
            $header = "Foodnet";
        }

        $text = "Server => [" . $server . "]\nMessage => " . $message;

        if (!empty($table)) {
            $text = "Server => [" . $server . "]\nMessage => " . $message . "\nTable => " . $table;
        }

        $data = [
            "content" => $text,
            "username" => $header,
        ];

        $curl = curl_init('https://discord.com/api/webhooks/1266975030739206195/hHW5L1LPthYQSTZHYbkRTKwEGHhbKc5F7kkW1DPSDrZXok4f4TBVqXiim2ZYZezk14Fx');
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $response['status'] = curl_exec($curl);
        $response['message'] = curl_error($curl);

        if (empty($response['status'])) {
            $response['status'] = "success";
        }

        curl_close($curl);
    }

    return $response['status'];
}
