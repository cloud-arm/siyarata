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
                    <span onclick="click_open(1)"  class="btn btn-primary btn-bg pull-right  mx-2">Add New JOB</span>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Company</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $result=select('job','*','action < 10'); for ($i = 0; $row = $result->fetch(); $i++) { ?>
                            <tr>
                                <td><?php echo $row['id']  ?></td>
                                <td><?php echo $row['name']  ?></td>
                                <td><?php echo $row['date']  ?></td>
                                <td><?php echo $row['status']  ?></td>
                                <td><a href="job_view.php?id=<?php echo base64_encode($row['id'])  ?>"><button class="btn btn-sm btn-info">View</button></a></td>
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
                        JOB SAVE
                    </h3>
                    <small onclick="click_close(1)" class="btn btn-sm btn-success pull-right"><i
                            class="fa fa-times"></i></small>
                </div>

                <div class="box-body d-block">
                    <form method="POST" action="save/job/job_save.php">

                        <div class="row" style="display: block;">



                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Company</label>
                                    <select class="form-control select2 hidden-search"
                                        name="company_id" style="width: 100%;" autofocus>
                                        <?php $result=select('company','*'); for ($i = 0; $row = $result->fetch(); $i++) {  ?>
                                        <option value="<?php echo $row['id']  ?>"><?php echo $row['name']  ?></option>
                                        <?php } ?>

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-10">
                                <div class="form-group">
                                    <label>Note</label>
                                    <textarea name="note" cols="70" rows="10" class="form-control"></textarea>
                                </div>
                            </div>

                           

                            

                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="hidden" name="unit" value="1">
                                    <input type="submit" style="margin-top: 23px; width: 100%;" value="Save"
                                        class="btn btn-info btn-sm pull-right">
                                </div>
                            </div>


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