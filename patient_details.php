<!DOCTYPE html>

<html>

<?php
include("head.php");
include_once("auth.php");
$r = $_SESSION['SESS_LAST_NAME'];
$_SESSION['SESS_DEPARTMENT'] = 'management';
$_SESSION['SESS_FORM'] = 'patient_details';
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
                    <h3 class="box-title">Patient list</h3>
                    <span onclick="click_open(1)"  class="btn btn-primary btn-bg pull-right  mx-2">Add New patient</span>
                    <table id="example1" class="table table-bordered table-striped">
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
                            $result = select('patient', '*', '', '');
                            for ($i = 0; $row = $result->fetch(); $i++) { ?>
                                <tr>
                                    <td><?php echo $row['patient_id'] ?></td>
                                    <td><?php echo $row['patient_name'] ?></td>
                                    <td><?php echo $row['patient_phone_no'] ?></td>
                                    <td><?php echo $row['patient_NIC'] ?></td>
                                    <td><?php echo $row['patient_address'] ?></td>
                                 
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <!-- Main content -->
                </div>
            </div>



        </section>


    </div>


    <?php
    $con = 'd-none';
    ?>

    <div class="container-up <?php echo $con; ?>" id="container_up" >
        <div class="row w-50">
            <div class="box box-success popup" id="popup_1" style="width: 50%;">
                <div class="box-header with-border">
                    <h3 class="box-title">
                            PATIENT SAVE
                    </h3>
                    <small onclick="click_close(1)" class="btn btn-sm btn-success pull-right"><i
                            class="fa fa-times"></i></small>
                </div>

              
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Add Patient</h3>
        </div>
        <div class="box-body d-block">
            <form method="post" action="./save/patientadd_cont.php" onsubmit="return validateFormP()">
                <div class="row" style="display: block;">

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="patient_name">Name</label>
                            <input type="text" class="form-control" id="patient_name" name="patient_name" placeholder="Name" required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="patient_phone_no">Mobile No</label>
                            <input type="text" class="form-control" id="patient_phone_no" name="patient_phone_no" placeholder="Mobile No" required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="patient_NIC">NIC</label>
                            <input type="text" class="form-control" id="patient_NIC" name="patient_NIC" placeholder="NIC" required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="patient_address">Address</label>
                            <input type="text" class="form-control" id="patient_address" name="patient_address" placeholder="Address" required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="submit" class="btn btn-info btn-sm pull-right" value="Save" name="send" style="margin-top: 23px; width: 100%;">
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</section>




                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-wrapper -->

    <?php include("dounbr.php"); ?>

    <!-- /.control-sidebar -->

    <!-- Add the sidebar's background. This div must be placed

       immediately after the control sidebar -->

    <div class="control-sidebar-bg"></div>
    </div>


    <?php include_once("script.php"); ?>
    <script>
                function click_open(i) {
            $(".popup").addClass("d-none");
            $("#popup_" + i).removeClass("d-none");
            $("#container_up").removeClass("d-none");
        }

     function click_close(i) {
            if (i) {
                $(".popup").addClass("d-none");
                $("#container_up").addClass("d-none");
            } else {
                $(".popup").addClass("d-none");
                $("#popup_1").removeClass("d-none");
            }
        }
    </script>

    <!-- ./wrapper -->
    <!-- ChartJS 1.0.1 -->
    <script src="../../plugins/chartjs/Chart.min.js"></script>
    <!-- FastClick -->
    <script src="../../plugins/fastclick/fastclick.js"></script>



</body>

</html>