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
$id=$_REQUEST["id"];
$db = db_connect();
// $sql = "DELETE FROM company_clients WHERE id=$id";

$sql = "update company_clients set status=0 WHERE id=$id";
if ($db->query($sql) === TRUE) {
    $status=1;
		$message="Record deleted successfully.";
} else {
        $status=0;
		$message="Record not deleted.". $db->error;
}
$db->close();
$data1= array("Status"=>$status,"Message"=>$message);
echo json_encode($data1);
}
?>