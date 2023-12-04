<?php
ini_set('date.timezone', 'Asia/Kolkata');

require 'dbconfig.php';


$db = db_connect();
// sql to delete a record
if(isset($_REQUEST['editclientid']))
{
  $id=$_REQUEST['editclientid'];
  
  echo $id;


}

?>