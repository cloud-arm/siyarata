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
                    $currentDate = new DateTime();
                    $currentDate->sub(new DateInterval('P30D'));
                    $back30 = $currentDate->format('Y-m-d');
                    $date =  date("Y-m-d");

                    $result = select_query("SELECT sales_list.name AS pro_name FROM sales_list JOIN products ON sales_list.product_id = products.id WHERE products.type = 'dish'  AND products.stock_action = 0  AND (sales_list.date BETWEEN '$back30' AND '$date') GROUP BY sales_list.product_id ORDER BY sum(sales_list.qty) DESC LIMIT 30 ");
                    for ($i = 0; $row = $result->fetch(); $i++) {
                        echo '"' . $row['pro_name'] . '",';
                    }
                    ?>
                ],
                datasets: [{
                    label: "Rs.",
                    pointStrokeColor: "#c1c7d1",
                    pointHighlightFill: "#fff",
                    data: [
                        <?php
                        $currentDate = new DateTime();
                        $currentDate->sub(new DateInterval('P30D'));
                        $back30 = $currentDate->format('Y-m-d');
                        $date =  date("Y-m-d");

                        $result = select_query("SELECT sum(sales_list.qty) FROM sales_list JOIN products ON sales_list.product_id = products.id WHERE products.type = 'dish'  AND products.stock_action = 0  AND (sales_list.date BETWEEN '$back30' AND '$date') GROUP BY sales_list.product_id ORDER BY sum(sales_list.qty) DESC LIMIT 30 ");
                        // $result = select("sales_list", "sum(qty)", "date BETWEEN '$back30' AND '$date' GROUP BY product_id ORDER BY qty DESC LIMIT 15 ");
                        for ($i = 0; $row = $result->fetch(); $i++) {
                            echo '"' . $row['sum(sales_list.qty)'] . '",';
                        }
                        ?>
                    ]
                }],
            };

            var barChartCanvas = $("#barChart").get(0).getContext("2d");
            var barChart = new Chart(barChartCanvas);

            barChartData.datasets[0].fillColor = "rgba(255, 102, 0, 1)";
            barChartData.datasets[0].strokeColor = "rgba(255, 102, 0, 1)";
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

            var lineChartData = {
                labels: [
                    <?php
                    $i = 7;
                    $currentDate = new DateTime();
                    while ($i > 0) {
                        $date = clone $currentDate;
                        $date->modify("-$i days");
                        echo '"' . $date->format('M d')  . '",';
                        $i--;
                    }
                    ?>
                ],
                datasets: [
                    <?php
                    $currentDate = new DateTime();
                    $currentDate->sub(new DateInterval('P7D'));
                    $back30 = $currentDate->format('Y-m-d');
                    $date =  date("Y-m-d");

                    $result = select_query("SELECT sales_list.name AS pro_name,sales_list.product_id AS pro_id FROM sales_list JOIN products ON sales_list.product_id = products.id WHERE products.type = 'dish' AND products.stock_action = 0 AND sales_list.date BETWEEN '$back30' AND '$date' GROUP BY sales_list.product_id ORDER BY sum(sales_list.amount) DESC LIMIT 3 ");
                    for ($i = 0; $row = $result->fetch(); $i++) {
                    ?> {
                            label: <?php echo '"' . $row['pro_name'] . '"'; ?>,
                            fillColor: color[<?php echo $i; ?>],
                            strokeColor: color[<?php echo $i; ?>],
                            pointColor: color[<?php echo $i; ?>],
                            pointStrokeColor: "#fff",
                            pointHighlightFill: color[<?php echo $i; ?>],
                            pointHighlightStroke: color[<?php echo $i; ?>],
                            data: [
                                <?php
                                $x = 7;
                                $currentDate = new DateTime();
                                while ($x > 0) {
                                    $day = clone $currentDate;
                                    $day->modify("-$x days");
                                    $day = $day->format('Y-m-d');

                                    $result1 = select("sales_list", "amount", "product_id = '" . $row['pro_id'] . "' AND date  = '" . $day . "' ");
                                    for ($k = 0; $row1 = $result1->fetch(); $k++) {
                                        echo '"' . $row1['amount'] . '",';
                                    }
                                    $x--;
                                }
                                ?>
                            ],
                        },
                    <?php
                    }
                    ?>
                ],
            };


            var lineChartCanvas = $("#lineChart").get(0).getContext("2d");
            var lineChart = new Chart(lineChartCanvas);

            barChartOptions.datasetFill = false;
            lineChart.Bar(lineChartData, barChartOptions);
        });
    </script>
</body>

</html>