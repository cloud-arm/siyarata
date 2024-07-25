<!DOCTYPE html>

<html>

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
            <?php

            include('connect.php');
            date_default_timezone_set("Asia/Colombo");
            $cash = $_SESSION['SESS_FIRST_NAME'];
            $date =  date("Y-m-d");
            $result = $db->prepare("SELECT sum(profit) FROM sales WHERE    date='$date' ");
            $result->bindParam(':userid', $date);
            $result->execute();
            for ($i = 0; $row = $result->fetch(); $i++) {
                $profit = $row['sum(profit)'];
            }

            $result = $db->prepare("SELECT sum(amount) FROM sales WHERE  dll=0 AND  date='$date'  ");
            $result->bindParam(':userid', $date);
            $result->execute();
            for ($i = 0; $row = $result->fetch(); $i++) {
                $sales_total = $row['sum(amount)'];
            }

            $result = $db->prepare("SELECT sum(amount) FROM sales WHERE  dll=0 AND    date='$date' AND customer_name='NO' ");
            $result->bindParam(':userid', $date);
            $result->execute();
            for ($i = 0; $row = $result->fetch(); $i++) {
                $dr_amount = $row['sum(amount)'];
            }

            $month1 = date("Y-m-01");
            $month2 = date("Y-m-31");

            date_default_timezone_set("Asia/Colombo");
            $date = date("Y-m-d");
            $result = $db->prepare("SELECT count(transaction_id) FROM sales WHERE  date='$date' ORDER by transaction_id DESC ");
            $result->bindParam(':userid', $date);
            $result->execute();
            for ($i = 0; $row = $result->fetch(); $i++) {
                $job_count = $row['count(transaction_id)'];
            }

            $date = date("Y-m-d");


            $result = $db->prepare("SELECT * FROM cash WHERE id = 1 ");
            $result->bindParam(':userid', $res);
            $result->execute();
            for ($i = 0; $row = $result->fetch(); $i++) {
                $petty_blc = $row['amount'];
                $petty_name = $row['name'];
            }

            $result = $db->prepare("SELECT * FROM cash WHERE id = 2 ");
            $result->bindParam(':userid', $res);
            $result->execute();
            for ($i = 0; $row = $result->fetch(); $i++) {
                $main_blc = $row['amount'];
                $main_name = $row['name'];
            }
            ?>


            <div class="row">
                <div class="col-sm-6 col-md-4 col-xs-12">

                    <div class="info-box">
                        <span class="info-box-icon"><i class="fa fa-file-text"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Invoice</span>
                            <span class="info-box-number">Rs.<?php echo $sales_total; ?></span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 0%"></div>
                            </div>
                            <span class="progress-description">
                                Today Sales Total
                            </span>
                        </div>

                    </div>
                </div>

                <div class="col-sm-6 col-md-4 col-xs-12">

                    <div class="info-box">
                        <span class="info-box-icon"><i class="glyphicon glyphicon-stats"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text"><?php echo $main_name; ?></span>
                            <span class="info-box-number">Rs.<?php echo $main_blc; ?></span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 50%"></div>
                            </div>
                            <span class="progress-description">
                                Account Balance
                            </span>
                        </div>

                    </div>
                </div>

                <div class="col-sm-6 col-md-4 col-xs-12">

                    <div class="info-box">
                        <span class="info-box-icon"><i class="glyphicon glyphicon-stats"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text"><?php echo $petty_name; ?> </span>
                            <span class="info-box-number">Rs.<?php echo $petty_blc; ?></span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 50%"></div>
                            </div>
                            <span class="progress-description">
                                Account Balance
                            </span>
                        </div>

                    </div>
                </div>
            </div>


            
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">JOB LIST</h3>
                    <span onclick="click_open(1)"  class="btn btn-primary btn-bg pull-right  mx-2">Add New channeling</span>
                    <table id="example1" class="table table-bordered table-striped">
                    <section class="content">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Channeling Details</h3>
        </div>
        <div class="box-body">
            <table id="channelingTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Channel ID</th>
                        <th>Patient Name</th>
                        <th>Date</th>
                        <th>Note</th>
                        <th>Location</th>
                        <th>Doctor Type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch channeling data from the database, sorted by the most recent entry first
                    $result = select('channeling', '*', '', '', 'c_id DESC');

                    for ($i = 0; $row = $result->fetch(); $i++) { ?>
                        <tr>
                            <td><?php echo $row['c_id'] ?></td>
                            <td><?php echo $row['name'] ?></td>
                            <td><?php echo $row['c_date'] ?></td>
                            <td><?php echo $row['c_note'] ?></td>
                            <td><?php echo $row['location'] ?></td>
                            <td><?php echo $row['d_type'] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>


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
                        JOB SAVE
                    </h3>
                    <small onclick="click_close(1)" class="btn btn-sm btn-success pull-right"><i
                            class="fa fa-times"></i></small>
                </div>

                <section class="content">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Add Channel</h3>
        </div>
        <div class="box-body d-block">
            <form method="POST" action="./save/channeling_save.php" onsubmit="return validateFormP()">
                <div class="row" style="display: block;">

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <select class="form-control" id="name" name="name" required>
                                <option value="">Select Patient</option>
                                <?php
                                include 'connect.php';

                                $queryresult = select('new_patient', '*', '', '');

                                foreach($queryresult as $row) {
                                    echo "<option value='" . $row['p_name'] . "'>" . $row['p_name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="c_date">Date</label>
                            <input type="date" class="form-control" id="c_date" name="c_date" placeholder="Date" required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="c_note">Note</label>
                            <input type="text" class="form-control" id="c_note" name="c_note" placeholder="Note" required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="location">Location</label>
                            <select class="form-control" id="location" name="location" required>
                                <option value="">Select Location</option>
                                <option value="Colombo">Kadawatha</option>
                                <option value="Gampaha">Gampaha</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="d_type">Types of Doctors</label>
                            <select class="form-control" id="d_type" name="d_type" required>
                                <option value="">Select Types of Doctors</option>
                                <option value="Gynecologist">Gynecologist</option>
                                <option value="General practitioner">General Practitioner</option>
                                <option value="Allergist">Allergist</option>
                            </select>
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