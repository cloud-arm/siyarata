<?php
include_once("../config.php"); 
include_once("../connect.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $c_date = $_POST['c_date'];
    $location = $_POST['location'];
    $c_note = $_POST['c_note'];
    $d_type = $_POST['d_type'];

    // Validate inputs
    if (empty($name) || empty($c_date) || empty($location) || empty($c_note) || empty($d_type)) {
        echo '<script>alert("All fields are required.");</script>';
        echo "<script>location.href='../add_channel.php';</script>";
        exit();
    }

    // Check if the form is submitted
    $where = "c_date = '$c_date'";
    $result = select('channeling', 'MAX(patient_number) as max_number', $where, '../');

    if ($result) {
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
                echo '<script>alert("Patient successfully recorded with number ' . $new_number . '");</script>';
                echo "<script>location.href='../index.php';</script>";
            }
        } catch (PDOException $e) {
            echo "Insertion failed: " . $e->getMessage();
        }
    } else {
        echo '<script>alert("Error retrieving patient number.");</script>';
        echo "<script>location.href='../add_channel.php';</script>";
    }
}
?>
