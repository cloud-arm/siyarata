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

        <form action="channeling_cont.php" method="post" onsubmit="return validateFormP()">
        <h1>Add chanel</h1>
        <label for="name">Name</label>
        <select id="name" name="name" required>
            <option value="">Select Patient</option>
            <?php
            include 'connect.php';

            $queryresult = select('new_patient', '*', '', '');

            foreach($queryresult as $row) {
                echo "<option value='" . $row['p_name'] . "'>" . $row['p_name'] . "</option>";
            }
            ?>
        </select>

        <label for="c_date">date</label>
        <input type="date" id="c_date" name="c_date" placeholder="date" required>



        <label for="c_note">note</label>
        <input type="text" id="c_note" name="c_note" placeholder="note" required>

        <label for="location">Location</label>
        <select id="location" name="location" required>
            <option value="">Select location</option>
            <option value="Colombo">Kadawatha</option>
            <option value="Gampaha">Gampaha</option>
        </select>

        <label for="d_type">Types of doctors</label>
        <select id="d_type" name="d_type" required>
            <option value="">Select Types of doctors</option>
            <option value="Gynecologist">Gynecologist</option>
            <option value="General practitioner">General practitioner</option>
            <option value="Allergist">Allergist</option>
            
            

        </select>
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
