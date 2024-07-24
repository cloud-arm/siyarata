<!DOCTYPE html>
<html lang="en">
<?php
include("head.php");
include_once("auth.php");
$r = $_SESSION['SESS_LAST_NAME'];
$_SESSION['SESS_DEPARTMENT'] = 'management';
$_SESSION['SESS_FORM'] = 'index';
?>
<body class="hold-transition skin-yellow skin-orange sidebar-mini">

    <?php include_once("start_body.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Home
                <small>Preview</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

        <form action="" method="post">
        <h1>View Channels by Date</h1>
        <label for="view_date">Select Date</label>
        <input type="date" id="view_date" name="view_date" required>
        <input type="submit" value="View Channels" name="view_channels">
    </form>

    <?php

    

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['view_channels'])) {
       include 'connect.php';

        $view_date = $_POST['view_date'];
        $where = "c_date = '$view_date' ORDER BY patient_number";

        
        $result = select('channeling', '*', $where, '');

        if ($result && $result->rowCount() > 0) {
            echo "<h2>Channels for " . htmlspecialchars($view_date) . "</h2>";
            echo "<table border='1'>
                    <tr>
                        <th>Patient Number</th>
                        <th>Name</th>
                        <th>Date</th>
                     
                        <th>Note</th>
                    </tr>";
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['patient_number']) . "</td>
                        <td>" . htmlspecialchars($row['name']) . "</td>
                        <td>" . htmlspecialchars($row['c_date']) . "</td>
                   
                        <td>" . htmlspecialchars($row['c_note']) . "</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No channels found for this date.</p>";
        }
    }
    ?>
        </section>
    </div>

    <?php include("dounbr.php"); ?>

    <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>

    <?php include_once("script.php"); ?>

    <script>
        function click_open(i) {
            $(".popup").addClass("d-show");
            if (i == 1) {
                $("#from_text").text('Add New JOB');
                $("#job_form").attr('action', 'job_save.php');
            } else if (i == 2) {
                $("#from_text").text('Update JOB');
                $("#job_form").attr('action', 'job_update.php');
            }
        }
    </script>
</body>
</html>
