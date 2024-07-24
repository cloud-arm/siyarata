<?php

include("head.php");
include_once("auth.php");
include('connect.php');
$r = $_SESSION['SESS_LAST_NAME'];
$_SESSION['SESS_DEPARTMENT'] = 'management';
$_SESSION['SESS_FORM'] = 'index';

include_once("start_body.php"); 


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $p_name = $_POST['p_name'];
    $p_phone_no = $_POST['p_phone_no'];
    $p_NIC = $_POST['p_NIC'];
    $p_address = $_POST['p_address'];

    
    $nicResult = select('new_patient', '*', "p_NIC = '$p_NIC'", '');
    if ($nicResult && $nicResult->rowCount() > 0) {
        echo '<script>alert("NIC already exists");</script>';
        echo "<script>location.href='addnewpatient.php';</script>";
        exit();
    }

   
    $phoneResult = select('new_patient', '*', "p_phone_no = '$p_phone_no'", '');
    if ($phoneResult && $phoneResult->rowCount() > 0) {
        echo '<script>alert("Phone number already exists");</script>';
        echo "<script>location.href='addnewpatient.php';</script>";
        exit();
    }

    
    $stmt = $db->prepare("INSERT INTO new_patient (p_name, p_phone_no, p_NIC, p_address) VALUES (?, ?, ?, ?)");
    $stmt->bindParam(1, $p_name);
    $stmt->bindParam(2, $p_phone_no);
    $stmt->bindParam(3, $p_NIC);
    $stmt->bindParam(4, $p_address);

    if ($stmt->execute()) {
        echo '<script>alert("Patient successfully recorded");</script>';
        echo "<script>location.href='index.php';</script>";
    } else {
        echo '<script>alert("Error recording patient");</script>';
        echo "<script>location.href='addnewpatian.php';</script>";
    }
}
?>
