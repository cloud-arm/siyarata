<?php

include_once("config.php");

$nic = $_GET['nic'];
$patient_id = 0;
$result = select('patient', '*', "patient_NIC = '$nic'");
for ($i = 0; $row = $result->fetch(); $i++){
    $patient_id = $row['patient_id'];
    $name = $row['patient_name'];
    $patient_address = $row['patient_address'];
    $patient_NIC = $row['patient_NIC'];
    $patient_phone_no = $row['patient_phone_no'];
    
    

}

    if($patient_id > 0){
        $response = array('patient_name'=>$name,'patient_phone_no'=>$patient_phone_no,'patient_NIC'=>$patient_NIC,'patient_address'=>$patient_address, 'patient_id'=>$patient_id,'action'=>'true');
    }else{
        $response = array('action'=>'false');
    }




$json_response = json_encode($response);
echo $json_response;

