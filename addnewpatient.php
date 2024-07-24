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

        <form action="patientadd_cont.php" method="post" onsubmit="return validateFormP()">
        <h1>Add patient</h1>
        <label for="p_name">Name</label>
        <input type="text" id="p_name" name="p_name" placeholder="name" required>

        <label for="p_phone_no">Mobile No</label>
        <input type="text" id="p_phone_no" name="p_phone_no" placeholder="User Mobile No" required>

        <label for="p_NIC">NIC</label>
        <input type="text" id="p_NIC" name="p_NIC" placeholder="NIC" required>

        <label for="p_address">Address</label>
        <input type="text" id="p_address" name="p_address" placeholder="Address" required>

        <input type="submit" value="Save" name="send">
    </form>

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
