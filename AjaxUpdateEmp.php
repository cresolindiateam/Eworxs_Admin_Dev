<?php
ini_set('date.timezone', 'Asia/Kolkata'); 
require 'dbconfig.php';
 
$db = db_connect();
// sql to delete a record
if(isset($_REQUEST['editclientid']))
{
  $id=$_REQUEST['editclientid'];
   $sql = "SELECT id,company_id,first_name,last_name,email,phone,password,local_address,permanent_address,postal_code,status,created_at,work_rate,mileage_rate FROM workers WHERE  id= $id";

   $exe = $db->query($sql);
  $data = $exe->fetch_all(MYSQLI_ASSOC);
 $first_name = $data[0]['first_name'];
$last_name = $data[0]['last_name'];
$email = $data[0]['email'];
$phone = $data[0]['phone'];
$password = $data[0]['password'];

$phone = $data[0]['phone'];
$local_address = $data[0]['local_address'];
$status = $data[0]['status']; 
$work_rate = $data[0]['work_rate']; 
$mileage_rate =$data[0]['mileage_rate']; 
$permanent_address=$data[0]['permanent_address'];
$postal_code=$data[0]['postal_code'];

$status=$data[0]['status'];
$company_id=$data[0]['company_id'];

$data1= array("firstName"=>$first_name,"lastName"=>$last_name,"email"=>$email,"phone"=>$phone,"password"=>$password,"local_address"=>$local_address,"status"=>$status, "work_rate"=>$work_rate,"mileage_rate"=>$mileage_rate , 
"permanent_address"=>$permanent_address,"postal_code"=>$postal_code,"status"=>$status,"company_id"=>$company_id);


echo json_encode($data1);
}

?>