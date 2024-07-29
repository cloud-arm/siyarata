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
                $sql = "SELECT $column AS total FROM $table WHERE date >= '$today'";
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
                            <span class="info-box-text">TOTAL PATIENTS</span>
                            <span class="info-box-number"><?php echo select_item('patient','count(patient_id)') ?></span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 0%"></div>
                            </div>
                            <span class="progress-description">are available</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-4 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon"><i class="glyphicon glyphicon-stats"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">TOTAL CHANNELINGS</span>
                            <span class="info-box-number"><?php echo select_item('channeling','count(id)') ?></span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 50%"></div>
                            </div>
                            <span class="progress-description">available</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-4 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon"><i class="glyphicon glyphicon-stats"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">UPCOMING CHANNELINGS</span>
                            <span class="info-box-number"><?php echo select_date('channeling', 'COUNT(id)'); ?></span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 50%"></div>
                            </div>
                            <span class="progress-description">are available</span>
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
                    <table id="example1"  class="table table-bordered table-striped">
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
                                    <td><?php echo $row['id'] ?></td>
                                    <td><?php echo $row['name'] ?></td>
                                    <td><?php echo $row['date'] ?></td>
                                    <td><?php echo $row['note'] ?></td>
                                    <td><?php echo $row['location'] ?></td>
                                    <td><?php echo $row['type'] ?></td>
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
        <div class="row justify-content-center">
            <div class="box box-success popup" id="popup_1" style="width: 100%; max-width: 600px; max-height: 90vh; overflow-y: auto;">
                <div class="box-header with-border">
                    <h3 class="box-title">CHANNELING SAVE</h3>
                    <small onclick="click_close(1)" class="btn btn-sm btn-success pull-right"><i class="fa fa-times"></i></small>
                </div>

               
     

                   
                        
                        <div class="box-body d-block">
                            <form method="POST" action="./save/channeling_save.php" onsubmit="return validateFormP()">
                                <div class="row" style="display: block;">

                                <div class="col-md-12">
                            <div class="form-group">
                                 <label for="phone_no">Phone no</label>
                                <input type="text" class="form-control" onchange="find_patient(event)" id="phone" name="patient_phone_no" placeholder="Phone No">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                            <label for="patient_name">Name</label>
                            <input type="text" class="form-control" id="patient_name" name="patient_name" placeholder="Enter Patient Name">
                            </div>
                        </div>

                                <div class="col-md-12">
                                 <div class="form-group">
                                <label for="patient_NIC">NIC</label>
                                <input type="text" class="form-control" id="patient_NIC" name="patient_NIC" placeholder="Enter Patient NIC">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="patient_address">Address</label>
                                <input type="text" class="form-control" id="patient_address" name="patient_address" placeholder="Enter Patient Address">
                            </div>
                        </div>

                        

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="date">Date</label>
                                            <input type="date" class="form-control" id="date" name="date" placeholder="Date" required>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="note">Note</label>
                                            <input type="text" class="form-control" id="note" name="note" placeholder="Note">
                                        </div>
                                    </div>



                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="location" >Location</label>
                                            <select id="location" name="location" class="form-control"  required>
                                                <option value="">Select location</option>
                                                <option value="kadawatha">Kadawatha</option>
                                                <option value="Gampaha">Gampaha</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="type">illness Type</label>
                                            <select class="form-control" id="type" name="type" required>
                                            <option value="">Select illness</option>
                                            <?php
                                            

                                            $queryresult = select("illness");

                                            foreach($queryresult as $row) {
                                              //  echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                                            
                                            ?>
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                                            <?php  } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            
                                                <input class="form-check-input" type="checkbox" id="treatment" name="channeling_checkbox">
                                                <label class="form-check-label" for="channeling_checkbox">
                                                     click hear this is treatment
                                                </label>
                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-success pull-right">Save</button>
                                </div>
                            </form>
                        </div>
                    
               
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

    function find_patient(event){
        var phone = document.getElementById('phone').value;
console.log(phone);

    var data='ur';
    fetch("patient_data.php?phone_no="+phone)
  .then((response) => response.json())
  .then((json) => fill(json));
    }



    function fill(json) {
    console.log(json);  

    if(json.action == "true"){
console.log("old patient");
    document.getElementById('patient_name').value = json.patient_name;
    document.getElementById('patient_address').value = json.patient_address;
    document.getElementById('patient_NIC').value = json.patient_NIC;
    document.getElementById('patient_id').value = json.p_id;


    document.getElementById('patient_name').disabled = true;
    document.getElementById('patient_address').disabled = true;
    document.getElementById('patient_NIC').disabled = true;
    

}else{
    console.log("new patient");
    document.getElementById('patient_name').value = '';
    document.getElementById('patient_address').value = '' ;
    document.getElementById('patient_NIC').value =  '';
    document.getElementById('patient_id').value = '0';
  

    document.getElementById('patient_name').disabled = false ;
    document.getElementById('patient_address').disabled = false;
    document.getElementById('patient_NIC').disabled = false;
   
}
}








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

        function handleChange(event) {
            alert('Text input changed to: ' + event.target.value);
        }

        function handleSelectChange(event) {
            alert('Selected option: ' + event.target.value);
        }

        $(function() {
      $("#example1").DataTable();
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false
      });
    });

    </script>

<!-- ./wrapper -->
<!-- ChartJS 1.0.1 -->
<script src="../../plugins/chartjs/Chart.min.js"></script>
<!-- FastClick -->
<script src="../../plugins/fastclick/fastclick.js"></script>



</body>
</html>
