<?php 

require 'dbconfig.php';   
$db=db_connect();
session_start();

$company_id = $_SESSION["companyid"];


  $sql = "SELECT status from companies where id = $company_id";
  

  $exe = $db->query($sql);

  $data = $exe->fetch_all(MYSQLI_ASSOC);


   echo $data[0]['status'];


?>