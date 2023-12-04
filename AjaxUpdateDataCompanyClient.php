<?php
ini_set('date.timezone', 'Asia/Kolkata');
require 'dbconfig.php';
session_start();
if($_SESSION['username']==""){
echo "<script> window.location = 'admin_login.php';</script>";
}
if($_SESSION['role']==1){
  echo "<script> window.location = 'admin_login.php';</script>";
}
if($_SERVER['REQUEST_METHOD'] === 'POST') {

$db = db_connect();
$id = $_REQUEST['id'];
$first_name = $_REQUEST['editfirstName'];
$last_name = $_REQUEST['editlastName'];
$email = $_REQUEST['editemail'];
$phone = $_REQUEST['editphone'];
$password = $_REQUEST['editpassword'];
$password = password_hash($password, PASSWORD_DEFAULT);
$company_name = $_REQUEST['editcompanyName'];
$status_data = $_REQUEST['editstatus']; 
$work_rate = $_REQUEST['editworkRate']; 
$mileage_rate =$_REQUEST['editmileageRate']; 
$due_date_range=$_REQUEST['editdateRange'];
$postal_code=$_REQUEST['editpostalCode'];
$office_address=$_REQUEST['editofficeAddress'];
$status_data=$_REQUEST['editstatus'];
$company_id=$_REQUEST['editcompany'];
$clock=$_REQUEST['editclock'];
$editreturnMileage=$_REQUEST['editreturnMileage'];
$data1= array("first_name"=>$first_name,"last_name"=>$last_name,"email"=>$email,"phone"=>$phone,"password"=>$password,"client_company_name"=>$company_name, "work_rate"=>$work_rate,"mileage_rate"=>$mileage_rate , 
"due_date_range"=>$due_date_range,"postal_code"=>$postal_code,"office_address"=>$office_address,"clock_setting"=>$clock,"status"=>1,"company_id"=>$company_id,"return_mileage"=>$editreturnMileage);
$jnparams = $data1;
$uid=$id;
if(empty($jnparams)){
        return true;
    }
    $conditions = [];
    $uid = (int) $uid;
    foreach ($jnparams as $column => $value) {
        $conditions[] = "`{$column}` = '{$value}'";
    }
    $conditions = implode(',', $conditions);
    $sql= "UPDATE company_clients  SET {$conditions} WHERE id = {$uid}"; 
if($db->query($sql) === TRUE){
    $status=1;
        $message="Record Updated successfully.";
} else {
        $status=0;
        $message="Record not updated.". $db->error;
}

$db->close();
$data1= array("Status"=>$status,"Message"=>$message);
echo json_encode($data1);
}
?>