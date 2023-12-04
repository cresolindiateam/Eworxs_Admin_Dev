<?php
ini_set('date.timezone', 'Asia/Kolkata');

require 'dbconfig.php';

$id=$_REQUEST["id"];
$status=$_REQUEST["status"];
$db = db_connect();
// sql to delete a record
$sql = "UPDATE plans SET status=$status WHERE id=$id";
if($db->query($sql)===TRUE){
    $status=1;
    if($status==1){
    	$message="Plan activated successfully.";
    }else{
    	$message="Plan deactivated successfully.";
    }
}else{
    $status=0;
    if($status==1){
    	$message="Plan did not activate.";
    }else{
    	$message="Plan did not deactivate.";
    }
}

$db->close();

$data1= array("Status"=>$status,"Message"=>$message);
echo json_encode($data1);
?>