<?php

echo "test"

include_once("../config.php"); 
include_once("../connect.php");



$name = $_POST['name'];
$c_date = $_POST['c_date'];
$location = $_POST['location'];
$c_note = $_POST['c_note'];
$d_type = $_POST['d_type'];




// Check if the form is submitted
$where = "c_date = '$c_date'";
$result = select('channeling', 'MAX(patient_number) as max_number', $where, '../');

// Fetch the result
$row = $result->fetch(PDO::FETCH_ASSOC);

$max_number = $row['max_number'] ?? 0;
$new_number = $max_number + 1;


try {
    $stmt = $db->prepare("INSERT INTO channeling (name, c_date, location, c_note, patient_number, d_type) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bindParam(1, $name);
    $stmt->bindParam(2, $c_date);
    $stmt->bindParam(3, $location);
    $stmt->bindParam(4, $c_note);
    $stmt->bindParam(5, $new_number);
    $stmt->bindParam(6, $d_type);

    if ($stmt->execute()) {
        echo '<script language="javascript">';
        echo 'alert("Patient successfully recorded with number ' . $new_number . '")';
        echo '</script>';
        echo "<script> location.href='../index.php';</script>";
    }
} catch (PDOException $e) {
    echo "Insertion failed: " . $e->getMessage();
}
?>
