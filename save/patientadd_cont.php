<?php


include_once("../config.php"); 
include_once("../connect.php");


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_name = $_POST['patient_name'];
    $patient_phone_no = $_POST['patient_phone_no'];
    $patient_NIC = $_POST['patient_NIC'];
    $patient_address = $_POST['patient_address'];

    
    $nicResult = select('patient', '*', "patient_NIC = '$patient_NIC'", '../');
    if ($nicResult && $nicResult->rowCount() > 0) {
        echo '<script>alert("NIC already exists");</script>';
        echo "<script>location.href='addnewpatient.php';</script>";
        exit();
    }

   
    $phoneResult = select('patient', '*', "patient_phone_no = '$patient_phone_no'", '../');
    if ($phoneResult && $phoneResult->rowCount() > 0) {
        echo '<script>alert("Phone number already exists");</script>';
        echo "<script>location.href='addnewpatient.php';</script>";
        exit();
    }

    $insertData = array(
        "data" => array(
            "patient_name" => $patient_name,
            "patient_phone_no" => $patient_phone_no,
            "patient_NIC" => $patient_NIC,
            "patient_address" => $patient_address,
          
        ),
        "other" => array(),
    );

    


     (insert("patient", $insertData, '../'))
     {
        echo "<script>alert('Patient successfully recorded');</script>";
        echo "<script>location.href='../patient_details.php';</script>";
     }
    }
?>
