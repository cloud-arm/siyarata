<?php

include_once("../config.php"); 


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $c_date = $_POST['c_date'];
    $location = $_POST['location'];
    $c_note = $_POST['c_note'];
    $d_type = $_POST['d_type'];

    // Check if the form is submitted
    $where = "c_date = '$c_date'";
    $result = select('channeling', 'MAX(patient_number) as max_number', $where, '../');

    // Fetch the result
    //$row = $result->fetch(PDO::FETCH_ASSOC);

    $max_number = $row['max_number'] ?? 0;
    $new_number = $max_number + 1;





    $insertData = array(
        "data" => array(
            "name" => $name,
            "c_date" => $c_date,
            "location" => $location,
            "c_note" => $c_note,
            "patient_number" => $new_number,
            "d_type" => $d_type,
        ),
        "other" => array(),
    );





    try {
        if (insert("channeling", $insertData, '../')) {
            echo '<script language="javascript">';
            echo 'alert("Patient successfully recorded with number ' . $new_number . '")';
            echo '</script>';
            echo "<script> location.href='../index.php';</script>";
        } else {
            throw new Exception("Insertion failed");
        }
    } catch (Exception $e) {
        echo "Insertion failed: " . $e->getMessage();
    }
}
?>
