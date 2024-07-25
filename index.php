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
     
            $month1 = date("Y-m-01");
            $month2 = date("Y-m-31");


        
            function select_date($table, $column) {
                $today = date('Y-m-d');
                $sql = "SELECT $column AS total FROM $table WHERE c_date >= '$today'";
                $result = select_query($sql);
                
                if ($result && $row = $result->fetch(PDO::FETCH_ASSOC)) {
                    return $row['total'];
                } else {
                    return 0;
                }
            }

    
            ?>
            

            <div class="row">
                <div class="col-sm-6 col-md-4 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon"><i class="fa fa-file-text"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">TOTAL PATIENS</span>
                            <span class="info-box-number"><?php echo select_item('new_patient','count(p_id)')  ?></span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 0%"></div>
                            </div>
                            <span class="progress-description">
                                 are avilablle
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-4 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon"><i class="glyphicon glyphicon-stats"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">TOTAL CHANNELINGS</span>
                            <span class="info-box-number"><?php echo select_item('channeling','count(c_id)')  ?></span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 50%"></div>
                            </div>
                            <span class="progress-description">
                            avilable
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-4 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon"><i class="glyphicon glyphicon-stats"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">UPCOMING CHANNELINGS</span>
                            <span class="info-box-number"><?php echo select_date('channeling', 'COUNT(c_id)'); ?></span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 50%"></div>
                            </div>
                            <span class="progress-description">
                              are avilable
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Channeling Details</h3>
                    <span onclick="click_open(1)" class="btn btn-primary btn-bg pull-right mx-2">Add New Channel</span>
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
                            $result = select('channeling', '*');

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
    </div>

    <?php
    $con = 'd-none';
    ?>

    <div class="container-up <?php echo $con; ?>" id="container_up">
        <div class="row w-50">
            <div class="box box-success popup" id="popup_1" style="width: 50%;">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        CHANNELING SAVE
                    </h3>
                    <small onclick="click_close(1)" class="btn btn-sm btn-success pull-right"><i class="fa fa-times"></i></small>
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
                                            <select id="location" name="location" class="form-control" required>
                                                 <option value="">Select location</option>
                                                <option value="kadawatha">Kadawatha</option>
                                                 <option value="Gampaha">Gampaha</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="d_type">Doctor Type</label>
                                            <select class="form-control" id="d_type" name="d_type" required>
                                            
                                                <option value="">Select Types of doctors</option>
                                                <option value="Gynecologist">Gynecologist</option>
                                                <option value="General practitioner">General practitioner</option>
                                                <option value="Allergist">Allergist</option>
                                                
                                                

                                            </select>
                                           
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-success pull-right">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    

    <div class="control-sidebar-bg"></div>
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
