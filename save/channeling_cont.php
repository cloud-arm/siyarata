<?php

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once("../config.php"); 
include_once("../connect.php");

try {
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $c_date = $_POST['c_date'];
        $location = $_POST['location'];
        $c_note = $_POST['c_note'];
        $d_type = $_POST['d_type'];

        // Ensure the database connection is established
        if (!$db) {
            throw new Exception("Database connection not established.");
        }

        // Sanitize inputs
        $name = htmlspecialchars($name);
        $c_date = htmlspecialchars($c_date);
        $location = htmlspecialchars($location);
        $c_note = htmlspecialchars($c_note);
        $d_type = htmlspecialchars($d_type);

        // Check the maximum patient number for the given date
        $where = "c_date = :c_date";
        $query = "SELECT MAX(patient_number) as max_number FROM channeling WHERE $where";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':c_date', $c_date);

        if (!$stmt->execute()) {
            throw new Exception("Failed to execute SELECT query.");
        }

        // Fetch the result
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $max_number = $row['max_number'] ?? 0;
        $new_number = $max_number + 1;

        // Insert the new record
        $insertQuery = "INSERT INTO channeling (name, c_date, location, c_note, patient_number, d_type) VALUES (:name, :c_date, :location, :c_note, :patient_number, :d_type)";
        $stmt = $db->prepare($insertQuery);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':c_date', $c_date);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':c_note', $c_note);
        $stmt->bindParam(':patient_number', $new_number);
        $stmt->bindParam(':d_type', $d_type);

        if ($stmt->execute()) {
            echo '<script language="javascript">';
            echo 'alert("Patient successfully recorded with number ' . $new_number . '");';
            echo '</script>';
            echo "<script> location.href='../index.php';</script>";
        } else {
            throw new Exception("Failed to execute INSERT query.");
        }
    }
} catch (PDOException $e) {
    error_log("PDOException: " . $e->getMessage());
    echo "Database error occurred. Please try again later.";
} catch (Exception $e) {
    error_log("Exception: " . $e->getMessage());
    echo "An error occurred. Please try again later.";
}
?>
