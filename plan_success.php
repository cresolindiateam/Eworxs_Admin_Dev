<?php
ini_set('date.timezone', 'Asia/Kolkata');
require_once('stripe/init.php');
require 'dbconfig.php';
session_start();

$plan_id=$_REQUEST["plan_id"];
$company_id = $_REQUEST['company_id'];

$db = db_connect();


$sqlInsert = "INSERT INTO client_subscriptions(plan_id,subscription_id,company_id,status,created_at)VALUES('$plan_id','','$company_id',1,now())";
$exeInsert = $db->query($sqlInsert);
$last_id = $db->insert_id;
if(!empty($last_id)){
  $db->close();
  $data1= array("Status"=>1,"Message"=>"Plan has been purchased.");
  echo json_encode($data1);
}else{
  $db->close();
  $data1= array("Status"=>0,"Message"=>"Plan did not purchase.");
  echo json_encode($data1);
}

?>