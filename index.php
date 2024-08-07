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
                            <span
                                class="info-box-number"><?php echo select_item('patient','count(patient_id)') ?></span>
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
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Channel ID</th>
                                <th>Channeling number</th>
                                <th>Patient Name</th>
                                <th>Date</th>
                                <th>Note</th>
                                <th>Location</th>
                                <th>Illness Type</th>
                                <th>Treatment</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
            // Fetch channeling data from the database, sorted by the most recent entry first
            $result = select('channeling', '*', '', '');

            for ($i = 0; $row = $result->fetch(); $i++) { ?>
                            <tr>
                                <td><?php echo $row['id'] ?></td>
                                <td><?php echo $row['channeling_no'] ?></td>
                                <td><?php echo $row['name'] ?></td>
                                <td><?php echo $row['date'] ?></td>
                                <td><?php echo $row['note'] ?></td>
                                <td><?php echo $row['location'] ?></td>
                                <td><?php echo $row['type'] ?></td>
                                <td><?php echo $row['treatment'] == 1 ? 'Yes' : 'No'; ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

            </div>

        </section>
        <section class="content">
            <?php
            date_default_timezone_set("Asia/Colombo");

            $currentDate = new DateTime();
            $currentDate->sub(new DateInterval('P30D'));
            $back30 = $currentDate->format('Y-m-d');
            $date =  date("Y-m-d");

            ?>
            <div class="row">


                <?php
                    $sql = "
                    SELECT 
                        DATE(date) AS date, 
                        COUNT(date) AS channeling_count 
                    FROM 
                        channeling 
                    WHERE 
                        date >= CURDATE() 
                        AND date < CURDATE() + INTERVAL 30 DAY
                    GROUP BY 
                        DATE(date)
                    ORDER BY 
                        date
                    ";

                    // Execute the query using select_query function
                    $result = select_query($sql, ''); // Pass the path if necessary

                    // Fetch the results into an associative array
                    $counts = [];
                    if ($result) {
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        $counts[$row['date']] = $row['channeling_count'];
                    }
                    }

                    // Generate the date range from today to the next seven days
                    $today = new DateTime();
                    $interval = new DateInterval('P1D');
                    $period = new DatePeriod($today, $interval, 30);

                    // Ensure all dates in the range are represented
                    foreach ($period as $date) {
                    $formattedDate = $date->format('Y-m-d');
                    if (!isset($counts[$formattedDate])) {
                        $counts[$formattedDate] = 0;
                    }

                    }
                ?>




            </div>

            <!-- BAR CHART -->
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">CHANNELING SUMMARY</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="chart">
                        <canvas id="barChart" style="height: 350px"></canvas>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </section>
    </div>

    <?php
    $con = 'd-none';
    ?>

    <div class="container-up <?php echo $con; ?>" id="container_up">
        <div class="row justify-content-center">
            <div class="box box-success popup" id="popup_1"
                style="width: 100%; max-width: 600px; max-height: 90vh; overflow-y: auto;">
                <div class="box-header with-border">
                    <h3 class="box-title">CHANNELING SAVE</h3>
                    <small onclick="click_close(1)" class="btn btn-sm btn-success pull-right"><i
                            class="fa fa-times"></i></small>
                </div>






                <div class="box-body d-block">
                    <form method="POST" action="./save/channeling_save.php" onsubmit="return validateFormP()">
                        <div class="row" style="display: block;">


                        <div class="col-md-6">
                                <div class="form-group">
                                    <label for="patient_NIC">NIC</label>
                                    <input type="text" class="form-control" id="patient_NIC" onchange="find_patient(event)" name="patient_NIC"
                                        placeholder="Enter Patient NIC" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone_no">Phone no</label>
                                    <input type="text" class="form-control"  id="phone"
                                        name="patient_phone_no" placeholder="Phone No">
                                </div>
                            </div>

                           



                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="patient_name">Name</label>
                                    <input type="text" class="form-control" id="patient_name" name="patient_name"
                                        placeholder="Enter Patient Name">
                                </div>
                            </div>
                            <input type="hidden" class="form-control" id="patient_id" name="patient_id" value="0">




                            

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="patient_address">Address</label>
                                    <input type="text" class="form-control" id="patient_address" name="patient_address"
                                        placeholder="Enter Patient Address" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                <label for="location"></label>

                                </div>
                            </div>


                            

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="note">Note</label>
                                    <input type="text" class="form-control" id="note" name="note" placeholder="Note">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date">Date</label>
                                    <input type="text" class="form-control" id="datepicker" name="date"
                                        placeholder="Date" required autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="location">Location</label>
                                    <select id="location" name="location" class="form-control" required>
                                        <option value="">Select location</option>
                                        <option value="kadawatha">Kadawatha</option>
                                        <option value="pallekale">pallekale</option>
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
                                        <option value="<?php echo $row['name'] ?>"><?php echo $row['name'] ?></option>
                                        <?php  } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">

                                    <input class="form-check-input" type="checkbox" id="treatment" name="treatment"
                                        value="1">
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
    <?php include_once("script.php"); ?>

    <!-- /.control-sidebar -->
    <!-- ./wrapper -->
    <!-- ChartJS 1.0.1 -->
    <script src="../../plugins/chartjs/Chart.min.js"></script>
    <!-- FastClick -->
    <script src="../../plugins/fastclick/fastclick.js"></script>

    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    <script src="../../plugins/daterangepicker/daterangepicker.js"></script>
    <script src="../../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="../../plugins/fastclick/fastclick.js"></script>
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>

    <!-- Add the sidebar's background. This div must be placed

   immediately after the control sidebar -->

    <div class="control-sidebar-bg"></div>
    </div>





    <script>
    function find_patient(event) {
        var nic = document.getElementById('patient_NIC').value;
        

        var data = 'ur';
        fetch("patient_data.php?nic=" + nic)
            .then((response) => response.json())
            .then((json) => fill(json));
    }



    function fill(json) {
        console.log(json);

        if (json.action == "true") {
            console.log("old patient");
            document.getElementById('patient_name').value = json.patient_name;
            document.getElementById('patient_address').value = json.patient_address;
            document.getElementById('phone').value = json.patient_phone_no;
            document.getElementById('patient_id').value = json.patient_id;


            document.getElementById('patient_name').disabled = true;
            document.getElementById('patient_address').disabled = true;
            document.getElementById('phone').disabled = true;

            document.getElementById('patient_name').style= 'border: 1px solid #0cc40f';
            document.getElementById('patient_address').style= 'border: 1px solid #0cc40f';
            document.getElementById('phone').style= 'border: 1px solid #0cc40f';


        } else {
            console.log("new patient");
            document.getElementById('patient_name').value = '';
            document.getElementById('patient_address').value = '';
            document.getElementById('phone').value = '';
            document.getElementById('patient_id').value = '0';


            document.getElementById('patient_name').disabled = false;
            document.getElementById('patient_address').disabled = false;
            document.getElementById('phone').disabled = false;

            document.getElementById('patient_name').style= 'border: 1px solid ';
            document.getElementById('patient_address').style= 'border: 1px solid ';
            document.getElementById('phone').style= 'border: 1px solid ';

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
        $('#datepicker').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        });



        //-------------
        //- BAR CHART -
        //-------------

        var barChartData = {
            labels: [
                <?php
                    foreach ($period as $date) {
                        $formattedDate = $date->format('Y-m-d');
                       
                        echo '"'.$formattedDate.'",';
                    }
                    ?>
            ],
            datasets: [{
                label: "Rs.",
                pointStrokeColor: "#008000",
                pointHighlightFill: "#fff",
                data: [
                    <?php
                    foreach ($period as $date) {
                        $formattedDate = $date->format('Y-m-d');
                        if (!isset($counts[$formattedDate])) {
                            $counts[$formattedDate] = 0;
                        }
                        echo '"'.$counts[$formattedDate].'",';
                    }
                    ?>
                ]
            }],
        };

        var barChartCanvas = $("#barChart").get(0).getContext("2d");
        var barChart = new Chart(barChartCanvas);

        barChartData.datasets[0].fillColor = "rgb(80, 200, 120)";
        barChartData.datasets[0].strokeColor = "rgb(80, 200, 120)";
        barChartData.datasets[0].pointColor = "rgba(255, 102, 0, 1)";
        barChartData.datasets[0].pointHighlightStroke = "rgba(255, 102, 0, 1)";

        var barChartOptions = {
            //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
            scaleBeginAtZero: true,
            //Boolean - Whether grid lines are shown across the chart
            scaleShowGridLines: true,
            //String - Colour of the grid lines
            scaleGridLineColor: "rgba(0,0,0,.05)",
            //Number - Width of the grid lines
            scaleGridLineWidth: 1,
            //Boolean - Whether to show horizontal lines (except X axis)
            scaleShowHorizontalLines: true,
            //Boolean - Whether to show vertical lines (except Y axis)
            scaleShowVerticalLines: true,
            //Boolean - If there is a stroke on each bar
            barShowStroke: true,
            //Number - Pixel width of the bar stroke
            barStrokeWidth: 2,
            //Number - Spacing between each of the X value sets
            barValueSpacing: 5,
            //Number - Spacing between data sets within X values
            barDatasetSpacing: 1,
            //String - A legend template
            legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
            //Boolean - whether to make the chart responsive
            responsive: true,
            maintainAspectRatio: true,
        };

        barChartOptions.datasetFill = false;
        barChart.Bar(barChartData, barChartOptions);

        var color = ["rgba(255, 100, 0, 1)", "rgba(255, 75, 0, 1)", "rgba(255, 50, 0, 1)"];



        $("#example1").DataTable();

    });
    </script>





</body>

</html>