<!DOCTYPE html>
<html>
<?php
include("head.php");
?>

<body class="hold-transition skin-blue skin-orange sidebar-mini">
    <div class="wrapper">
        <?php
        include_once("auth.php");
        $r = $_SESSION['SESS_LAST_NAME'];
        $_SESSION['SESS_FORM'] = 'report';

        if ($r == 'admin') {
            include_once("sidebar.php");
        }
        ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>Patient Report<small>Preview</small></h1>
            </section>

            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Date Selector</h3>
                        </div>
                        <div class="box-body">
                            <form action="" method="GET">
                                <div class="row" style="margin-bottom: 20px; display: flex; align-items: end;">
                                    <div class="col-lg-1"></div>
                                    <div class="col-lg-8">
                                        <label>Date range:</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control pull-right" id="reservation" name="dates" value="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type="submit" class="btn btn-info" value="Apply">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php
        
            date_default_timezone_set("Asia/Colombo");

            if (isset($_GET['dates'])) {
                $dates = $_GET['dates'];
                $d1 = date_format(date_create(explode(" - ", $dates)[0]), "Y-m-d");
                $d2 = date_format(date_create(explode(" - ", $dates)[1]), "Y-m-d");

            

                // Fetch channeling data
               // $channeling_where = "date BETWEEN '$d1' AND '$d2'";
                //$channeling_result = select('channeling', '*', $channeling_where);
                //("SELECT * FROM sales WHERE dll=0 AND date BETWEEN '$d1' AND '$d2'  ")
                //"SELECT * FROM chanel WHERE date = ? ORDER BY patient_number"

                $channeling_result = select_query("SELECT * FROM channeling WHERE date BETWEEN '$d1' AND '$d2' ");
            }
            ?>

            <section class="content">
              

                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Channeling Details</h3>
                    </div>
                    <div class="box-body">
                        <table id="example2" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>name</th>
                                   
                                    <th>location</th>
                                    <th>illness</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($channeling_result)) {
                                    while ($row = $channeling_result->fetch()) {
                                ?>
                                        <tr>
                                            <td><?php echo $row['date']; ?></td>
                                            <td><?php echo $row['name']; ?></td>
                                            
                                            <td><?php echo $row['location']; ?></td>
                                            <td><?php echo $row['type']; ?></td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
        <?php include("dounbr.php"); ?>
        <div class="control-sidebar-bg"></div>
    </div>

    <?php include_once("script.php"); ?>
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    <script src="../../plugins/daterangepicker/daterangepicker.js"></script>
    <script src="../../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="../../plugins/fastclick/fastclick.js"></script>
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>

    <script>
        function invo_dll() {
            if (confirm("Sure you want to delete this Invoice? There is NO undo!")) {
                $('#sales_dll').submit();
            }
            return false;
        }

        $(function() {
            $("#example1").DataTable();
            $("#example2").DataTable();

            $('#reservation').daterangepicker();
            $('#datepicker').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });
        });
    </script>
</body>
</html>
