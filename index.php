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






            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Patient Information</h3>
                    <span onclick="click_open(1)" class="btn btn-primary btn-bg pull-right mx-2">Add New channeling</span>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Patient ID</th>
                                <th>Name</th>
                                <th>Phone No</th>
                                <th>NIC</th>
                                <th>Address</th>
                              
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Fetch patient data from the database
                            $result = select('new_patient', '*', '', '');
                            for ($i = 0; $row = $result->fetch(); $i++) { ?>
                                <tr>
                                    <td><?php echo $row['p_id'] ?></td>
                                    <td><?php echo $row['p_name'] ?></td>
                                    <td><?php echo $row['p_phone_no'] ?></td>
                                    <td><?php echo $row['p_NIC'] ?></td>
                                    <td><?php echo $row['p_address'] ?></td>
                                 
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <a href="addnewpatient.php" class="btn btn-success">Add New Patient</a>
                    <a href="addchannel.php" class="btn btn-success">Add New channeling</a>
                   
                    <a href="display_channels.php" class="btn btn-info">Display Channels</a>
                </div>
            </div>

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
