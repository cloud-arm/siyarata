<!DOCTYPE html>
<html>

<?php
include("head.php");
include_once("auth.php");
$r = $_SESSION['SESS_LAST_NAME'];
$_SESSION['SESS_DEPARTMENT'] = 'product';
$_SESSION['SESS_FORM'] = 'product_index';
?>

<body class="hold-transition skin-yellow skin-orange sidebar-collapse sidebar-mini">

    <?php include_once("start_body.php"); ?>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                PRODUCT
                <small>Preview</small>
            </h1>
        </section>
        <!-- Main content -->

        <section class="content">
            <?php
            date_default_timezone_set("Asia/Colombo");

            $currentDate = new DateTime();
            $currentDate->sub(new DateInterval('P30D'));
            $back30 = $currentDate->format('Y-m-d');
            $date =  date("Y-m-d");

            ?>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-3">

                    <div class="info-box">
                        <span class="info-box-icon"><i class="fa fa-cutlery"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Products</span>
                            <span class="info-box-number"><?php // echo $product_total; ?></span>
                            <div class="progress">
                                <div class="progress-bar" style="width: <?php // echo $active_product_total / $product_total * 100; ?>%"></div>
                            </div>
                            <span class="progress-description">
                                Total Products
                            </span>
                        </div>

                    </div>
                </div>

                <div class="col-xs-12 col-sm-6 col-md-3">

                    <div class="info-box">
                        <span class="info-box-icon"><i class="fa fa-file-text"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Sales</span>
                            <span class="info-box-number"><?php // echo $product_sales; ?></span>
                            <div class="progress">
                                <div class="progress-bar" style="width: <?php // echo $product_sales / $active_product_total * 100; ?>%"></div>
                            </div>
                            <span class="progress-description">
                                Last 30-days Sales
                            </span>
                        </div>

                    </div>
                </div>
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
echo "Date: " . $formattedDate . " - Channeling Count: " . $counts[$formattedDate] . "\n";
}
                ?>

                <div class="col-xs-12 col-sm-6 col-md-3">

                    <div class="info-box">
                        <span class="info-box-icon"><i class="fa-solid fa-hourglass-half"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text"><?php echo "COMING SOON"; ?> </span>
                            <span class="info-box-number"><?php echo '...'; ?></span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 0%"></div>
                            </div>
                            <span class="progress-description">
                                ...
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-6 col-md-3">

                    <div class="info-box">
                        <span class="info-box-icon"><i class="fa-solid fa-hourglass-half"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text"><?php echo "COMING SOON"; ?> </span>
                            <span class="info-box-number"><?php echo '...'; ?></span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 0%"></div>
                            </div>
                            <span class="progress-description">
                                ...
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BAR CHART -->
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Past Moving Food</h3>

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

    <!-- /.content-wrapper -->

    <?php include("dounbr.php"); ?>

    <div class="control-sidebar-bg"></div>
    </div>


    <?php include_once("script.php"); ?>

    <!-- ./wrapper -->
    <!-- ChartJS 1.0.1 -->
    <script src="../../plugins/chartjs/Chart.min.js"></script>
    <!-- FastClick -->
    <script src="../../plugins/fastclick/fastclick.js"></script>

    <script>
        $(function() {
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





        });
    </script>
</body>

</html>