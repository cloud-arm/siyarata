<?php

include_once("../config.php"); 



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //echo "test 12";
    //  if (isset($_POST['patient_name'], $_POST['patient_NIC'], $_POST['patient_address'], $_POST['patient_id'], $_POST['date'], $_POST['location'], $_POST['note'], $_POST['type'], $_POST['patient_phone_no'])) {
       

    $patient_id = $_POST['patient_id'];

    //$c_id = $_POST['c_id'];
    $date = $_POST['date'];
    $location = $_POST['location'];
    $note = $_POST['note'];
    $type = $_POST['type']; 
    $name = ['name'];
    $channeling_checkbox = isset($_POST['treatment']) ? 1 : 0;
  
    $save_date = date("Y-m-d H:i:s");  
   // $treatment = $_POST['treatment'];
   

 $insert_out=[];

   if ($patient_id == 0) {

        $patient_name = $_POST['patient_name']; 
        $patient_phone_no = $_POST['patient_phone_no'];   
        $patient_NIC = $_POST['patient_NIC'];   
        $patient_address = $_POST['patient_address']; 
        
        //echo "test 1";
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
          
        
        $new_number=select_item('patient','patient_id',"patient_NIC = '$patient_NIC'",'../');
       
     }else{
      
        $new_number=$patient_id;
        $patient_name = select_item("patient","patient_name","patient_id=$patient_id","../");
       

     }
     $channeling_no = select_item("channeling", "count(id)", "date = '$date' AND location = '$location'", "../");
     $channeling_no = $channeling_no + 1;

    
    

     $location_p = "";
     if ($location == "kadawatha") {
        $location_p = "KA";
     } elseif ($location == "pallekale") {
        $location_p = "PA";
     }
     //$date_part = date("Ymd", strtotime($date));

     //$last_number = select_query("SELECT COUNT(id) AS count FROM channeling WHERE location = '$location' AND date = '$date'", '../');
     $last_number = $location_p.$channeling_no;



        $insertData = array(
            "data" => array(
                "name" => $patient_name,
                "date" => $date,
                "location" => $location,
                "note" => $note,
                "patient_number" => $new_number,
                "type" => $type,
                "save_date" => $save_date,
                "channeling_no" => $last_number,
                "treatment" => $channeling_checkbox,
            ),
            "other" => array(),
        );
       



           // $result = select_query("SELECT patient_name, patient_NIC, patient_address FROM patient", "../");




        $insert_out =insert("channeling", $insertData, '../');
        if($location=='pallekale'){
            $plase="SIYARATA MUHANDIRAM HOSPITAL - Pallekale";
        }

        if($location=='kadawatha'){
            $plase="INDRA HOTEL - KADAWATHA";
        }
           // echo json_encode($insert_out);
        $masage="TRADITIONAL DR. RANJAN MUHANDIRAM  [patient:".$patient_name."  Date:".$date."  App_No:".$last_number." Place:".$plase."]";


        $phone=select_item("patient","patient_phone_no","patient_id=$new_number","../");

       print( sms($phone,$masage));
            
            //echo '<script>alert("Patient successfully recorded in channeling with number ");</script>';
          //  echo "<script>location.href='../index.php';</script>";
        
  
} 