<?php

include_once("../config.php"); 



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $patient_id = $_POST['patient_id'] ?? 0;

    //$c_id = $_POST['c_id'];
    $date = $_POST['date'];
    $location = $_POST['location'];
    $note = $_POST['note'];
    $type = $_POST['type'];
    $patient_name = $_POST['patient_name'];
    $patient_phone_no = $_POST['patient_phone_no'];
    $patient_NIC = $_POST['patient_NIC'];
    $patient_address = $_POST['patient_address'];
    $save_date = date("Y-m-d H:i:s");
   // $treatment = $_POST['treatment'];

$insert_out=[];

    if ($patient_id == 0) {
        
        
        $insertData = array(
            "data" => array(
                "patient_name" => $patient_name,
                "patient_phone_no" => $patient_phone_no,
                "patient_NIC" => $patient_NIC,
                "patient_address" => $patient_address,
              //  "save_date" => $save_date,
               // "treatment" => $treatment,
            ),
            "other" => array(),
        );
        

        $insert_out =insert("patient", $insertData, '../');
            //echo '<script>alert("Patient successfully recorded in patient");</script>';
        //echo json_encode($insert_out);
          
        
        $new_number=select_item('patient','patient_id',"patient_phone_no = '$patient_phone_no'",'../');
    }else{
        $new_number=$patient_id;
    }


        $insertData = array(
            "data" => array(
                "name" => $patient_name,
                "date" => $date,
                "location" => $location,
                "note" => $note,
                "patient_number" => $new_number,
                "type" => $type,
                "save_date" => $save_date,
                //"treatment" => $treatment,
            ),
            "other" => array(),
        );

        if (insert("channeling", $insertData, '../')) {
            echo '<script>alert("Patient successfully recorded in channeling with number ");</script>';
           echo "<script>location.href='../index.php';</script>";
        }




  
    
}
?>
