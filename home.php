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

    <h1>Patient Information</h1>
    <table>
        <tr>
            <th>Patient ID</th>
            <th>Name</th>
            <th>Phone No</th>
            <th>NIC</th>
            <th>Address</th>

        </tr>
        
        <?php
        // Include the select function
     
        

        // Fetch patient data from the database
        $result = select('new_patient', '*', '', '');

        for ($i = 0; $row = $result->fetch(); $i++) {
        ?>
            <tr>
                <td><?php echo $row['p_id'] ?></td>
                <td><?php echo $row['p_name'] ?></td>
                <td><?php echo $row['p_phone_no'] ?></td>
                <td><?php echo $row['p_NIC'] ?></td>
                <td><?php echo $row['p_address'] ?></td>
                <td><button><a href="deletepatient.php?pid=<?php echo $row['p_id'] ?>" onclick="return confirm('Are you sure you want to delete this patient?')">Delete</a></button></td>
                
            </tr>
        <?php } ?>
    </table>
    <button><a href="addnewpatian.php">add new patient</a></button>
    <button><a href="addchannel.php">add new chanel</a></button>
    <button><a href="display_chanels.php">display chanels</a></button>
    
</body>
</html>
