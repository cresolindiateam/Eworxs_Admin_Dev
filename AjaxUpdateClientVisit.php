<?php
ini_set('date.timezone', 'Asia/Kolkata');
require 'dbconfig.php';

$db = db_connect();
// sql to delete a record
if(isset($_REQUEST['editclientid']))
{
  $id=$_REQUEST['editclientid'];
   $sql = "SELECT clientvisites.*,employees.first_name,employees.phone as mobile,employees.password as password FROM clientvisites  JOIN employees ON(clientvisites.employee_id=employees.id)  WHERE  clientvisites.id= $id";

   $exe = $db->query($sql);
  $data = $exe->fetch_all(MYSQLI_ASSOC);
 $emp_name = $data[0]['first_name'];
$phone = $data[0]['mobile'];
$password = $data[0]['password'];

$data1= array("EmpName"=>$emp_name,"password"=>$password,"phone"=>$phone);


echo json_encode($data1);
}

?>