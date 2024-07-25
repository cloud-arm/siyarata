<?php


include_once("../config.php"); 
include_once("../connect.php");


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $p_name = $_POST['p_name'];
    $p_phone_no = $_POST['p_phone_no'];
    $p_NIC = $_POST['p_NIC'];
    $p_address = $_POST['p_address'];

    
    $nicResult = select('new_patient', '*', "p_NIC = '$p_NIC'", '../');
    if ($nicResult && $nicResult->rowCount() > 0) {
        echo '<script>alert("NIC already exists");</script>';
        echo "<script>location.href='addnewpatient.php';</script>";
        exit();
    }

   
    $phoneResult = select('new_patient', '*', "p_phone_no = '$p_phone_no'", '../');
    if ($phoneResult && $phoneResult->rowCount() > 0) {
        echo '<script>alert("Phone number already exists");</script>';
        echo "<script>location.href='addnewpatient.php';</script>";
        exit();
    }

    $insertData = array(
        "data" => array(
            "p_name" => $p_name,
            "p_phone_no" => $p_phone_no,
            "p_NIC" => $p_NIC,
            "p_address" => $p_address,
          
        ),
        "other" => array(),
    );

    


    if (insert("new_patient", $insertData, '../')) {
        echo '<script>alert("Patient successfully recorded");</script>';
        echo "<script>location.href='../patient_details.php';</script>";
    } else {
        echo '<script>alert("Error recording patient");</script>';
        echo "<script>location.href='addnewpatian.php';</script>";
    }
}
?>
